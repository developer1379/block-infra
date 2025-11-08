<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;


class AuthController extends Controller
{
    // Show login page
    public function loginPage()
    {
        return view('website.pages.auth.login');
    }

    // Show register page
    public function registerPage()
    {
        return view('website.pages.auth.signup');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:contractor,user',
            'contractor_category' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
        ]);

        \DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Ensure the role exists
            $role = Role::findOrCreate($request->role, 'web');
            $user->assignRole($role);

            // 🔗 If contractor, also create linked Contractor record
            if ($request->role === 'contractor') {
                $contractor = \App\Models\Contractor::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'company_name' => $request->company_name,
                    'category' => $request->contractor_category,
                    'city' => $request->city,
                    'is_active' => false, // default inactive until admin approves
                ]);

                \Log::info('🆕 Contractor registered', [
                    'contractor_id' => $contractor->id,
                    'user_email' => $user->email,
                    'category' => $contractor->category,
                ]);
            }

            Auth::login($user);

            \DB::commit();
            return redirect()->route('dashboard')->with('success', 'Registration successful!');
        } catch (\Throwable $e) {
            \DB::rollBack();
            \Log::error('❌ Registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withInput()->with('error', 'Registration failed. Please try again.');
        }
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials provided.',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('website.login')->with('success', 'Logged out successfully.');
    }
}
