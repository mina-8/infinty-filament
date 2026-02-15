<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contactform extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'country',
        'message',
        'read_at',
    ];

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = strip_tags($value);
    }
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = strip_tags($value);
    }


    public function setMessageAttribute($value)
    {
        $this->attributes['message'] = strip_tags($value);
    }

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function markAsRead()
    {
        $this->update([
            'read_at' => now(),
        ]);
    }
}
