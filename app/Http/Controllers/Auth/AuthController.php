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
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:contractor,user',

            // For multiple categories (array)
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',

            'company_name' => 'nullable|string|max:255',
            'phone'        => 'nullable|string|max:20',
            'city'         => 'nullable|string|max:100',
        ]);

        \DB::beginTransaction();
        try {
            // Create User
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Assign role
            $role = Role::findOrCreate($request->role, 'web');
            $user->assignRole($role);

            if ($request->role === 'contractor') {

                $contractor = \App\Models\Contractor::create([
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'phone'        => $request->phone,
                    'company_name' => $request->company_name,
                    'city'         => $request->city,
                    'is_active'    => false,  // wait for admin approval
                ]);

                if ($request->filled('categories')) {
                    $contractor->categories()->sync($request->categories);
                }

                \Log::info("🆕 Contractor registered with multi-categories", [
                    'contractor_id' => $contractor->id,
                    'categories'    => $request->categories,
                ]);
            }

            Auth::login($user);
            \DB::commit();

            return redirect()->route('dashboard')
                ->with('success', 'Registration successful!');
        } catch (\Throwable $e) {

            \DB::rollBack();

            \Log::error(' Contractor Registration Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withInput()->with('error', 'Registration failed. Please try again.');
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Invalid credentials provided.']);
        }

        // Check contractor activation
        if ($user->hasRole('contractor')) {

            $contractor = \App\Models\Contractor::where('email', $user->email)->first();

            if ($contractor && $contractor->is_active == 0) {
                return back()->withErrors([
                    'email' => 'Your contractor account is inactive. Please contact the administrator.',
                ]);
            }
        }

        // Attempt login
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
