<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    use \Spatie\Translatable\HasTranslations;

    protected $fillable = [
        'content',
    ];

    public $translatable = ['content'];

    protected $casts = [
        'content' => 'array',
    ];

    protected $guarded = ['id'];
}
