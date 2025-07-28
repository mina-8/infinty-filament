<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactformController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\OurPromiseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MainProductController;
use App\Http\Controllers\OurStoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HowMakeController;
use App\Http\Controllers\SearchWebController;
use App\Http\Controllers\WorkUsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::fallback(function () {
    return Inertia::render('Welcome/NotFound/NotFound');
});

Route::group(
    [
        'prefix' => '{lang?}',
        'where' => [
            // Exclude 'livewire' and 'admin' from being matched as language
            'lang' => '(?!livewire|admin)[a-zA-Z]{2}(-[a-zA-Z]{2})?'
        ],
        'middleware' => 'lang'
    ],
    function () {

        // Route::get('/dashboard', function () {
        //     return Inertia::render('Dashboard');
        // })->middleware(['auth', 'verified'])->name('dashboard');

        Route::fallback(function () {
            return Inertia::render('Welcome/NotFound/NotFound');
        });

        Route::get('/', [HomeController::class, 'index'])->name('welcome');

        // category
        Route::get('category/{slug}' , [CategoryController::class , 'index'])->name('category');

        // sub category
        Route::get('{category}/{subcategory}' , [CategoryController::class , 'subcategory'])->name('subcategory');

        // product
        Route::get('product' , [ProductController::class , 'index'])->name('product');

        // product category
        Route::get('c/{category}/{product}' , [ProductController::class , 'productcategory'])->name('product-category');
        // product subcategory
        Route::get('c/{category}/s/{subcategory}/{product}' , [ProductController::class , 'productsubcategory'])->name('product-subcategory');

        // Cart
        Route::get('my-cart' , [CartController::class , 'view'])->name('my-cart');

        // contact us
        Route::get('contact-us', [ContactUsController::class, 'index'])->name('contact-us');
        Route::post('contact-us', [ContactUsController::class, 'store'])->name('contact-us');

        // contact form
        Route::post('contact-form', [ContactformController::class, 'store'])->name('contact-form');



        // search web
        Route::get('search-web', [SearchWebController::class, 'search'])->name('search-web');

        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });
    }

);

require __DIR__ . '/auth.php';
