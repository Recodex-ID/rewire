<?php

use App\Models\Setting;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

test('non-admin cannot access the settings page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('admin.settings'))->assertForbidden();
});

test('admin can view and save settings', function () {
    $admin = User::factory()->create();
    $admin->assignRole(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    $this->get(route('admin.settings'))->assertOk();

    Livewire::test('pages::app.admin.settings')
        ->set('seoDescription', 'A starter kit for client projects.')
        ->set('analyticsId', 'G-ABC1234567')
        ->call('save')
        ->assertHasNoErrors();

    expect(Setting::get('seo_description'))->toBe('A starter kit for client projects.');
    expect(Setting::get('analytics_id'))->toBe('G-ABC1234567');
});
