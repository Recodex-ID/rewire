<?php

use App\Models\Setting;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

test('non-admin cannot access the settings page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('system.settings'))->assertForbidden();
});

test('admin can view and save settings', function () {
    $admin = User::factory()->create();
    $admin->assignRole(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    $this->get(route('system.settings'))->assertOk();

    Livewire::test('pages::app.system.settings')
        ->set('seoDescription', 'A starter kit for client projects.')
        ->set('analyticsId', 'G-ABC1234567')
        ->call('save')
        ->assertHasNoErrors();

    expect(Setting::get('seo_description'))->toBe('A starter kit for client projects.');
    expect(Setting::get('analytics_id'))->toBe('G-ABC1234567');
});

test('the analytics id must look like a GA4 measurement id', function (string $invalid) {
    $admin = User::factory()->create();
    $admin->assignRole(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    Livewire::test('pages::app.system.settings')
        ->set('analyticsId', $invalid)
        ->call('save')
        ->assertHasErrors(['analyticsId']);

    expect(Setting::get('analytics_id'))->toBeNull();
})->with([
    'script injection' => ["G-1');alert(1);//"],
    'universal analytics id' => ['UA-12345-1'],
    'lowercase' => ['g-abc123'],
]);

test('the analytics id can be cleared to switch tracking off', function () {
    Setting::put('analytics_id', 'G-ABC1234567');

    $admin = User::factory()->create();
    $admin->assignRole(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    Livewire::test('pages::app.system.settings')
        ->set('analyticsId', '')
        ->call('save')
        ->assertHasNoErrors();

    expect(Setting::get('analytics_id'))->toBeEmpty();
});
