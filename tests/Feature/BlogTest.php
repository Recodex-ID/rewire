<?php

use App\Models\Post;

test('the blog index shows published posts and hides drafts', function () {
    $published = Post::factory()->create(['title' => 'Published Post', 'is_published' => true]);
    $draft = Post::factory()->create(['title' => 'Draft Post', 'is_published' => false]);

    $this->get(route('blog.index'))
        ->assertOk()
        ->assertSee($published->title)
        ->assertDontSee($draft->title);
});

test('the blog show page renders a published post', function () {
    $post = Post::factory()->create([
        'title' => 'A Published Post',
        'body' => 'This is the body of the post.',
        'is_published' => true,
    ]);

    $this->get(route('blog.show', $post->slug))
        ->assertOk()
        ->assertSee($post->title)
        ->assertSee($post->body);
});

test('visiting a draft post 404s', function () {
    $post = Post::factory()->create(['is_published' => false]);

    $this->get(route('blog.show', $post->slug))->assertNotFound();
});

test('visiting a nonexistent post slug 404s', function () {
    $this->get(route('blog.show', 'nonexistent-slug'))->assertNotFound();
});
