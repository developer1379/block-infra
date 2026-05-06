<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Switch the application locale.
     */
    public function setLocale($locale)
    {
        $availableLocales = ['en', 'hi', 'gu', 'mr']; // Added some common Indian languages

        if (in_array($locale, $availableLocales)) {
            Session::put('locale', $locale);
        }

        return back();
    }
}
