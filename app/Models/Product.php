<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Spatie\Translatable\HasTranslations;

    protected $fillable = [
        'subcategory_id',
        'category_id',
        'title',
        'content',
        'product_code',
        'avilable',
        'state',
        'rate',
        'main_image',
        'images',
        'slug'
    ];

    public $translatable = ['title' , 'content' , 'slug'];

    protected $casts = [
        'title' => 'array',
        'content' => 'array',
        'avilable' => 'boolean',
        'images' => 'array',
        'slug' => 'array'
    ];

    protected $guarded = ['id'];

    public function subcategory(){
        return $this->belongsTo(Subcategory::class  ,'subcategory_id');
    }

    public function category(){
        return $this->belongsTo(Category::class  ,'category_id');
    }
    public function productoption(){
        return $this->hasMany(ProductOption::class , 'product_id');
    }

}
