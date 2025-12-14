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
    public function loginPage()
    {
        return view('website.pages.auth.login');
    }

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
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
        ]);

        \DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $role = Role::findOrCreate($request->role, 'web');
            $user->assignRole($role);

            if ($request->role === 'contractor') {
                $contractor = \App\Models\Contractor::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'company_name' => $request->company_name,
                    'city' => $request->city,
                    'is_active' => false,
                ]);

                if ($request->filled('categories')) {
                    $contractor->categories()->sync($request->categories);
                }
            }

            Auth::login($user);
            \DB::commit();

            if ($user->hasRole('user')) {
                return redirect()->route('admin.user');
            }

            if ($user->hasRole('contractor')) {
                return redirect()->route('contractor.dashboard');
            }

            return redirect()->route('dashboard');
        } catch (\Throwable $e) {
            \DB::rollBack();

            \Log::error('Registration Failed', [
                'error' => $e->getMessage(),
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

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Invalid credentials provided.']);
        }

        if ($user->hasRole('contractor')) {
            $contractor = \App\Models\Contractor::where('email', $user->email)->first();
            if ($contractor && $contractor->is_active == 0) {
                return back()->withErrors([
                    'email' => 'Your contractor account is inactive. Please contact the administrator.',
                ]);
            }
        }

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            if (auth()->user()->hasRole('user')) {
                return redirect()->route('admin.user');
            }

            if (auth()->user()->hasRole('contractor')) {
                return redirect()->route('contractor.dashboard');
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials provided.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('website.login')->with('success', 'Logged out successfully.');
    }
}
