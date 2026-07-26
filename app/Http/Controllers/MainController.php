<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Setting;
use Illuminate\Contracts\View\View;

class MainController extends Controller
{
    public function index(): View
    {
        return view('pages.main.index', [
            'seoDescription' => Setting::get('seo_description'),
            'analyticsId' => Setting::get('analytics_id'),
        ]);
    }

    public function blogIndex(): View
    {
        return view('pages.main.blog-index', [
            'posts' => Post::query()->published()->with('author')->latest()->paginate(9),
        ]);
    }

    public function blogShow(string $slug): View
    {
        $post = Post::query()->where('slug', $slug)->published()->with('author')->firstOrFail();

        return view('pages.main.blog-show', [
            'post' => $post,
        ]);
    }
}
