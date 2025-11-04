<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        return view('website.pages.index');
    }

    /**
     * Display the about page.
     */
    public function about()
    {
        return view('website.pages.about');
    }

    /**
     * Display the construction page.
     */
    public function construction()
    {
        return view('website.pages.construction');
    }

    /**
     * Display the infrastructure page.
     */
    public function infrastructure()
    {
        return view('website.pages.infrastructure');
    }

    /**
     * Display the project management page.
     */
    public function projectManagement()
    {
        return view('website.pages.project-management');
    }

    /**
     * Display the design & consulting page.
     */
    public function designConsulting()
    {
        return view('website.pages.design-consulting');
    }

    /**
     * Display the clients page.
     */
    public function clients()
    {
        return view('website.pages.clients');
    }

    /**
     * Display the FAQs page.
     */
    public function faqs()
    {
        return view('website.pages.faqs');
    }

    /**
     * Display the DigitalShramik page.
     */
    public function digitalShramik()
    {
        return view('website.pages.digitalshramik');
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        return view('website.pages.contact');
    }

    /**
     * Display the login page.
     */
    public function login()
    {
        return view('website.pages.auth.login');
    }

    /**
     * Display the signup (register) page.
     */
    public function signup()
    {
        return view('website.pages.auth.signup');
    }
}
