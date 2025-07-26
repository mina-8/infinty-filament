<?php

namespace App\Http\Controllers;

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
                    'active_btn' => $slide->active_btn,
                    'str_btn' => $str_btn,
                    'link' => $slide->link
                ];
            });

        if(!$slides) {
            return inertia('Welcome/NotFound/NotFound');
        }

        return Inertia::render('Welcome', [
            'slides' => $slides,

        ]);
    }
}
