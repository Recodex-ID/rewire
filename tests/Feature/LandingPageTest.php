<?php

use App\Models\LandingPageSection;

test('landing page shows visible section content and hides invisible sections', function () {
    LandingPageSection::create([
        'key' => 'hero',
        'content' => ['heading' => 'Welcome to Acme', 'subheading' => 'Sub', 'cta_text' => 'Start', 'cta_url' => '/register'],
        'is_visible' => true,
    ]);

    LandingPageSection::create([
        'key' => 'cta',
        'content' => ['heading' => 'Hidden CTA', 'button_text' => 'Go', 'button_url' => '/x'],
        'is_visible' => false,
    ]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Welcome to Acme');
    $response->assertDontSee('Hidden CTA');
});

test('landing page renders without errors when no sections exist', function () {
    $this->get(route('home'))->assertOk();
});
