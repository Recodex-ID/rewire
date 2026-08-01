<?php

use App\Models\Post;
use App\Models\User;
use Spatie\Permission\Models\Role;

test('non-admin cannot access the sitemap page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('system.sitemap'))->assertForbidden();
});

test('admin can view the sitemap page and only sees published posts', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $published = Post::factory()->create(['is_published' => true]);
    $draft = Post::factory()->create(['is_published' => false]);

    $this->actingAs($admin)->get(route('system.sitemap'))
        ->assertOk()
        ->assertSee(route('blog.detail', $published->slug))
        ->assertDontSee(route('blog.detail', $draft->slug));
});
