<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CartController extends Controller
{
    public function wishlist(){
        return Inertia::render('Welcome/WishList/Index');
    }
    public function mycart(){
        return Inertia::render('Welcome/MyCart/Index');
    }

    public function guestcart(Request $request){
        $appLang = app()->getLocale();
        $items = $request->all();

        $cartItems = collect($items)->map(function ($item) use($appLang){
            $product = Product::with('productoption')->find($item['productId']);
            if(!$product) return null;

            $option = $product->productoption->where('id' , $item['optionId'])->first();

            return [
                'id' => $product->id,
                'title' => $product->getTranslation('title' , $appLang),
                'image' => Storage::url($product->main_image),
                'product_code' => $product->product_code,
                'option_title' => $option->getTranslation('title' , $appLang),
                'option_price' => $option->price,
                'quantity' => $item['quantity'],
                'slug' => $product->getTranslation('slug' , $appLang)
            ];
        })->filter();
        return response()->json(['cart'=>$cartItems]);
    }

    public function checkout(){

    }
}
