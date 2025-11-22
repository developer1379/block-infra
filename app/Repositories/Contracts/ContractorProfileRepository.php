<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Interfaces\ContractorProfileRepositoryInterface;

class ContractorProfileRepository implements ContractorProfileRepositoryInterface
{
    /**
     * Get contractor profile with categories.
     */
    public function getProfile()
    {
        return auth()->user()->load('contractorCategories');
    }

    /**
     * Update contractor profile.
     */
    public function updateProfile(array $data)
    {
        $user = auth()->user();
        $contractor = $user->contractor;   // ✔ correct contractor model

        // ---------------------------
        // UPDATE BASIC DETAILS
        // ---------------------------
        $user->name  = $data['name'];
        $user->email = $data['email'];

        $contractor->email = $data['email'];
        $contractor->phone = $data['phone'] ?? null;
        $contractor->city  = $data['city'] ?? null;

        // ---------------------------
        // UPDATE PASSWORD
        // ---------------------------
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        // ---------------------------
        // UPDATE PROFILE PHOTO (BASE64)
        // ---------------------------
        if (isset($data['image'])) {

            $file = $data['image'];

            // Convert uploaded file to Base64
            $imageData = base64_encode(file_get_contents($file));

            // Get file extension (jpeg/png/etc)
            $extension = $file->getClientOriginalExtension();

            // Build a proper Base64 string format
            $base64Image = "data:image/{$extension};base64,{$imageData}";

            // Save Base64 string in contractor table
            $contractor->image = $base64Image;
        }


        $user->save();
        $contractor->save();

        // ---------------------------
        // UPDATE CATEGORIES
        // ---------------------------
        if (isset($data['categories']) && is_array($data['categories'])) {
            $contractor->categories()->sync($data['categories']); // ✔ contractor_id
        }

        return $user;
    }
}
