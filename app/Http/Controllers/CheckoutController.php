<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function checkout(string $lang)
    {
        $userid = Auth::id();
        if ($userid) {
            $caritmes = CartItem::with(['productitem', 'optionitem'])->where('user_id', $userid)
                ->get()
                ->map(function ($item) use ($lang) {
                    return [
                        'id' => $item->id,
                        'productId' => $item->product_id,
                        'optionId' => $item->option_id,
                        'title' => $item->productitem->getTranslation('title', $lang),
                        'option_title' => $item->optionitem->getTranslation('title', $lang),
                        'price' => $item->optionitem->price,
                        'quantity' => $item->quantity,
                        'total_price' => number_format($item->quantity * $item->optionitem->price , 2 , '.' , '')
                    ];
                });
            return Inertia::render('Welcome/Order/Index', ['cartitems' => $caritmes]);
        } else {
            return Inertia::render('Welcome/Checkout/Guest', [
                'canResetPassword' => Route::has('password.request'),
                'status' => session('status'),
            ]);
        }
    }
}
