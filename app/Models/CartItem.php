<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'option_id',
        'quantity',
    ];

    public function useritem(){
        return $this->belongsTo(User::class , 'user_id');
    }

    public function productitem(){
        return $this->belongsTo(Product::class , 'product_id');
    }

    public function optionitem(){
        return $this->belongsTo(ProductOption::class ,'option_id');
    }
}
