<?php

use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

test('guest is redirected to login', function () {
    $this->get(route('super-admin.access-control'))->assertRedirect(route('login'));
});

test('regular admin cannot access the access control page', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $this->actingAs($admin)->get(route('super-admin.access-control'))->assertForbidden();
});

test('super admin can view the access control page', function () {
    $superAdmin = User::factory()->create();
    $superAdmin->syncRoles(Role::findOrCreate('super-admin'));

    $this->actingAs($superAdmin)
        ->get(route('super-admin.access-control'))
        ->assertOk()
        ->assertSee('Access Control');
});

test('super admin can create a role', function () {
    $superAdmin = User::factory()->create();
    $superAdmin->syncRoles(Role::findOrCreate('super-admin'));

    $this->actingAs($superAdmin);

    Livewire::test('pages::super-admin.access-control')
        ->set('roleName', 'editor')
        ->call('createRole')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('roles', ['name' => 'editor']);
});

test('super admin can create a permission', function () {
    $superAdmin = User::factory()->create();
    $superAdmin->syncRoles(Role::findOrCreate('super-admin'));

    $this->actingAs($superAdmin);

    Livewire::test('pages::super-admin.access-control')
        ->set('permissionName', 'manage-posts')
        ->call('createPermission')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('permissions', ['name' => 'manage-posts']);
});

test('super admin can assign permissions to a role', function () {
    $superAdmin = User::factory()->create();
    $superAdmin->syncRoles(Role::findOrCreate('super-admin'));

    $role = Role::findOrCreate('editor');
    $permission = Permission::findOrCreate('manage-posts');

    $this->actingAs($superAdmin);

    Livewire::test('pages::super-admin.access-control')
        ->call('editPermissions', $role->id)
        ->set('editingPermissionIds', [$permission->id])
        ->call('updatePermissions');

    expect($role->fresh()->hasPermissionTo('manage-posts'))->toBeTrue();
});

test('core roles cannot be deleted', function () {
    $superAdmin = User::factory()->create();
    $superAdmin->syncRoles(Role::findOrCreate('super-admin'));

    $admin = Role::findOrCreate('admin');

    $this->actingAs($superAdmin);

    Livewire::test('pages::super-admin.access-control')->call('deleteRole', $admin->id);

    $this->assertDatabaseHas('roles', ['name' => 'admin']);
});

test('non core role can be deleted', function () {
    $superAdmin = User::factory()->create();
    $superAdmin->syncRoles(Role::findOrCreate('super-admin'));

    $role = Role::findOrCreate('editor');

    $this->actingAs($superAdmin);

    Livewire::test('pages::super-admin.access-control')->call('deleteRole', $role->id);

    $this->assertDatabaseMissing('roles', ['name' => 'editor']);
});

test('regular admin cannot assign the super-admin role to a user', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    Role::findOrCreate('super-admin');
    $member = User::factory()->create();

    $this->actingAs($admin);

    Livewire::test('pages::app.system.users')
        ->call('edit', $member->id)
        ->set('editingRole', 'super-admin')
        ->call('updateRole')
        ->assertHasErrors(['editingRole']);

    expect($member->fresh()->hasRole('super-admin'))->toBeFalse();
});
