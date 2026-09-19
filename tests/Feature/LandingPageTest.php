<?php

use App\Models\Setting;

test('landing page renders successfully with the expected content', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Ship your next');
    $response->assertSee('client project');
});

test('landing page renders the SEO description and hands the analytics id to the consent banner', function () {
    Setting::put('seo_description', 'A starter kit for client projects.');
    Setting::put('analytics_id', 'G-ABC1234567');

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('A starter kit for client projects.', false);
    $response->assertSee('G-ABC1234567', false);
    $response->assertSee('Analytics cookies');
    $response->assertSee('Cookie settings');
});

test('analytics never loads from the page itself, only after the visitor consents', function () {
    Setting::put('analytics_id', 'G-ABC1234567');

    $this->get(route('home'))->assertDontSee('googletagmanager.com', false);
});

test('landing page falls back to a default description and shows no consent banner when settings are empty', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('name="description"', false);
    $response->assertSee('A reusable Laravel starter kit with authentication, roles, and a blog, ready on day one.', false);
    $response->assertDontSee('googletagmanager.com', false);
    $response->assertDontSee('cookieConsent', false);
    $response->assertDontSee('Cookie settings');
});

test('footer credits Recodex ID with a link that opens a new tab in the brand color', function () {
    $html = $this->get(route('home'))->getContent();

    expect($html)
        ->toContain('Built by')
        ->toContain('PT Reka Mitra Teknologi')
        ->toMatch('/<a\s[^>]*href="https:\/\/recodex\.id"[^>]*target="_blank"[^>]*rel="noopener"[^>]*text-\[#CFF008\][^>]*>\s*Recodex ID/s');
});

test('the page pushes one primary action, signing in, and never a generic call to action', function () {
    $html = $this->get(route('home'))->getContent();

    expect(substr_count($html, 'Sign in to the dashboard'))->toBe(2);
    expect($html)
        ->not->toContain('Get started')
        ->not->toContain('Create an account')
        ->not->toContain('Learn more');
});

test('footer links to the privacy policy and terms of service', function () {
    $this->get(route('home'))
        ->assertSee(route('privacy'), false)
        ->assertSee(route('terms'), false);
});

test('contact details only render when they are configured', function () {
    $this->get(route('home'))
        ->assertDontSee('mailto:', false)
        ->assertDontSee('Direct contact');

    Setting::put('contact_email', 'hello@example.test');
    Setting::put('contact_phone', '+62 21 5550 1234');

    $this->get(route('home'))
        ->assertSee('mailto:hello@example.test', false)
        ->assertSee('tel:+622155501234', false)
        ->assertSee('Direct contact');
});
