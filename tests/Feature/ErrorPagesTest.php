<?php

use App\Models\User;

test('404 page renders the branded error page', function () {
    $response = $this->get('/this-route-does-not-exist');

    $response->assertNotFound();
    $response->assertSee('Not Found');
    $response->assertSee('Back to home');
    $response->assertDontSee('@vite', false);
});

test('403 page renders the branded error page for a non-admin user', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('admin.users'));

    $response->assertForbidden();
    $response->assertSee('Back to home');
});
