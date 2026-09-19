<?php

use Laravel\Fortify\Features;

beforeEach(function () {
    $this->skipUnlessFortifyHas(Features::registration());
});

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertOk();
});

test('invalid registration data is rejected and the errors are shown next to the form', function () {
    $response = $this->from(route('register'))->post(route('register.store'), [
        'name' => '',
        'email' => 'not-an-email',
        'password' => 'short',
        'password_confirmation' => 'different',
    ]);

    // The app runs in Indonesian, so build the expected messages from the active locale.
    $this->get(route('register'))
        ->assertSee(trans('validation.required', ['attribute' => 'name']))
        ->assertSee(trans('validation.email', ['attribute' => 'email']));

    $response->assertRedirect(route('register'));
    $this->assertGuest();
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});
