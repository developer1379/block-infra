<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

class ImgBBService
{
    /**
     * Upload an image to ImgBB.
     *
     * @param mixed $file Can be UploadedFile, local file path, base64 string, or raw content
     * @return string The uploaded image URL
     * @throws \Exception
     */
    public function upload($file): string
    {
        $apiKey = Setting::where('key', 'imgbb_api_key')->value('value');
        
        if (empty($apiKey)) {
            throw new \Exception('ImgBB API Key is not configured. Please configure it in your Settings page.');
        }

        // 1. Get raw binary data from the file source
        $rawData = null;
        if ($file instanceof UploadedFile) {
            $rawData = file_get_contents($file->getPathname());
        } elseif (is_string($file)) {
            // Check if base64 encoded image
            if (str_starts_with($file, 'data:image') || preg_match('/^([A-Za-z0-9+\/]{4})*([A-Za-z0-9+\/]{4}|[A-Za-z0-9+\/]{3}=|[A-Za-z0-9+\/]{2}==)$/', $file)) {
                if (strpos($file, ',') !== false) {
                    $fileData = explode(',', $file)[1];
                } else {
                    $fileData = $file;
                }
                $rawData = base64_decode($fileData);
            } elseif (file_exists($file)) {
                $rawData = file_get_contents($file);
            }
        }

        if (empty($rawData)) {
            throw new \InvalidArgumentException('Unsupported file type or empty file content.');
        }

        // 2. Convert to WebP format
        $webpPath = $this->convertToWebP($rawData);

        // 3. Upload to ImgBB and clean up
        try {
            $response = Http::asMultipart()->post('https://api.imgbb.com/1/upload?key=' . $apiKey, [
                'image' => fopen($webpPath, 'r'),
            ]);

            if (file_exists($webpPath)) {
                @unlink($webpPath);
            }
        } catch (\Exception $e) {
            if (file_exists($webpPath)) {
                @unlink($webpPath);
            }
            throw $e;
        }

        if ($response->successful()) {
            $url = $response->json('data.url');
            if ($url) {
                return $url;
            }
        }

        $errorMsg = $response->json('error.message') ?? 'Unknown error';
        Log::error('ImgBB upload failed: ' . $errorMsg);
        throw new \Exception('ImgBB upload failed: ' . $errorMsg);
    }

    /**
     * Convert binary image data to a temporary WebP file.
     *
     * @param string $data The raw binary image data
     * @return string Path to the temporary WebP file
     * @throws \Exception
     */
    protected function convertToWebP(string $data): string
    {
        $im = @imagecreatefromstring($data);
        if ($im === false) {
            throw new \Exception('Failed to process image data: Invalid or unsupported image format.');
        }

        // Retain alpha channel transparency
        imagealphablending($im, false);
        imagesavealpha($im, true);
        
        $tempFile = tempnam(sys_get_temp_dir(), 'imgbb_');
        $tempWebpPath = $tempFile . '.webp';
        
        if (!imagewebp($im, $tempWebpPath, 85)) {
            imagedestroy($im);
            throw new \Exception('Failed to convert image to WebP format.');
        }
        
        imagedestroy($im);
        
        // Clean up tempnam file (since we appended .webp)
        if (file_exists($tempFile)) {
            @unlink($tempFile);
        }
        
        return $tempWebpPath;
    }
}
