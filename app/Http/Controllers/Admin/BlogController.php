<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'title', 'slug', 'content', 'meta_title', 'meta_description', 'meta_keywords'
        ]);

        $data['is_published'] = $request->has('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;

        if ($request->hasFile('image')) {
            try {
                $imageUrl = $this->uploadToImgBB($request->file('image'));
                $data['image'] = $imageUrl;
            } catch (\Exception $e) {
                logger()->error('ImgBB upload failed, falling back to local storage: ' . $e->getMessage());
                $imagePath = $request->file('image')->store('blogs', 'public');
                $data['image'] = $imagePath;
            }
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'title', 'slug', 'content', 'meta_title', 'meta_description', 'meta_keywords'
        ]);

        $data['is_published'] = $request->has('is_published');
        
        // Handle publishing timestamp toggling
        if ($data['is_published']) {
            if (!$blog->is_published) {
                $data['published_at'] = now();
            }
        } else {
            $data['published_at'] = null;
        }

        if ($request->hasFile('image')) {
            // Delete old local image if it exists
            if ($blog->image && !filter_var($blog->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($blog->image);
            }
            
            try {
                $imageUrl = $this->uploadToImgBB($request->file('image'));
                $data['image'] = $imageUrl;
            } catch (\Exception $e) {
                logger()->error('ImgBB upload failed, falling back to local storage: ' . $e->getMessage());
                $imagePath = $request->file('image')->store('blogs', 'public');
                $data['image'] = $imagePath;
            }
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->image && !filter_var($blog->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($blog->image);
        }
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted successfully!');
    }

    /**
     * Upload an image to ImgBB and return its public URL.
     */
    private function uploadToImgBB($file)
    {
        $apiKey = env('IMGBB_API_KEY') ?? Setting::where('key', 'imgbb_api_key')->value('value');
        
        if (empty($apiKey)) {
            throw new \Exception('ImgBB API Key is not configured. Please set IMGBB_API_KEY in your .env or Settings page.');
        }

        $response = Http::asMultipart()
            ->post('https://api.imgbb.com/1/upload?key=' . $apiKey, [
                'image' => fopen($file->getPathname(), 'r'),
            ]);

        if ($response->successful()) {
            return $response->json('data.url');
        }

        throw new \Exception('ImgBB upload failed: ' . ($response->json('error.message') ?? 'Unknown error'));
    }
}
