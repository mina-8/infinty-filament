<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'guest_id',
        'total',
        'status',
        'order_token',
        'payment_method'
    ];

    public function userproduct(){
        return $this->belongsTo(User::class , 'user_id');
    }

    public function guestproduct(){
        return $this->belongsTo(Guest::class , 'guest_id');
    }

    public function orderitems(){
        return $this->hasMany(OrderItem::class);
    }
}
