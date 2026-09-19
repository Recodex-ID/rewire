<?php

use App\Http\Middleware\RejectSpamSubmissions;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Notification;

test('every response carries the baseline security headers', function () {
    $this->get(route('home'))
        ->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
        ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
        ->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

    $this->get('/this-route-does-not-exist')
        ->assertNotFound()
        ->assertHeader('X-Content-Type-Options', 'nosniff');
});

test('http is not redirected while force_https is off', function () {
    config(['app.force_https' => false]);

    $this->get('http://localhost/blog')->assertOk()->assertHeaderMissing('Strict-Transport-Security');
});

test('plain http requests are redirected to https when force_https is on', function () {
    config(['app.force_https' => true]);

    $this->get('http://localhost/blog?page=2')->assertRedirect('https://localhost/blog?page=2')->assertStatus(301);
});

test('non-GET requests keep their method through the https redirect', function () {
    config(['app.force_https' => true]);

    $this->post('http://localhost/login', [])->assertStatus(308)->assertRedirect('https://localhost/login');
});

test('the health check is exempt from the https redirect', function () {
    config(['app.force_https' => true]);

    $this->get('http://localhost/up')->assertOk();
});

test('https responses send HSTS when force_https is on', function () {
    config(['app.force_https' => true]);

    $this->get('https://localhost/blog')->assertOk()->assertHeader('Strict-Transport-Security', 'max-age=31536000');
});

test('a bot that fills the honeypot does not get an account', function () {
    $this->post(route('register.store'), [
        'name' => 'Spam Bot',
        'email' => 'bot@example.test',
        'password' => 'password',
        'password_confirmation' => 'password',
        RejectSpamSubmissions::HONEYPOT_FIELD => 'https://spam.example',
    ])->assertRedirect(route('home'));

    $this->assertGuest();
    expect(User::query()->where('email', 'bot@example.test')->exists())->toBeFalse();
});

test('a bot that fills the honeypot on the reset form sends no email', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), [
        'email' => $user->email,
        RejectSpamSubmissions::HONEYPOT_FIELD => 'https://spam.example',
    ])->assertRedirect(route('home'));

    Notification::assertNothingSent();
});

test('a real visitor who leaves the honeypot empty can still register', function () {
    $this->post(route('register.store'), [
        'name' => 'Real Person',
        'email' => 'real@example.test',
        'password' => 'password',
        'password_confirmation' => 'password',
        RejectSpamSubmissions::HONEYPOT_FIELD => '',
    ])->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('registration and reset forms render the honeypot field', function () {
    $field = 'name="'.RejectSpamSubmissions::HONEYPOT_FIELD.'"';

    $this->get(route('register'))->assertSee($field, false);
    $this->get(route('password.request'))->assertSee($field, false);
});

test('repeated sign-up attempts from one address are throttled', function () {
    foreach (range(1, 5) as $attempt) {
        $this->post(route('register.store'), ['email' => "nobody{$attempt}@example.test"])
            ->assertSessionHasErrors();
    }

    $this->post(route('register.store'), ['email' => 'nobody6@example.test'])->assertStatus(429);
});

test('repeated password reset requests from one address are throttled', function () {
    foreach (range(1, 5) as $attempt) {
        $this->post(route('password.email'), ['email' => 'nobody@example.test']);
    }

    $this->post(route('password.email'), ['email' => 'nobody@example.test'])->assertStatus(429);
});

test('the public site never leaks application secrets into the html', function () {
    $html = $this->get(route('home'))->getContent().$this->get(route('login'))->getContent();

    expect(config('app.key'))->not->toBeEmpty();
    expect($html)->not->toContain(config('app.key'));
    expect($html)->not->toContain('APP_KEY');
});

test('the audit log cleanup is scheduled so the retention in the privacy policy is enforced', function () {
    $scheduled = collect(app(Schedule::class)->events())
        ->contains(fn ($event) => str_contains($event->command, 'activitylog:clean'));

    expect($scheduled)->toBeTrue();
});
