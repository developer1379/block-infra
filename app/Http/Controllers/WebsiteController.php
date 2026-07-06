<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Work;
use Illuminate\Http\Request;

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
        return view('website.contact');
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

