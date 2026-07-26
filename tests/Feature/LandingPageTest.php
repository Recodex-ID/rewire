<?php

use App\Models\Setting;

test('landing page renders successfully with the expected content', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Ship your next');
    $response->assertSee('client project');
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
