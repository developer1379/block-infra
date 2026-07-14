<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'mail_mailer' => 'required|string',
            'mail_host' => 'required|string',
            'mail_port' => 'required|numeric',
            'mail_username' => 'required|string',
            'mail_password' => 'required|string',
            'mail_encryption' => 'nullable|string',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
            'imgbb_api_key' => 'nullable|string|max:255',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Email settings updated successfully!');
    }

    public function syncImages(Request $request)
    {
        $apiKey = Setting::where('key', 'imgbb_api_key')->value('value');
        if (empty($apiKey)) {
            return redirect()->back()->with('error', 'Please configure your ImgBB API Key before syncing.');
        }

        $imgBB = app(\App\Services\ImgBBService::class);
        $syncedCount = 0;
        $errors = [];

        try {
            // 1. Sync Blogs
            $blogs = \App\Models\Blog::whereNotNull('image')->where('image', '!=', '')->get();
            foreach ($blogs as $blog) {
                if (!filter_var($blog->image, FILTER_VALIDATE_URL)) {
                    $path = Storage::disk('public')->path($blog->image);
                    if (file_exists($path)) {
                        try {
                            $blog->update(['image' => $imgBB->upload($path)]);
                            $syncedCount++;
                        } catch (\Exception $e) {
                            $errors[] = "Blog #{$blog->id}: " . $e->getMessage();
                        }
                    }
                }
            }

            // 2. Sync Contractors (Base64 or local path)
            $contractors = \App\Models\Contractor::whereNotNull('image')->where('image', '!=', '')->get();
            foreach ($contractors as $contractor) {
                if (!filter_var($contractor->image, FILTER_VALIDATE_URL)) {
                    // Check if base64
                    if (str_starts_with($contractor->image, 'data:image') || preg_match('/^[A-Za-z0-9+\/=]+$/', $contractor->image)) {
                        try {
                            $contractor->update(['image' => $imgBB->upload($contractor->image)]);
                            $syncedCount++;
                        } catch (\Exception $e) {
                            $errors[] = "Contractor #{$contractor->id}: " . $e->getMessage();
                        }
                    } else {
                        // Relative path
                        $path = Storage::disk('public')->path($contractor->image);
                        if (file_exists($path)) {
                            try {
                                $contractor->update(['image' => $imgBB->upload($path)]);
                                $syncedCount++;
                            } catch (\Exception $e) {
                                $errors[] = "Contractor #{$contractor->id}: " . $e->getMessage();
                            }
                        }
                    }
                }
            }

            // 3. Sync SitePhotos
            $photos = \App\Models\SitePhoto::whereNotNull('photo_path')->where('photo_path', '!=', '')->get();
            foreach ($photos as $photo) {
                if (!filter_var($photo->photo_path, FILTER_VALIDATE_URL)) {
                    $path = Storage::disk('public')->path($photo->photo_path);
                    if (file_exists($path)) {
                        try {
                            $photo->update(['photo_path' => $imgBB->upload($path)]);
                            $syncedCount++;
                        } catch (\Exception $e) {
                            $errors[] = "SitePhoto #{$photo->id}: " . $e->getMessage();
                        }
                    }
                }
            }

            // 4. Sync Feedback
            $feedbacks = \App\Models\Feedback::whereNotNull('attachment')->where('attachment', '!=', '')->get();
            foreach ($feedbacks as $feedback) {
                if (!filter_var($feedback->attachment, FILTER_VALIDATE_URL)) {
                    $path = Storage::disk('public')->path($feedback->attachment);
                    if (file_exists($path)) {
                        try {
                            $feedback->update(['attachment' => $imgBB->upload($path)]);
                            $syncedCount++;
                        } catch (\Exception $e) {
                            $errors[] = "Feedback #{$feedback->id}: " . $e->getMessage();
                        }
                    }
                }
            }

            // 5. Sync ProjectAttendance
            $attendances = \App\Models\ProjectAttendance::whereNotNull('verification_photo')->where('verification_photo', '!=', '')->get();
            foreach ($attendances as $att) {
                if (!filter_var($att->verification_photo, FILTER_VALIDATE_URL)) {
                    if (str_starts_with($att->verification_photo, 'data:image') || preg_match('/^[A-Za-z0-9+\/=]+$/', $att->verification_photo)) {
                        try {
                            $att->update(['verification_photo' => $imgBB->upload($att->verification_photo)]);
                            $syncedCount++;
                        } catch (\Exception $e) {
                            $errors[] = "ProjectAttendance #{$att->id}: " . $e->getMessage();
                        }
                    } else {
                        $path = Storage::disk('public')->path($att->verification_photo);
                        if (file_exists($path)) {
                            try {
                                $att->update(['verification_photo' => $imgBB->upload($path)]);
                                $syncedCount++;
                            } catch (\Exception $e) {
                                $errors[] = "ProjectAttendance #{$att->id}: " . $e->getMessage();
                            }
                        }
                    }
                }
            }

            // 6. Sync ProjectProgressUpdate (Images only)
            $updates = \App\Models\ProjectProgressUpdate::whereNotNull('report_file_path')->where('report_file_path', '!=', '')->get();
            foreach ($updates as $update) {
                if (!filter_var($update->report_file_path, FILTER_VALIDATE_URL)) {
                    $ext = strtolower(pathinfo($update->report_file_path, PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'])) {
                        $path = Storage::disk('public')->path($update->report_file_path);
                        if (file_exists($path)) {
                            try {
                                $update->update(['report_file_path' => $imgBB->upload($path)]);
                                $syncedCount++;
                            } catch (\Exception $e) {
                                $errors[] = "ProjectProgressUpdate #{$update->id}: " . $e->getMessage();
                            }
                        }
                    }
                }
            }

            // 7. Sync Worker (Images only)
            $workers = \App\Models\Worker::whereNotNull('identity_proof')->where('identity_proof', '!=', '')->get();
            foreach ($workers as $worker) {
                if (!filter_var($worker->identity_proof, FILTER_VALIDATE_URL)) {
                    $ext = strtolower(pathinfo($worker->identity_proof, PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'])) {
                        $path = Storage::disk('public')->path($worker->identity_proof);
                        if (file_exists($path)) {
                            try {
                                $worker->update(['identity_proof' => $imgBB->upload($path)]);
                                $syncedCount++;
                            } catch (\Exception $e) {
                                $errors[] = "Worker #{$worker->id}: " . $e->getMessage();
                            }
                        }
                    }
                }
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sync encountered an error: ' . $e->getMessage());
        }

        $message = "Successfully synced {$syncedCount} images to ImgBB.";
        if (count($errors) > 0) {
            $message .= " Encountered " . count($errors) . " errors during migration.";
        }

        return redirect()->back()->with('success', $message);
    }
}
