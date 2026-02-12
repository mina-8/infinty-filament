<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Delivery;
use App\Models\PrivacyPolicy;
use App\Models\Product;
use App\Models\SettingSite;
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


        $products = Product::where('state', 'special')
            ->with('productoption')
            ->select('id', 'title', 'main_image', 'state', 'rate', 'avilable', 'slug')
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
                    'slug' => $product->getTranslation('slug', $appLang),
                    'product_option' => $product->productoption->map(fn($option) => [
                        'id' => $option->id,
                        'title' => $option->getTranslation('title', $appLang),
                        'price' => $option->price
                    ])
                ];
            });

        $blogs = Blog::limit(3)
            ->get()
            ->map(function ($blog) use ($appLang) {
                return [
                    'id' => $blog->id,
                    'title' => $blog->getTranslation('title', $appLang, true),
                    'content' => $blog->getTranslation('content', $appLang, true),
                    'slug' => $blog->getTranslation('slug', $appLang, true),
                    'image' => Storage::url($blog->image)
                ];
            });

        return Inertia::render('Welcome', [
            'slides' => $slides,
            'blogs' => $blogs,
            'products' => $products
        ]);
    }

    public function delivery(string $lang)
    {
        $delivery = json_decode(SettingSite::getValue('deliveries'), true);

        if(!is_array($delivery) || empty($delivery['ar']) && empty($delivery['en'])){
            return Inertia::render('Welcome/NotFound/NotFound');
        }

        $content = $delivery[$lang]
            ?? $delivery['ar']
            ?? null;
        if(!$content){
            return Inertia::render('Welcome/NotFound/NotFound');
        }

        return Inertia::render('Welcome/Delivery/Index', ['delivery' => ['content'=> $content]]);
    }

    public function privacy(string $lang)
    {
        $privacy = json_decode(SettingSite::getValue('privacy_policies'), true);

        if (!is_array($privacy) || empty($privacy['ar']) && empty($privacy['en'])) {
            return Inertia::render('Welcome/NotFound/NotFound');
        }

        $content = $privacy[$lang]
            ?? $privacy['ar']
            ?? null;

        if (!$content) {
            return Inertia::render('Welcome/NotFound/NotFound');
        }

        return Inertia::render('Welcome/Privacy/Index', ['privacy' => ['content' => $content]]);
    }
}
