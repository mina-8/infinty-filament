<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RegisterGuestController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/RegisterGuest');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255',
            'phone' => ['required', 'string', 'regex:/^5\d{9}$/'],
            'area' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'block' => 'required|string|max:255',
            'building' => 'required|string|max:255',
            'complex' => 'nullable|string|max:255',
            'floore_number' => 'nullable|string|max:255',
            'flate_number' => 'nullable|string|max:255',
            'land_mark' => 'nullable|string|max:255',

        ]);
        
    }
}
