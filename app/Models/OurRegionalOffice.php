<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurRegionalOffice extends Model
{
    use \Spatie\Translatable\HasTranslations;

    protected $fillable = [
        'state',
        'fax',
        'phone',
        'phone_free',
        'email',

    ];
    public $translatable = ['state'];

    protected $casts = [
        'state' => 'array',
    ];

    protected $guarded = ['id'];

}
