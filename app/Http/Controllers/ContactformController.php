<?php

namespace App\Http\Controllers;

use App\Models\Contactform;
use App\Models\Newsletter;
use App\Models\OurRegionalOffice;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactformController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(string $lang , Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        Newsletter::create($validated);

        return redirect()->back()->with('success', 'Your message has been sent.');
    }

}
