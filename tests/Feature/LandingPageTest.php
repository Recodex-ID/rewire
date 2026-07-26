<?php

use App\Models\LandingPageSection;
use App\Models\Setting;

test('landing page shows visible section content and hides invisible sections', function () {
    LandingPageSection::create([
        'key' => 'hero',
        'content' => [
            'heading_line1' => 'Welcome to',
            'heading_highlight' => 'Acme',
            'heading_line2' => '',
            'subheading' => 'Sub',
            'primary_cta_text' => 'Start',
            'primary_cta_url' => '/register',
            'secondary_cta_text' => '',
            'secondary_cta_url' => '',
            'badge_text' => '',
            'badge_secondary' => '',
            'stats' => [],
        ],
        'is_visible' => true,
    ]);

    LandingPageSection::create([
        'key' => 'cta',
        'content' => [
            'eyebrow' => '', 'heading_line1' => 'Hidden CTA', 'heading_line2' => '', 'subheading' => '',
            'primary_text' => 'Go', 'primary_url' => '/x', 'secondary_text' => '', 'secondary_url' => '',
            'contact_label' => '', 'address_label' => '', 'address' => '', 'email' => '', 'phone' => '',
        ],
        'is_visible' => false,
    ]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Welcome to');
    $response->assertSee('Acme');
    $response->assertDontSee('Hidden CTA');
});

test('landing page renders without errors when no sections exist', function () {
    $this->get(route('home'))->assertOk();
});

test('landing page renders SEO description and analytics script from settings', function () {
    Setting::put('seo_description', 'A starter kit for client projects.');
    Setting::put('analytics_id', 'G-ABC1234567');

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('A starter kit for client projects.', false);
    $response->assertSee('G-ABC1234567', false);
});

test('landing page omits SEO meta and analytics script when settings are empty', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertDontSee('name="description"', false);
    $response->assertDontSee('googletagmanager.com', false);
});
