<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appLang = app()->getLocale(); // 'en' or 'ar'

        // Slides
        $slides = Slide::get()
            ->map(function ($slide) use ($appLang) {
                $image = Storage::url($slide->image);
                $str_btn = $slide->getTranslation('str_btn', $appLang);
                return [
                    'id' => $slide->id,
                    'image' => $image,
                    'title' => $slide->getTranslation('title', $appLang),
                    'content' => $slide->getTranslation('content', $appLang),
                    'active_btn' => $slide->active_btn,
                    'str_btn' => $str_btn,
                    'link' => $slide->link
                ];
            });

        if (!$slides) {
            return inertia('Welcome/NotFound/NotFound');
        }

        $products = Product::where('state', 'special')
            ->with('productoption')
            ->select('id', 'title', 'main_image' , 'state', 'rate', 'avilable', 'slug')
            ->latest()
            ->limit(20)
            ->get()
            ->map(function ($product) use ($appLang) {
                return [
                    'id' => $product->id,
                    'title' => $product->getTranslation('title', $appLang),
                    'image' => Storage::url($product->main_image),
                    'state' => $product->state,
                    'rate' => $product->rate,
                    'avilable' => $product->avilable,
                    'slug' => $product->getTranslation('slug' , $appLang),
                    'product_option' => $product->productoption->map(fn($option)=>[
                        'id'=>$option->id,
                        'title' => $option->getTranslation('title', $appLang),
                        'price' => $option->price
                    ])
                ];
            });

        return Inertia::render('Welcome', [
            'slides' => $slides,
            'products' => $products
        ]);
    }
}
