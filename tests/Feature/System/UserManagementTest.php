<?php

use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

test('non-admin cannot access the users page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('system.users'))->assertForbidden();
});

test('admin can view the users list', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $other = User::factory()->create(['name' => 'Jane Doe']);

    $this->actingAs($admin)
        ->get(route('system.users'))
        ->assertOk()
        ->assertSee('Jane Doe');
});

test('admin can change another user\'s role', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $member = User::factory()->create();

    $this->actingAs($admin);

    Livewire::test('pages::app.system.users')
        ->call('edit', $member->id)
        ->set('editingRole', 'admin')
        ->call('updateRole');

    expect($member->fresh()->hasRole('admin'))->toBeTrue();
    expect($member->fresh()->hasRole('staff'))->toBeFalse();
});

test('changing a role to one that does not exist is rejected', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $member = User::factory()->create();

    $this->actingAs($admin);

    Livewire::test('pages::app.system.users')
        ->call('edit', $member->id)
        ->set('editingRole', 'superuser')
        ->call('updateRole')
        ->assertHasErrors(['editingRole']);

    expect($member->fresh()->hasRole('staff'))->toBeTrue();
    expect($member->fresh()->hasRole('superuser'))->toBeFalse();
});

test('admin cannot remove their own admin role', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    Livewire::test('pages::app.system.users')
        ->call('edit', $admin->id)
        ->set('editingRole', 'staff')
        ->call('updateRole');

    expect($admin->fresh()->hasRole('admin'))->toBeTrue();
});

test('admin does not see super admin accounts in the users list', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $superAdmin = User::factory()->create(['name' => 'Secret Admin']);
    $superAdmin->syncRoles(Role::findOrCreate('super-admin'));

    $this->actingAs($admin)
        ->get(route('system.users'))
        ->assertOk()
        ->assertDontSee('Secret Admin');
});

test('super admin sees super admin accounts in the users list', function () {
    $actingSuperAdmin = User::factory()->create();
    $actingSuperAdmin->syncRoles(Role::findOrCreate('super-admin'));

    $superAdmin = User::factory()->create(['name' => 'Secret Admin']);
    $superAdmin->syncRoles(Role::findOrCreate('super-admin'));

    $this->actingAs($actingSuperAdmin)
        ->get(route('system.users'))
        ->assertOk()
        ->assertSee('Secret Admin');
});

test('admin cannot change a super admin\'s role', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $superAdmin = User::factory()->create();
    $superAdmin->syncRoles(Role::findOrCreate('super-admin'));

    $this->actingAs($admin);

    Livewire::test('pages::app.system.users')
        ->call('edit', $superAdmin->id)
        ->set('editingRole', 'admin')
        ->call('updateRole');

    expect($superAdmin->fresh()->hasRole('super-admin'))->toBeTrue();
});

test('super admin can change another super admin\'s role', function () {
    $actingSuperAdmin = User::factory()->create();
    $actingSuperAdmin->syncRoles(Role::findOrCreate('super-admin'));

    $superAdmin = User::factory()->create();
    $superAdmin->syncRoles(Role::findOrCreate('super-admin'));
    Role::findOrCreate('admin');

    $this->actingAs($actingSuperAdmin);

    Livewire::test('pages::app.system.users')
        ->call('edit', $superAdmin->id)
        ->set('editingRole', 'admin')
        ->call('updateRole');

    expect($superAdmin->fresh()->hasRole('admin'))->toBeTrue();
});

test('admin can delete another user', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $member = User::factory()->create();

    $this->actingAs($admin);

    Livewire::test('pages::app.system.users')->call('delete', $member->id);

    $this->assertDatabaseMissing('users', ['id' => $member->id]);
});

test('admin cannot delete their own account', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    Livewire::test('pages::app.system.users')->call('delete', $admin->id);

    $this->assertDatabaseHas('users', ['id' => $admin->id]);
});

test('admin can create a new user with a chosen role', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));
    Role::findOrCreate('editor');

    $this->actingAs($admin);

    Livewire::test('pages::app.system.users')
        ->set('name', 'Jane Doe')
        ->set('email', 'jane@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->set('role', 'editor')
        ->call('createUser')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('users', ['email' => 'jane@example.com']);

    $user = User::query()->where('email', 'jane@example.com')->firstOrFail();

    expect($user->hasRole('editor'))->toBeTrue();
    expect($user->hasRole('staff'))->toBeFalse();
    expect($user->email_verified_at)->not->toBeNull();
});

test('creating a user with an already taken email fails validation', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $existing = User::factory()->create();

    $this->actingAs($admin);

    Livewire::test('pages::app.system.users')
        ->set('name', 'Jane Doe')
        ->set('email', $existing->email)
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->set('role', 'staff')
        ->call('createUser')
        ->assertHasErrors(['email']);
});

test('creating a user with a mismatched password confirmation fails validation', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    Livewire::test('pages::app.system.users')
        ->set('name', 'Jane Doe')
        ->set('email', 'jane@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'different')
        ->set('role', 'staff')
        ->call('createUser')
        ->assertHasErrors(['password']);
});
