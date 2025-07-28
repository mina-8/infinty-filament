<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(string $lang, string $slug)
    {
        $Category = Category::where("slug->$lang", $slug)
            ->first();

        if (!$Category) {
            return Inertia::render('Welcome/NotFound/NotFound');
        }

        $slugs = $Category->getTranslations('slug');

        $products = $Category->allProducts()->paginate(12);
        $products->getCollection()->transform(function ($product) use ($lang) {
            return [
                'id' => $product->id,
                'title' => $product->getTranslation('title', $lang),
                'content' => $product->getTranslation('content', $lang),
                'product_code' => $product->product_code,
                'avilable' => $product->avilable,
                'state' => $product->state,
                'rate' => $product->rate,
                'main_image' => Storage::url($product->main_image),
                'images' => array_map(fn($image) => Storage::url($image), $product->images ?? []),
                'product_option' => $product->productoption->map(fn($option) => [
                    'id' => $option->id,
                    'title' => $option->getTranslation('title', $lang),
                    'price' => $option->price
                ]),
                'slug' => $product->getTranslation('slug', $lang)
            ];
        });
        $DataCateogry = [
            'id' => $Category->id,
            'title' => $Category->getTranslation('title', $lang),
            'content' => $Category->getTranslation('content', $lang),
            'image' => Storage::url($Category->image),
            'slug' => $Category->getTranslation('slug', $lang),
            'subcategory' => $Category->subcategory->map(fn($subcat) => [
                'id' => $subcat->id,
                'title' => $subcat->getTranslation('title', $lang),
                'product_count' =>  $subcat->products->count(),
                'slug' => $subcat->getTranslation('slug', $lang)
            ]),
            'all_products' => $products
        ];

        return Inertia::render('Welcome/Category/Index', ['category' => $DataCateogry, 'slugs' => $slugs]);
    }
    public function subcategory(string $lang, string $category, string $subcategory)
    {
        $Category = Category::select('title' , 'slug')->where("slug->$lang", $category)->first();

        if (!$Category) {
            return Inertia::render('Welcome/NotFound/NotFound');
        }

        $SubCategory = Subcategory::where("slug->$lang", $subcategory)
            ->first();

        if (!$SubCategory) {
            return Inertia::render('Welcome/NotFound/NotFound');
        }

        $slugs = $SubCategory->getTranslations('slug');

        $Products = $SubCategory->products()->paginate(20);

        $Products->getCollection()->transform(function ($product) use ($lang) {
            return [
                'id' => $product->id,
                'title' => $product->getTranslation('title', $lang),
                'content' => $product->getTranslation('content', $lang),
                'product_code' => $product->product_code,
                'avilable' => $product->avilable,
                'state' => $product->state,
                'rate' => $product->rate,
                'main_image' => Storage::url($product->main_image),
                'images' => array_map(fn($image) => Storage::url($image), $product->images ?? []),
                'product_option' => $product->productoption->map(fn($option) => [
                    'id' => $option->id,
                    'title' => $option->getTranslation('title', $lang),
                    'price' => $option->price
                ]),
                'slug' => $product->getTranslation('slug', $lang)
            ];
        });
        $dataSubCategory = [
            'id' => $SubCategory->id,
            'title' => $SubCategory->getTranslation('title', $lang),
            'content' => $SubCategory->getTranslation('content', $lang),
            'image' => Storage::url($SubCategory->image),
            'category_title' => $Category->getTranslation('title', $lang),
            'category_slug' => $Category->getTranslation('slug', $lang),
            'slug' => $SubCategory->getTranslation('slug' , $lang),
            'all_products' => $Products
        ];
        return Inertia::render('Welcome/SubCategory/Index' , ['subcategory'=>$dataSubCategory , 'slugs' => $slugs]);
    }
}
