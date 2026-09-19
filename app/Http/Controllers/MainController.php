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

    public function privacy(): View
    {
        return view('pages.main.privacy');
    }

    public function terms(): View
    {
        return view('pages.main.terms');
    }

    public function sitemap(): Response
    {
        $sitemap = Sitemap::create()
            ->add(Url::create(route('home')))
            ->add(Url::create(route('blogs')))
            ->add(Url::create(route('privacy')))
            ->add(Url::create(route('terms')));

        Post::query()->published()->get()->each(
            fn (Post $post) => $sitemap->add(
                Url::create(route('blog.detail', $post->slug))->setLastModificationDate($post->updated_at)
            )
        );

        return $sitemap->toResponse(request());
    }

    /**
     * Served from a route (not a static file) so the Sitemap line always carries
     * this deployment's own absolute URL.
     */
    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Disallow: /dashboard',
            'Disallow: /system/',
            'Disallow: /super-admin/',
            'Disallow: /content-management/',
            'Disallow: /settings',
            'Disallow: /other/',
            'Disallow: /login',
            'Disallow: /register',
            'Disallow: /forgot-password',
            'Disallow: /reset-password/',
            'Disallow: /email/',
            'Disallow: /user/',
            '',
            'Sitemap: '.route('sitemap'),
        ];

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
