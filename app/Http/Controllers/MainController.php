<?php

namespace App\Http\Controllers;

use App\Models\LandingPageSection;
use App\Models\Setting;
use Illuminate\Contracts\View\View;

class MainController extends Controller
{
    public function index(): View
    {
        return view('index', [
            'sections' => LandingPageSection::query()->get()->keyBy('key'),
            'seoDescription' => Setting::get('seo_description'),
            'analyticsId' => Setting::get('analytics_id'),
        ]);
    }
}
