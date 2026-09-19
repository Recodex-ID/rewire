<?php

use App\Models\Post;
use App\Models\Setting;

/**
 * Every public page a visitor can land on, with data that makes optional parts render.
 *
 * @return list<string>
 */
function publicPageUrls(): array
{
    $post = Post::factory()->create(['is_published' => true]);

    return [
        route('home'),
        route('blogs'),
        route('blog.detail', $post->slug),
        route('privacy'),
        route('terms'),
        route('login'),
        route('register'),
    ];
}

beforeEach(function () {
    Setting::put('contact_email', 'hello@example.test');
    Setting::put('contact_phone', '+62 21 5550 1234');
    Setting::put('contact_address', 'Jakarta, Indonesia');
    Setting::put('analytics_id', 'G-ABC1234567');
    Setting::put('social_github', 'https://github.com/Recodex-ID/rewire');
});

test('every internal link on the public pages resolves', function () {
    $checked = [];
    $broken = [];

    foreach (publicPageUrls() as $pageUrl) {
        $html = $this->get($pageUrl)->assertOk()->getContent();

        preg_match_all('/<a\s[^>]*href="([^"]+)"/i', $html, $matches);

        foreach (array_unique($matches[1]) as $href) {
            $href = strtok(html_entity_decode($href), '#');

            if ($href === false || $href === '' || str_starts_with($href, 'mailto:') || str_starts_with($href, 'tel:')) {
                continue;
            }

            $host = parse_url($href, PHP_URL_HOST);

            if ($host !== null && $host !== parse_url(config('app.url'), PHP_URL_HOST)) {
                continue;
            }

            if (isset($checked[$href])) {
                continue;
            }

            $status = $this->get($href)->status();
            $checked[$href] = $status;

            if (! in_array($status, [200, 301, 302], true)) {
                $broken[] = "{$pageUrl} links to {$href} ({$status})";
            }
        }
    }

    expect($checked)->not->toBeEmpty();
    expect($broken)->toBe([]);
});

test('every in-page anchor points at an element that exists', function () {
    $missing = [];

    foreach (publicPageUrls() as $pageUrl) {
        $html = $this->get($pageUrl)->assertOk()->getContent();

        preg_match_all('/href="([^"#]*)#([^"]+)"/i', $html, $matches, PREG_SET_ORDER);

        foreach ($matches as [, $targetPage, $anchor]) {
            $targetHtml = $targetPage === '' || rtrim($targetPage, '/') === rtrim($pageUrl, '/')
                ? $html
                : $this->get($targetPage)->getContent();

            if (! str_contains($targetHtml, 'id="'.$anchor.'"')) {
                $missing[] = "{$pageUrl} links to #{$anchor}, but no element has that id";
            }
        }
    }

    expect($missing)->toBe([]);
});

test('every image on the public pages has an alt attribute', function () {
    $withoutAlt = [];

    foreach (publicPageUrls() as $pageUrl) {
        $html = $this->get($pageUrl)->assertOk()->getContent();

        preg_match_all('/<img\b[^>]*>/i', $html, $images);

        foreach ($images[0] as $image) {
            if (! preg_match('/\salt="[^"]*"/', $image)) {
                $withoutAlt[] = "{$pageUrl}: {$image}";
            }
        }
    }

    expect($withoutAlt)->toBe([]);
});

test('links that open a new tab use rel noopener', function () {
    $unsafe = [];

    foreach (publicPageUrls() as $pageUrl) {
        $html = $this->get($pageUrl)->assertOk()->getContent();

        preg_match_all('/<a\b[^>]*target="_blank"[^>]*>/i', $html, $links);

        foreach ($links[0] as $link) {
            if (! str_contains($link, 'noopener')) {
                $unsafe[] = "{$pageUrl}: {$link}";
            }
        }
    }

    expect($unsafe)->toBe([]);
});

test('icon-only links have an accessible name', function () {
    $this->get(route('home'))->assertSee('aria-label="GitHub (opens in a new tab)"', false);
});

test('public pages hold no scripts that call out to a third party until consent', function () {
    foreach (publicPageUrls() as $pageUrl) {
        $this->get($pageUrl)->assertDontSee('googletagmanager.com', false);
    }
});

test('the dashboard loads Chart.js on demand instead of shipping it with every page', function () {
    $js = file_get_contents(resource_path('js/app.js'));

    expect($js)
        ->toContain("import('chart.js/auto')")
        ->not->toContain("from 'chart.js");
});
