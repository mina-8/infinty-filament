<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use \Spatie\Translatable\HasTranslations;

    protected $fillable = [
        'category_id',
        'title',
        'content',
        'image',
        'slug'
    ];

    public $translatable = ['title' , 'content' , 'slug'];

    protected $casts = [
        'title' => 'array',
        'content' => 'array',
        'slug' => 'array'
    ];

    protected $guarded = ['id'];

    public function category(){
        return $this->belongsTo(Category::class , 'category_id');
    }

    public function products(){
        return $this->hasMany(Product::class  ,'subcategory_id');
    }
}
