<?php

namespace App\Http\Controllers;

use App\Models\LandingPageSection;
use Illuminate\Contracts\View\View;

class MainController extends Controller
{
    public function index(): View
    {
        return view('index', [
            'sections' => LandingPageSection::query()->get()->keyBy('key'),
        ]);
    }
}
