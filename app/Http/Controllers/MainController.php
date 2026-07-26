<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    public function index(): View
    {
        return view('pages.main.index', [
            'seoDescription' => Setting::get('seo_description'),
            'analyticsId' => Setting::get('analytics_id'),
        ]);
    }

    public function blogs(): View
    {
        return view('pages.main.blogs', [
            'posts' => Post::query()->published()->with('author')->latest()->paginate(9),
        ]);
    }

    public function blogDetail(string $slug): View
    {
        $post = Post::query()->where('slug', $slug)->published()->with('author')->firstOrFail();

        return view('pages.main.blog-detail', [
            'post' => $post,
        ]);
    }

    public function sitemap(): Response
    {
        $sitemap = Sitemap::create()
            ->add(Url::create(route('home')))
            ->add(Url::create(route('blogs')));

        Post::query()->published()->get()->each(
            fn (Post $post) => $sitemap->add(
                Url::create(route('blog.detail', $post->slug))->setLastModificationDate($post->updated_at)
            )
        );

        return $sitemap->toResponse(request());
    }
}
