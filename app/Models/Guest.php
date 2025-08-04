<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $guard = 'guest';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'area',
        'street',
        'block',
        'building',
        'complex',
        'floore_number',
        'flat_number',
        'land_mark'
    ];

    public function orders(){
        return $this->hasMany(Order::class );
    }

    public function order(){
        return $this->hasOne(Order::class);
    }
}
