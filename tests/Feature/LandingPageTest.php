<?php

use App\Models\LandingPageSection;

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
