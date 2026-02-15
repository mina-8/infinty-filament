<?php

namespace App\Http\Controllers;

use App\Models\Contactform;
use App\Models\ContactUs;
use App\Models\OurRegionalOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appLang = app()->getLocale();
        return Inertia::render('Welcome/ContactUs/Index');
    }

    public function store(string $lang, Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'country' => 'required|string|max:100',
            'message' => 'required|string|max:2000',
        ]);

        Contactform::create($validated);

        return redirect()->back()->with('success', 'Your message has been sent.');
    }
}
