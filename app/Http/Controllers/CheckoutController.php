<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
class CheckoutController extends Controller
{
    public function checkout(){
        $user = Auth::user();
        if(!$user){
            return Inertia::render('Welcome/Checkout/Guest' , [
                'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
            ]);
        }else{
            return Inertia::render('Welcome/Checkout/Index');
        }
    }
}
