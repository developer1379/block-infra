<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ContractorProfileRepositoryInterface;

class ProfileController extends Controller
{
    protected $profile;

    public function __construct(ContractorProfileRepositoryInterface $profile)
    {
        $this->profile = $profile;
    }

    /** Show Profile */
    public function index()
    {
        $contractor = $this->profile->getProfile();
        return view('contractor.profile.edit', compact('contractor'));
    }

    /** Update Profile */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email',
            'phone'      => 'nullable|string|max:20',
            'city'       => 'nullable|string|max:100',
            'password'   => 'nullable|min:6|confirmed',
            'image'      => 'nullable|image|max:2048',   // ✔ Corrected
            'categories' => 'array',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image');
        }

        $this->profile->updateProfile($validated);

        return back()->with('success', 'Profile updated successfully!');
    }
}

