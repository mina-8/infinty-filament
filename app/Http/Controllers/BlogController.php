<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index(string $lang){
        $Blogs = Blog::orderBy("created_at","desc")
        ->get()
        ->map(function ($blog) use($lang){
            return [
                'id' => $blog->id,
                'title' => $blog->getTranslation('title' , $lang , true),
                'content' => $blog->getTranslation('content', $lang , true),
                'image' => Storage::url($blog->image),
                'slug' => $blog->getTranslation('slug' , $lang , true),
            ];
        });
        return Inertia::render('Welcome/Blog/Index' , ['blogs'=>$Blogs]);
    }

    public function show(string $lang , string $slug){
        $blog = Blog::where("slug->$lang" , $slug)->first();
        if (!$blog) {
            return Inertia::render('Welcome/NotFound/NotFound');
        }
        $slugs = $blog->getTranslations('slug');
        $blogData = [
            'id' => $blog->id,
            'title' => $blog->getTranslation('title', $lang),
            'content' => $blog->getTranslation('content', $lang),
            'image' => Storage::url($blog->image),

        ];
        return Inertia::render('Welcome/Blog/Show', ['blog' => $blogData , 'slugs' => $slugs]);
    }
}