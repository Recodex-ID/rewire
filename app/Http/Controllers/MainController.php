<?php

namespace App\Http\Controllers;

use App\Models\LandingPageSection;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class MainController extends Controller
{
    public function index(): View
    {
        return view('pages.main.index', [
            'sections' => $this->sections(),
            'seoDescription' => Setting::get('seo_description'),
            'analyticsId' => Setting::get('analytics_id'),
        ]);
    }

    public function blogIndex(): View
    {
        return view('pages.main.blog-index', [
            'sections' => $this->sections(),
            'posts' => Post::query()->published()->with('author')->latest()->paginate(9),
        ]);
    }

    public function blogShow(string $slug): View
    {
        $post = Post::query()->where('slug', $slug)->published()->with('author')->firstOrFail();

        return view('pages.main.blog-show', [
            'sections' => $this->sections(),
            'post' => $post,
        ]);
    }

    /**
     * @return Collection<string, LandingPageSection>
     */
    private function sections(): Collection
    {
        return LandingPageSection::query()->get()->keyBy('key');
    }
}
