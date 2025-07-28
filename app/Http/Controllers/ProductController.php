<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index() {}

    public function productcategory(string $lang, string $category,  string $product)
    {

        $Product = Product::where("slug->$lang", $product)
            ->first();


        if (!$Product) {
            return Inertia::render('Welcome/NotFound/NotFound');
        }

        $slugs = $Product->getTranslations('slug');

        $Category = Category::select('title', 'slug')->where("slug->$lang", $category)->first();
        if (!$Category) {
            return Inertia::render('Welcome/NotFound/NotFound');
        }

        $DataProduct = [
            'id' => $Product->id,
            'title' => $Product->getTranslation('title', $lang),
            'content' => $Product->getTranslation('content', $lang),
            'product_code' => $Product->product_code,
            'avilable' => $Product->avilable,
            'state' => $Product->state,
            'rate' => $Product->rate,
            'main_image' => Storage::url($Product->main_image),
            'images' => array_map(fn($image) => Storage::url($image), $Product->images ?? []),
            'product_option' => $Product->productoption->map(fn($option) => [
                'id' => $option->id,
                'title' => $option->getTranslation('title', $lang),
                'price' => $option->price
            ]),
            'slug' => $Product->getTranslation('slug', $lang),
            'category_title' => $Category->getTranslation('title' , $lang),
            'category_slug' => $Category->getTranslation('slug' , $lang)
        ];



        return Inertia::render('Welcome/Product/Index' , ['product' => $DataProduct , 'slugs' => $slugs]);
    }

    public function productsubcategory(string $lang, string $category, string $subcategory, string $product)
    {
        $Product = Product::where("slug->$lang", $product)
            ->first();

        if (!$Product) {
            return Inertia::render('Welcome/NotFound/NotFound');
        }

        $slugs = $Product->getTranslations('slug');

        $Category = Category::select('title', 'slug')->where("slug->$lang", $category)->first();
        if (!$Category) {
            return Inertia::render('Welcome/NotFound/NotFound');
        }

        $SubCategory = Subcategory::select('title', 'slug')->where("slug->$lang", $subcategory)->first();
        if(!$SubCategory){
            return Inertia::render('Welcome/NotFound/NotFound');
        }

        $DataProduct = [
            'id' => $Product->id,
            'title' => $Product->getTranslation('title', $lang),
            'content' => $Product->getTranslation('content', $lang),
            'product_code' => $Product->product_code,
            'avilable' => $Product->avilable,
            'state' => $Product->state,
            'rate' => $Product->rate,
            'main_image' => Storage::url($Product->main_image),
            'images' => array_map(fn($image) => Storage::url($image), $Product->images ?? []),
            'product_option' => $Product->productoption->map(fn($option) => [
                'id' => $option->id,
                'title' => $option->getTranslation('title', $lang),
                'price' => $option->price
            ]),
            'slug' => $Product->getTranslation('slug', $lang),
            'category_title' => $Category->getTranslation('title' , $lang),
            'category_slug' => $Category->getTranslation('slug' , $lang),
            'subcategory_title' => $SubCategory->getTranslation('title', $lang),
            'subcategory_slug' => $SubCategory->getTranslation('slug', $lang)
        ];



        return Inertia::render('Welcome/Product/Index' , ['product' => $DataProduct , 'slugs' => $slugs]);
    }
}
