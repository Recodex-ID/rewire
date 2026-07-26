<?php

use App\Models\Post;

test('the sitemap includes the home page, blog index, and published posts', function () {
    $published = Post::factory()->create(['is_published' => true]);
    $draft = Post::factory()->create(['is_published' => false]);

    $this->get(route('sitemap'))
        ->assertOk()
        ->assertSee(route('home'), false)
        ->assertSee(route('blogs'), false)
        ->assertSee(route('blog.detail', $published->slug), false)
        ->assertDontSee(route('blog.detail', $draft->slug), false);
});
