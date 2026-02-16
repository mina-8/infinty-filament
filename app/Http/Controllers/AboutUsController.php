<?php

namespace App\Http\Controllers;

use App\Models\SettingSite;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AboutUsController extends Controller
{
    public function index(string $lang)
    {
        $aboutus = json_decode(SettingSite::getValue('aboutus'), true);

        if(!is_array($aboutus) || empty($aboutus['ar'] && empty($aboutus['en']))) {
             return Inertia::render('Welcome/NotFound/NotFound');
        }

        $content = $aboutus[app()->getLocale()]
            ?? $aboutus['ar']
            ?? null;

        if(!$content){
            return Inertia::render('Welcome/NotFound/NotFound');
        }

        return Inertia::render('Welcome/Aboutus/Index', ['aboutus' => ['content' => $content]]);
    }
}
