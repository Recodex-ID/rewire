<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertOk();
});

test('non-admins do not see the audit log stat or admin activity feed', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertOk();
    $response->assertDontSee('Audit log entries');
});

test('admins see the audit log stat and real activity log entries', function () {
    $admin = User::factory()->create();
    $admin->assignRole(Role::findOrCreate('admin'));
    $this->actingAs($admin);

    activity('users')->performedOn($admin)->log("{$admin->name} was created with the admin role");

    $response = $this->get(route('dashboard'));
    $response->assertOk();
    $response->assertSee('Audit log entries');
    $response->assertSee("{$admin->name} was created with the admin role");
});
