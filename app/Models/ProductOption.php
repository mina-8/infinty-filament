<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use \Spatie\Translatable\HasTranslations;

    protected $fillable = [
        'product_id',
        'title',
        'price',
    ];

    public $translatable = ['title'];

    protected $casts = [
        'title' => 'array',
    ];

    protected $guarded = ['id'];
}
