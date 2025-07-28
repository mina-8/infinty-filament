<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\OurRegionalOffice;
use App\Models\SettingSite;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $appLang = app()->getLocale();
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'applang' =>  $appLang,
            'currentRoute' => Route::currentRouteName(),
            'categories' => fn() => Category::with([
                'subcategory' => fn($q) => $q->withcount('products')
            ])
                ->select('id', 'title', 'icon', 'slug')
                ->get()
                ->map(function ($category) use ($appLang) {
                    return [
                        'id' => $category->id,
                        'title' => $category->getTranslation('title', $appLang),
                        'icon' => Storage::url($category->icon),
                        'slug' => $category->getTranslation('slug', $appLang),
                        'subcategory' => $category->subcategory->map(fn($sub)=>[
                            'id' => $sub->id,
                            'title' => $sub->getTranslation('title' , $appLang),
                            'slug' => $sub->getTranslation('slug' , $appLang),
                            'proudct_count' => $sub->products_count
                        ])
                    ];
                }),
            'office_reginal' => fn() => OurRegionalOffice::get()
                ->map(function ($office) use ($appLang) {
                    return [
                        'id' => $office->id,
                        'state' => $office->getTranslation('state', $appLang),
                        'address' => $office->getTranslation('address', $appLang),
                        'fax' => $office->fax,
                        'phone' => $office->phone,
                        'phone_free' => $office->phone_free,
                        'email' => $office->email
                    ];
                }),
            'socialicons' => fn() => SocialLink::get(),
            'site_setting' => fn() => SettingSite::first(),
            'flash' => function () {
                return [
                    'success' => session('success'),
                    'error' => session('error'),
                ];
            },
        ];
    }
}
