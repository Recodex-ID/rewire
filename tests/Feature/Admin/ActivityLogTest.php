<?php

use App\Models\LandingPageSection;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

test('non-admin cannot access the activity log page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('app.activity.index'))->assertForbidden();
});

test('admin can view the activity log page', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $this->actingAs($admin)->get(route('app.activity.index'))->assertOk();
});

test('updating a landing page section logs activity', function () {
    LandingPageSection::create([
        'key' => 'hero',
        'content' => [
            'heading_line1' => 'H1', 'heading_highlight' => 'H2', 'heading_line2' => 'H3', 'subheading' => 'S',
            'primary_cta_text' => 'Go', 'primary_cta_url' => '/', 'secondary_cta_text' => '', 'secondary_cta_url' => '',
            'badge_text' => '', 'badge_secondary' => '', 'stats' => [],
        ],
        'is_visible' => true,
    ]);

    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    expect(Activity::count())->toBe(1);

    Livewire::test('pages::app.landing-page.hero')
        ->set('data.heading_line1', 'New heading')
        ->call('save')
        ->assertHasNoErrors();

    expect(Activity::count())->toBe(2);

    $activity = Activity::query()->latest('id')->first();

    expect($activity->event)->toBe('updated');
    expect($activity->description)->toContain('hero');
});

test('creating a user logs activity with the acting admin as causer', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));
    Role::findOrCreate('editor');

    $this->actingAs($admin);

    Livewire::test('pages::app.users')
        ->set('name', 'Jane Doe')
        ->set('email', 'jane@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->set('role', 'editor')
        ->call('createUser')
        ->assertHasNoErrors();

    $activity = Activity::query()->latest()->first();

    expect($activity)->not->toBeNull();
    expect($activity->causer->is($admin))->toBeTrue();
});

test('changing a role logs activity', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $member = User::factory()->create();

    $this->actingAs($admin);

    Livewire::test('pages::app.users')->call('updateRole', $member->id, 'admin');

    $activity = Activity::query()->latest()->first();

    expect($activity)->not->toBeNull();
});

test('deleting a user logs activity', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $member = User::factory()->create();

    $this->actingAs($admin);

    Livewire::test('pages::app.users')->call('delete', $member->id);

    $activity = Activity::query()->latest()->first();

    expect($activity)->not->toBeNull();
});
