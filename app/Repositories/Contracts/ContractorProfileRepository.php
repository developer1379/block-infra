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
        // UPDATE PROFILE PHOTO
        // ---------------------------
        if (isset($data['image'])) {

            if ($contractor->image && Storage::disk('public')->exists($contractor->image)) {
                Storage::disk('public')->delete($contractor->image);
            }

            $filePath = $data['image']->store('contractors/photos', 'public');

            $contractor->image = $filePath;  // ✔ save to contractor
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
