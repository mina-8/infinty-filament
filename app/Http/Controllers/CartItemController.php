<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CartItemController extends Controller
{
    /**
     * get all cart item belongs to user
     */
    public function index(string $lang)
    {
        $userid = Auth::id();
        if (!$userid) {
            return response()->json(['cart' => []], 401);
        }
        $cart = CartItem::with(['productitem', 'optionitem'])
            ->where('user_id', $userid)
            ->get()
            ->map(function ($cartitems) use ($lang) {
                return [
                    'productId' => $cartitems->product_id,
                    'optionId' => $cartitems->option_id,
                    'title' => $cartitems->productitem->getTranslation('title', $lang),
                    'image' => Storage::url($cartitems->productitem->main_image),
                    'product_code' => $cartitems->productitem->product_code,
                    'option_title' => $cartitems->optionitem->getTranslation('title', $lang),
                    'price' => $cartitems->optionitem->price,
                    'quantity' => $cartitems->quantity
                ];
            });
        return response()->json(['cart' => $cart]);
    }

    public function merge(Request $request)
    {
        $userid = Auth::id();
        if (!$userid) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $items = $request->input('cart', []);
        foreach ($items as $item) {
            $existing = CartItem::where('user_id', $userid)
                ->where('product_id', $item['productId'])
                ->where('option_id', $item['optionId'])
                ->first();

            if ($existing) {
                $existing->quantity += $item['quantity'];
                $existing->save();
            } else {
                CartItem::create([
                    'user_id' => $userid,
                    'product_id' => $item['productId'],
                    'option_id' => $item['optionId'],
                    'quantity' => $item['quantity']
                ]);
            }
        }
        return response()->json(['message' => 'Cart merged successfully']);
    }

    public function additems(Request $request)
    {
        $userid = Auth::id();
        if (!$userid) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $productid = $request->input('productid');
        $optionid = $request->input('optionid');
        $quantity = $request->input('quantity');

        $existingCart = CartItem::where('user_id', $userid)
            ->where('product_id', $productid)
            ->where('option_id', $optionid)
            ->first();

        if ($existingCart) {
            $existingCart->quantity += $quantity;
            $existingCart->save();
        } else {
            CartItem::create([
                'user_id' => $userid,
                'product_id' => $productid,
                'option_id' => $optionid,
                'quantity' => $quantity
            ]);
        }
    }
    public function removeitems(Request $request)
    {
        $userid = Auth::id();
        if (!$userid) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $productid = $request->input('productid');
        $optionid = $request->input('optionid');
        $quantity = $request->input('qunatity');

        $existingCart = CartItem::where('user_id', $userid)
            ->where('product_id', $productid)
            ->where('option_id', $optionid)
            ->first();

        if ($existingCart) {
            if ($existingCart->quantity > 0) {
                $existingCart->quantity -= $quantity;
                $existingCart->save();
            } else {
                $existingCart->delete();
            }
        }
    }
    public function removeitemsall(Request $request)
    {
        $userid = Auth::id();
        if (!$userid) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $productid = $request->input('productid');
        $optionid = $request->input('optionid');

        $existingCart = CartItem::where('user_id', $userid)
            ->where('product_id', $productid)
            ->where('option_id', $optionid)
            ->first();

        if ($existingCart) {
            $existingCart->delete();
        }
    }

    public function totalitems()
    {
        $userid = Auth::id();
        if (!$userid) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $totalSum = CartItem::where('user_id' , $userid)->sum('quantity');

        return response()->json(['total'=>$totalSum]);
    }
}
