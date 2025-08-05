<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingSite extends Model
{
    protected $fillable = [
        'shop_link',
        'map_link',
        'whats_app'
    ];
}
