<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Work;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class WebsiteController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('website.index');
    }

    /**
     * Display the about page.
     */
    public function about()
    {
        return view('website.about');
    }

    /**
     * Display the construction page.
     */
    public function construction()
    {
        return view('website.construction');
    }

    /**
     * Display the infrastructure page.
     */
    public function infrastructure()
    {
        return view('website.infrastructure');
    }

    /**
     * Display the project management page.
     */
    public function projectManagement()
    {
        return view('website.project-management');
    }

    /**
     * Display the design & consulting page.
     */
    public function designConsulting()
    {
        return view('website.design-consulting');
    }

    /**
     * Display the clients page.
     */
    public function clients()
    {
        return view('website.clients');
    }

    /**
     * Display the FAQs page.
     */
    public function faqs()
    {
        return view('website.faqs');
    }

    /**
     * Display the DigitalShramik page.
     */
    public function digitalShramik()
    {
        return view('website.digitalshramik');
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        session(['captcha_answer' => $num1 + $num2]);

        return view('website.contact', compact('num1', 'num2'));
    }

    /**
     * Handle the contact form submission.
     */
    public function contactSubmit(Request $request)
    {
        // 1. Honeypot check (anti-spam)
        if ($request->filled('website_url')) {
            return redirect()->route('website.contact')
                ->with('success', 'Thank you! Your message has been sent successfully.');
        }

        // 2. Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'captcha' => 'required|integer',
        ], [
            'captcha.required' => 'Please solve the math verification captcha.',
            'captcha.integer' => 'The captcha answer must be an integer.',
        ]);

        // 3. CAPTCHA verification
        if ($request->input('captcha') != session('captcha_answer')) {
            return back()->withInput()->withErrors(['captcha' => 'Verification code failed. Please try again.']);
        }

        // 4. Clear CAPTCHA session answer to prevent replay attacks
        session()->forget('captcha_answer');

        // 5. Send Mail
        try {
            // Load dynamic mail settings from database settings table
            $settings = Setting::pluck('value', 'key')->toArray();

            if (!empty($settings['mail_host'])) {
                config([
                    'mail.mailers.smtp.transport' => $settings['mail_mailer'] ?? 'smtp',
                    'mail.mailers.smtp.host' => $settings['mail_host'],
                    'mail.mailers.smtp.port' => $settings['mail_port'] ?? 587,
                    'mail.mailers.smtp.username' => $settings['mail_username'] ?? null,
                    'mail.mailers.smtp.password' => $settings['mail_password'] ?? null,
                    'mail.mailers.smtp.encryption' => $settings['mail_encryption'] ?? null,
                    'mail.from.address' => $settings['mail_from_address'] ?? 'info@blocinfra.in',
                    'mail.from.name' => $settings['mail_from_name'] ?? config('app.name'),
                ]);

                Mail::purge('smtp');
            }

            $mailData = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'subject' => $request->input('subject'),
                'message' => $request->input('message'),
            ];

            $recipient = $settings['mail_from_address'] ?? 'info@blocinfra.in';

            Mail::to($recipient)->send(new ContactMail($mailData));

            return redirect()->route('website.contact')
                ->with('success', 'Thank you! Your message has been sent successfully.');

        } catch (\Exception $e) {
            logger()->error('Mail sending failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['mail_error' => 'Unable to send email at this time. Please try again later.']);
        }
    }

    /**
     * Display the login page.
     */
    public function login()
    {
        return view('website.auth.login');
    }

    /**
     * Display the signup (register) page.
     */
    public function signup()
    {
        return view('website.auth.signup');
    }

    public function calculator()
    {
        $categories = Category::where('is_active', 1)->orderBy('name')->get();

        $works = Work::with('unit')
            ->where('is_active', 1)
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();

        return view('website.calculator', compact('categories', 'works'));
    }

    /**
     * Generate dynamic sitemap.xml.
     */
    public function sitemap()
    {
        $now = now()->toAtomString();

        $routes = [
            ['loc' => route('website.home'), 'lastmod' => $now, 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => route('website.about'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('website.construction'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('website.infrastructure'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('website.project-management'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('website.design-consulting'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('website.clients'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => route('website.faqs'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => route('website.digitalshramik'), 'lastmod' => $now, 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => route('website.contact'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => route('website.calculator'), 'lastmod' => $now, 'changefreq' => 'monthly', 'priority' => '0.7'],
        ];

        return response()->view('website.sitemap', compact('routes'))
            ->header('Content-Type', 'text/xml');
    }
}

