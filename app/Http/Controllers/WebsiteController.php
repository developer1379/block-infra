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
}

