<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('website.auth.login');
    }

    public function registerPage()
    {
        return view('website.auth.signup');
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
                    'user_id' => $user->id,
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

            event(new Registered($user));

            Auth::login($user);
            \DB::commit();

            if ($user->hasRole('user')) {
                return redirect()->route('admin.user');
            }

            if ($user->hasRole('contractor')) {
                return redirect()->route('contractor.dashboard.index');
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

        if (Auth::attempt($credentials, $request->boolean('remember', true))) {
            $request->session()->regenerate();

            if (auth()->user()->hasRole('user')) {
                return redirect()->route('admin.user');
            }

            if (auth()->user()->hasRole('contractor')) {
                return redirect()->route('contractor.dashboard.index');
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

    // --- Forgot / Reset Password Methods ---

    public function forgotPasswordPage()
    {
        return view('website.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function resetPasswordPage(Request $request, $token)
    {
        return view('website.auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('website.login')->with('success', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    // --- Email Verification Methods ---

    public function verifyNotice()
    {
        return auth()->user()->hasVerifiedEmail()
            ? redirect()->route('dashboard')
            : view('website.auth.verify-email');
    }

    public function verifyEmail(\Illuminate\Foundation\Auth\EmailVerificationRequest $request)
    {
        $request->fulfill();

        $user = $request->user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard')->with('success', 'Email verified successfully!');
        }
        if ($user->hasRole('contractor')) {
            return redirect()->route('contractor.dashboard.index')->with('success', 'Email verified successfully!');
        }
        if ($user->hasRole('user')) {
            return redirect()->route('admin.user')->with('success', 'Email verified successfully!');
        }

        return redirect()->route('dashboard')->with('success', 'Email verified successfully!');
    }

    public function verifyResend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'A new verification link has been sent to your email address.');
    }
}

