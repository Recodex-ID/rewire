<?php

use App\Models\User;
use Livewire\Livewire;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

test('non-admin cannot access the activity log page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('admin.activity'))->assertForbidden();
});

test('admin can view the activity log page', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $this->actingAs($admin)->get(route('admin.activity'))->assertOk();
});

test('creating a user logs activity with the acting admin as causer', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));
    Role::findOrCreate('editor');

    $this->actingAs($admin);

    Livewire::test('pages::app.admin.users')
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

    Livewire::test('pages::app.admin.users')
        ->call('edit', $member->id)
        ->set('editingRole', 'admin')
        ->call('updateRole');

    $activity = Activity::query()->latest()->first();

    expect($activity)->not->toBeNull();
});

test('deleting a user logs activity', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $member = User::factory()->create();

    $this->actingAs($admin);

    Livewire::test('pages::app.admin.users')->call('delete', $member->id);

    $activity = Activity::query()->latest()->first();

    expect($activity)->not->toBeNull();
});
