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

    public function scanImages(Request $request)
    {
        $apiKey = Setting::where('key', 'imgbb_api_key')->value('value');
        if (empty($apiKey)) {
            return response()->json(['success' => false, 'message' => 'Please configure your ImgBB API Key before scanning.'], 400);
        }

        $items = [];

        try {
            // 1. Blogs
            $blogs = \App\Models\Blog::whereNotNull('image')->where('image', '!=', '')->get();
            foreach ($blogs as $blog) {
                if (!filter_var($blog->image, FILTER_VALIDATE_URL)) {
                    $path = Storage::disk('public')->path($blog->image);
                    if (file_exists($path)) {
                        $items[] = ['type' => 'blog', 'id' => $blog->id];
                    }
                }
            }

            // 2. Contractors
            $contractors = \App\Models\Contractor::whereNotNull('image')->where('image', '!=', '')->get();
            foreach ($contractors as $contractor) {
                if (!filter_var($contractor->image, FILTER_VALIDATE_URL)) {
                    if (str_starts_with($contractor->image, 'data:image') || preg_match('/^[A-Za-z0-9+\/=]+$/', $contractor->image)) {
                        $items[] = ['type' => 'contractor', 'id' => $contractor->id];
                    } else {
                        $path = Storage::disk('public')->path($contractor->image);
                        if (file_exists($path)) {
                            $items[] = ['type' => 'contractor', 'id' => $contractor->id];
                        }
                    }
                }
            }

            // 3. SitePhotos
            $photos = \App\Models\SitePhoto::whereNotNull('photo_path')->where('photo_path', '!=', '')->get();
            foreach ($photos as $photo) {
                if (!filter_var($photo->photo_path, FILTER_VALIDATE_URL)) {
                    $path = Storage::disk('public')->path($photo->photo_path);
                    if (file_exists($path)) {
                        $items[] = ['type' => 'site_photo', 'id' => $photo->id];
                    }
                }
            }

            // 4. Feedbacks
            $feedbacks = \App\Models\Feedback::whereNotNull('attachment')->where('attachment', '!=', '')->get();
            foreach ($feedbacks as $feedback) {
                if (!filter_var($feedback->attachment, FILTER_VALIDATE_URL)) {
                    $path = Storage::disk('public')->path($feedback->attachment);
                    if (file_exists($path)) {
                        $items[] = ['type' => 'feedback', 'id' => $feedback->id];
                    }
                }
            }

            // 5. ProjectAttendances
            $attendances = \App\Models\ProjectAttendance::whereNotNull('verification_photo')->where('verification_photo', '!=', '')->get();
            foreach ($attendances as $att) {
                if (!filter_var($att->verification_photo, FILTER_VALIDATE_URL)) {
                    if (str_starts_with($att->verification_photo, 'data:image') || preg_match('/^[A-Za-z0-9+\/=]+$/', $att->verification_photo)) {
                        $items[] = ['type' => 'attendance', 'id' => $att->id];
                    } else {
                        $path = Storage::disk('public')->path($att->verification_photo);
                        if (file_exists($path)) {
                            $items[] = ['type' => 'attendance', 'id' => $att->id];
                        }
                    }
                }
            }

            // 6. ProjectProgressUpdates
            $updates = \App\Models\ProjectProgressUpdate::whereNotNull('report_file_path')->where('report_file_path', '!=', '')->get();
            foreach ($updates as $update) {
                if (!filter_var($update->report_file_path, FILTER_VALIDATE_URL)) {
                    $ext = strtolower(pathinfo($update->report_file_path, PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'])) {
                        $path = Storage::disk('public')->path($update->report_file_path);
                        if (file_exists($path)) {
                            $items[] = ['type' => 'progress_update', 'id' => $update->id];
                        }
                    }
                }
            }

            // 7. Workers
            $workers = \App\Models\Worker::whereNotNull('identity_proof')->where('identity_proof', '!=', '')->get();
            foreach ($workers as $worker) {
                if (!filter_var($worker->identity_proof, FILTER_VALIDATE_URL)) {
                    $ext = strtolower(pathinfo($worker->identity_proof, PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'])) {
                        $path = Storage::disk('public')->path($worker->identity_proof);
                        if (file_exists($path)) {
                            $items[] = ['type' => 'worker', 'id' => $worker->id];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Scan error: ' . $e->getMessage()], 500);
        }

        return response()->json([
            'success' => true,
            'total' => count($items),
            'items' => $items
        ]);
    }

    public function syncSingleItem(Request $request)
    {
        $apiKey = Setting::where('key', 'imgbb_api_key')->value('value');
        if (empty($apiKey)) {
            return response()->json(['success' => false, 'message' => 'API key missing.'], 400);
        }

        $type = $request->input('type');
        $id = $request->input('id');

        if (empty($type) || empty($id)) {
            return response()->json(['success' => false, 'message' => 'Type and ID are required.'], 400);
        }

        $imgBB = app(\App\Services\ImgBBService::class);

        try {
            switch ($type) {
                case 'blog':
                    $blog = \App\Models\Blog::findOrFail($id);
                    $path = Storage::disk('public')->path($blog->image);
                    $url = $imgBB->upload($path);
                    $blog->update(['image' => $url]);
                    return response()->json(['success' => true, 'message' => "Blog #{$id}: Synced successfully."]);

                case 'contractor':
                    $contractor = \App\Models\Contractor::findOrFail($id);
                    if (str_starts_with($contractor->image, 'data:image') || preg_match('/^[A-Za-z0-9+\/=]+$/', $contractor->image)) {
                        $url = $imgBB->upload($contractor->image);
                    } else {
                        $path = Storage::disk('public')->path($contractor->image);
                        $url = $imgBB->upload($path);
                    }
                    $contractor->update(['image' => $url]);
                    return response()->json(['success' => true, 'message' => "Contractor #{$id}: Synced successfully."]);

                case 'site_photo':
                    $photo = \App\Models\SitePhoto::findOrFail($id);
                    $path = Storage::disk('public')->path($photo->photo_path);
                    $url = $imgBB->upload($path);
                    $photo->update(['photo_path' => $url]);
                    return response()->json(['success' => true, 'message' => "Site Photo #{$id}: Synced successfully."]);

                case 'feedback':
                    $feedback = \App\Models\Feedback::findOrFail($id);
                    $path = Storage::disk('public')->path($feedback->attachment);
                    $url = $imgBB->upload($path);
                    $feedback->update(['attachment' => $url]);
                    return response()->json(['success' => true, 'message' => "Feedback #{$id}: Synced successfully."]);

                case 'attendance':
                    $att = \App\Models\ProjectAttendance::findOrFail($id);
                    if (str_starts_with($att->verification_photo, 'data:image') || preg_match('/^[A-Za-z0-9+\/=]+$/', $att->verification_photo)) {
                        $url = $imgBB->upload($att->verification_photo);
                    } else {
                        $path = Storage::disk('public')->path($att->verification_photo);
                        $url = $imgBB->upload($path);
                    }
                    $att->update(['verification_photo' => $url]);
                    return response()->json(['success' => true, 'message' => "Attendance #{$id}: Synced successfully."]);

                case 'progress_update':
                    $update = \App\Models\ProjectProgressUpdate::findOrFail($id);
                    $path = Storage::disk('public')->path($update->report_file_path);
                    $url = $imgBB->upload($path);
                    $update->update(['report_file_path' => $url]);
                    return response()->json(['success' => true, 'message' => "Progress Update #{$id}: Synced successfully."]);

                case 'worker':
                    $worker = \App\Models\Worker::findOrFail($id);
                    $path = Storage::disk('public')->path($worker->identity_proof);
                    $url = $imgBB->upload($path);
                    $worker->update(['identity_proof' => $url]);
                    return response()->json(['success' => true, 'message' => "Worker #{$id}: Synced successfully."]);

                default:
                    return response()->json(['success' => false, 'message' => "Unsupported type: {$type}"], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => ucfirst($type) . " #{$id}: " . $e->getMessage()], 500);
        }
    }
}
