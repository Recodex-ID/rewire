<?php

use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('the home page has a unique title, description, canonical url, and social preview tags', function () {
    $html = $this->get(route('home'))->assertOk()->getContent();

    expect($html)
        ->toContain('<title>Laravel starter kit for client projects - '.config('app.name').'</title>')
        ->toContain('<link rel="canonical" href="'.route('home').'" />')
        ->toContain('<meta property="og:title"')
        ->toContain('<meta property="og:image" content="'.asset('images/og-default.png').'" />')
        ->toContain('<meta property="og:image:width" content="1200" />')
        ->toContain('<meta property="og:image:height" content="630" />')
        ->toContain('<meta name="twitter:card" content="summary_large_image" />')
        ->toContain('<meta name="twitter:image" content="'.asset('images/og-default.png').'" />');
});

test('the favicon set exists and every icon the head links to is served', function () {
    foreach (['favicon.ico', 'favicon.svg', 'favicon-96x96.png', 'apple-touch-icon.png', 'site.webmanifest'] as $file) {
        expect(public_path($file))->toBeFile();
    }

    $html = $this->get(route('home'))->getContent();

    expect($html)
        ->toContain('rel="icon" type="image/svg+xml" href="'.asset('favicon.svg').'"')
        ->toContain('rel="apple-touch-icon"')
        ->toContain('rel="manifest" href="'.asset('site.webmanifest').'"');
});

test('pages declare a responsive viewport', function () {
    $this->get(route('home'))->assertSee('<meta name="viewport" content="width=device-width, initial-scale=1.0" />', false);
});

test('the default social preview image exists at the size social networks expect', function () {
    [$width, $height] = getimagesize(public_path('images/og-default.png'));

    expect([$width, $height])->toBe([1200, 630]);
    expect(filesize(public_path('images/og-default.png')))->toBeLessThan(150 * 1024);
});

test('the logo and favicon are small enough not to slow every page down', function () {
    expect(filesize(public_path('images/logo.png')))->toBeLessThan(60 * 1024);
    expect(filesize(public_path('favicon.svg')))->toBeLessThan(60 * 1024);
});

test('a blog post uses its own title, excerpt, article type, and featured image in its meta tags', function () {
    Storage::fake('public');

    $post = Post::factory()->create([
        'title' => 'Shipping faster',
        'excerpt' => 'How we cut the time to first deploy.',
        'is_published' => true,
    ]);
    $post->addMedia(UploadedFile::fake()->image('cover.jpg', 1600, 900))->toMediaCollection('featured_image');

    $html = $this->get(route('blog.detail', $post->slug))->assertOk()->getContent();

    expect($html)
        ->toContain('<title>Shipping faster - '.config('app.name').'</title>')
        ->toContain('<meta name="description" content="How we cut the time to first deploy." />')
        ->toContain('<meta property="og:type" content="article" />')
        ->toContain('<meta property="article:published_time"')
        ->toContain($post->getFirstMediaUrl('featured_image', 'hero'));
});

test('a blog post without an excerpt falls back to a trimmed body for its description', function () {
    $post = Post::factory()->create([
        'excerpt' => null,
        'body' => str_repeat('Words that fill the page. ', 30),
        'is_published' => true,
    ]);

    $this->get(route('blog.detail', $post->slug))
        ->assertOk()
        ->assertSee('<meta name="description" content="Words that fill the page.', false);
});

test('paginated blog pages get their own canonical url', function () {
    Post::factory()->count(10)->create(['is_published' => true]);

    $this->get(route('blogs', ['page' => 2]))
        ->assertOk()
        ->assertSee('<link rel="canonical" href="'.route('blogs').'?page=2" />', false);
});

test('signed-in and auth screens ask search engines to stay away', function () {
    $this->get(route('login'))->assertSee('<meta name="robots" content="noindex, nofollow" />', false);

    $this->actingAs(User::factory()->create())
        ->get(route('dashboard'))
        ->assertSee('<meta name="robots" content="noindex, nofollow" />', false);
});

test('error pages are not indexed', function () {
    $this->get('/this-route-does-not-exist')
        ->assertNotFound()
        ->assertSee('<meta name="robots" content="noindex">', false);
});

test('robots.txt hides private areas and points at the sitemap', function () {
    $response = $this->get('/robots.txt')->assertOk();

    expect($response->headers->get('Content-Type'))->toStartWith('text/plain');

    $response->assertSee('User-agent: *', false)
        ->assertSee('Disallow: /dashboard', false)
        ->assertSee('Disallow: /system/', false)
        ->assertSee('Disallow: /super-admin/', false)
        ->assertSee('Sitemap: '.route('sitemap'), false);
});

test('the sitemap lists the legal pages too', function () {
    $this->get(route('sitemap'))
        ->assertOk()
        ->assertSee(route('privacy'), false)
        ->assertSee(route('terms'), false);
});

test('a custom seo description from settings wins over the default', function () {
    Setting::put('seo_description', 'Our own words.');

    $this->get(route('blogs'))->assertSee('<meta name="description" content="News, guides, and updates from the Rewire Starter Kit team." />', false);
    $this->get(route('privacy'))->assertSee('<meta name="description" content="What personal data', false);
    $this->get(route('home'))->assertSee('<meta name="description" content="Our own words." />', false);
});
