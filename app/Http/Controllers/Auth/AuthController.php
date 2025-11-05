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

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:contractor,user',
            'contractor_category' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contractor_category' => $request->role === 'contractor' ? $request->contractor_category : null,
        ]);

        // ✅ ensure the role exists for the 'web' guard
        Role::findOrCreate($request->role, 'web');

        $user->assignRole($request->role);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful!');
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
