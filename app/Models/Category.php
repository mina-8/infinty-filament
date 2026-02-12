<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Spatie\Translatable\HasTranslations;

    protected $fillable = [

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

    // public function subcategory (){
    //     return $this->hasMany(Subcategory::class , 'category_id');
    // }

    public function subcategories(){
        return $this->belongsToMany(Subcategory::class , 'category_subcategory' , 'category_id' , 'subcategory_id');
    }
    public function products(){
        // return $this->hasManyThrough(Product::class , Subcategory::class  , 'category_id' , 'subcategory_id' , 'id' , 'id');
        return $this->hasMany(Product::class , 'category_id');
    }
    public function allproducts(){
        return $this->hasManyThrough(Product::class , Subcategory::class  , 'category_id' , 'subcategory_id' , 'id' , 'id');
    }

}
