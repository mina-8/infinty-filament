<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Admin;
use App\Models\CartItem;
use App\Models\Guest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Filament\Notifications\Notification;


class OrderController extends Controller
{

    public function store(StoreOrderRequest $request)
    {
        $userid = Auth::id();
        if ($userid) {
            $orderToken = null;
            DB::transaction(function () use (&$orderToken, $request, $userid) {

                $order = Order::create([
                    'user_id' => $userid,
                    'guest_id' => null,
                    'total' => $request->input('totalsumprice'),
                    'status' => 'pending',
                    'order_token' => strtoupper(Str::random(14)),
                    'payment_method' => $request->input('payment_method')
                ]);

                foreach ($request->input('cartitems') as $item) {
                    $order->orderitems()->create([
                        'product_id' => $item['productId'],
                        'option_id' => $item['optionId'],
                        'quantity' =>  $item['quantity'],
                    ]);
                }

                CartItem::where('user_id', $userid)->delete();

                $orderToken = $order->order_token;
            });

            $user = Auth::user();
            Notification::make()
                ->title('Order Placed Successfully')
                ->body("Order #{$orderToken} has been placed by user ID: {$user->name}.")
                ->success()
                ->sendToDatabase(Admin::all())
                ->send();

            return Inertia::render('Welcome/Order/Success', ['ordercode' => $orderToken]);
        }

        abort(403, 'Unauthorized');
    }

    public function storeguest(Request $request)
    {
        $getGuest = session('guest_data');

        if (!$getGuest) {
            return redirect()->route('register-guest');
        }

        $orderToken = null;
        DB::transaction(function () use ($getGuest, $request, &$orderToken) {
            $guest =  Guest::create($getGuest);

            $order = Order::create([
                'user_id' => null,
                'guest_id' => $guest->id,
                'total' => $request->input('totalsumprice'),
                'status' => 'pending',
                'order_token' => strtoupper(Str::random(14)),
                'payment_method' => $request->input('payment_method')
            ]);

            foreach ($request->input('cartitems') as $item) {
                $order->orderitems()->create([
                    'product_id' => $item['productId'],
                    'option_id' => $item['optionId'],
                    'quantity' =>  $item['quantity'],
                ]);
            }

            $orderToken = $order->order_token;
        });

        $request->session()->forget('guest_data');

        Notification::make()
            ->title('Order Placed Successfully')
            ->body("Order #{$orderToken} has been placed by a guest user.")
            ->success()
            ->sendToDatabase(Admin::all())
            ->send();

        return Inertia::render('Welcome/Order/SuccessGuest', ['ordercode' => $orderToken]);
    }
}
