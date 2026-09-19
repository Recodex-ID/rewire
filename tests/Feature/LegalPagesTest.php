<?php

use App\Models\Setting;

test('the privacy policy page renders and names who is responsible for the data', function () {
    $this->get(route('privacy'))
        ->assertOk()
        ->assertSee('Privacy Policy')
        ->assertSee('PT Reka Mitra Teknologi')
        ->assertSee('What we collect')
        ->assertSee(config('session.cookie'))
        ->assertSee(config('activitylog.clean_after_days').' days');
});

test('the terms of service page renders and points to the MIT license', function () {
    $this->get(route('terms'))
        ->assertOk()
        ->assertSee('Terms of Service')
        ->assertSee('PT Reka Mitra Teknologi')
        ->assertSee('MIT License')
        ->assertSee(route('privacy'), false);
});

test('the privacy policy only mentions analytics cookies when analytics is configured', function () {
    $this->get(route('privacy'))
        ->assertDontSee('_ga')
        ->assertDontSee('Google Analytics');

    Setting::put('analytics_id', 'G-ABC1234567');

    $this->get(route('privacy'))
        ->assertSee('_ga')
        ->assertSee('Google Analytics')
        ->assertSee('rewire-cookie-consent');
});

test('legal pages show the configured contact email', function () {
    Setting::put('contact_email', 'privacy@example.test');

    $this->get(route('privacy'))->assertSee('mailto:privacy@example.test', false);
    $this->get(route('terms'))->assertSee('mailto:privacy@example.test', false);
});

test('legal pages have their own title and are indexable', function () {
    $this->get(route('privacy'))
        ->assertSee('<title>Privacy Policy - '.config('app.name').'</title>', false)
        ->assertDontSee('noindex', false);

    $this->get(route('terms'))
        ->assertSee('<title>Terms of Service - '.config('app.name').'</title>', false);
});

test('register and login screens link to the legal pages', function () {
    $this->get(route('register'))
        ->assertSee(route('terms'), false)
        ->assertSee(route('privacy'), false);

    $this->get(route('login'))
        ->assertSee(route('terms'), false)
        ->assertSee(route('privacy'), false);
});
