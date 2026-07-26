<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Spatie\Activitylog\Models\Activity;

test('registering logs activity with the new user as causer', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasNoErrors();

    $user = User::query()->where('email', 'jane@example.com')->firstOrFail();

    // Fortify's registration flow logs the user in immediately after registering, so a
    // "logged in" activity follows the "registered" one -- take the first (oldest) row.
    $activity = Activity::query()->where('log_name', 'auth')->oldest('id')->first();

    expect($activity)->not->toBeNull();
    expect($activity->description)->toBe('Jane Doe registered');
    expect($activity->causer->is($user))->toBeTrue();
});

test('logging in logs activity', function () {
    $user = User::factory()->create(['name' => 'Jane Doe']);

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertSessionHasNoErrors();

    $activity = Activity::query()->where('log_name', 'auth')->latest('id')->first();

    expect($activity)->not->toBeNull();
    expect($activity->description)->toBe('Jane Doe logged in');
    expect($activity->causer->is($user))->toBeTrue();
});

test('logging out logs activity', function () {
    $user = User::factory()->create(['name' => 'Jane Doe']);

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->post(route('logout'));

    $activity = Activity::query()->where('log_name', 'auth')->latest('id')->first();

    expect($activity)->not->toBeNull();
    expect($activity->description)->toBe('Jane Doe logged out');
    expect($activity->causer->is($user))->toBeTrue();
});

test('a failed login attempt with the wrong password logs activity without leaking the password', function () {
    $user = User::factory()->create();

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertSessionHasErrorsIn('email');

    $this->assertGuest();

    $activity = Activity::query()->where('log_name', 'auth')->latest('id')->first();

    expect($activity)->not->toBeNull();
    expect($activity->description)->toBe("Failed login attempt for {$user->email}");
    expect($activity->properties->toArray())->toBe(['email' => $user->email]);
    expect(json_encode($activity->properties))->not->toContain('wrong-password');
});

test('a failed login attempt for a nonexistent email logs activity without crashing', function () {
    $this->post(route('login.store'), [
        'email' => 'nobody@example.com',
        'password' => 'wrong-password',
    ])->assertSessionHasErrorsIn('email');

    $this->assertGuest();

    $activity = Activity::query()->where('log_name', 'auth')->latest('id')->first();

    expect($activity)->not->toBeNull();
    expect($activity->description)->toBe('Failed login attempt for nobody@example.com');
    expect($activity->causer)->toBeNull();
    expect(json_encode($activity->properties))->not->toContain('wrong-password');
});

test('resetting a password via the real flow logs activity', function () {
    Notification::fake();

    $user = User::factory()->create(['name' => 'Jane Doe']);

    $this->post(route('password.request'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $this->post(route('password.update'), [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])->assertSessionHasNoErrors();

        return true;
    });

    $activity = Activity::query()->where('log_name', 'auth')->latest('id')->first();

    expect($activity)->not->toBeNull();
    expect($activity->description)->toBe('Jane Doe reset their password');
    expect($activity->causer->is($user))->toBeTrue();
});

test('verifying an email via the real signed link logs activity', function () {
    $user = User::factory()->unverified()->create(['name' => 'Jane Doe']);

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)],
    );

    $this->actingAs($user)->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();

    $activity = Activity::query()->where('log_name', 'auth')->latest('id')->first();

    expect($activity)->not->toBeNull();
    expect($activity->description)->toBe('Jane Doe verified their email address');
    expect($activity->causer->is($user))->toBeTrue();
});
