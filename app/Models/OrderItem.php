<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'option_id',
        'quantity',
    ];

    public function orderitem(){
        return $this->belongsTo(Order::class , 'order_id');
    }

    public function productitem(){
        return $this->belongsTo(Product::class , 'product_id');
    }

    public function optionitem(){
        return $this->belongsTo(ProductOption::class ,'option_id');
    }
}
