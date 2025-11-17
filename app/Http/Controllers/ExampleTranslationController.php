<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ExampleTranslationController extends Controller
{
    /**
     * Display the translation example page
     */
    public function index()
    {
        return view('examples.translation-example');
    }

    /**
     * Example: Using translations in controller
     */
    public function store(Request $request)
    {
        // Validate with translated messages
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        // Success message with translation
        return redirect()->back()->with('success', __('saved_successfully'));
    }

    /**
     * Example: Get current locale
     */
    public function getCurrentLocale()
    {
        $locale = app()->getLocale(); // ar, en, fr, tr
        $nativeName = LaravelLocalization::getCurrentLocaleNative(); // العربية, English, etc.
        $direction = LaravelLocalization::getCurrentLocaleDirection(); // rtl or ltr

        return response()->json([
            'locale' => $locale,
            'native_name' => $nativeName,
            'direction' => $direction,
        ]);
    }

    /**
     * Example: Change locale programmatically
     */
    public function changeLocale($locale)
    {
        if (in_array($locale, ['ar', 'en'])) {
            app()->setLocale($locale);
            session()->put('locale', $locale);
            
            return redirect()->back()->with('success', __('language_changed'));
        }

        return redirect()->back()->with('error', __('invalid_language'));
    }

    /**
     * Example: Get all supported locales
     */
    public function getSupportedLocales()
    {
        $locales = LaravelLocalization::getSupportedLocales();
        
        return response()->json($locales);
    }

    /**
     * Example: Using translations in flash messages
     */
    public function exampleFlashMessages()
    {
        // Success message
        session()->flash('success', __('success'));
        
        // Error message
        session()->flash('error', __('error'));
        
        // Warning message
        session()->flash('warning', __('warning'));
        
        // Info message
        session()->flash('info', __('info'));
        
        return redirect()->back();
    }
}