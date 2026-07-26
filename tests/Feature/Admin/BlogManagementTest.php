<?php

use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

test('non-admin cannot access the blog list page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('app.blog.index'))->assertForbidden();
});

test('admin can view the blog list', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $post = Post::factory()->create(['title' => 'Seeded Post']);

    $this->actingAs($admin)
        ->get(route('app.blog.index'))
        ->assertOk()
        ->assertSee($post->title);
});

test('admin can create a post', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    Livewire::test('pages::app.blog.form')
        ->set('title', 'My New Post')
        ->set('slug', 'my-new-post')
        ->set('excerpt', 'An excerpt.')
        ->set('body', 'The body.')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('posts', [
        'title' => 'My New Post',
        'slug' => 'my-new-post',
        'author_id' => $admin->id,
    ]);
});

test('admin can edit an existing post', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $post = Post::factory()->create(['title' => 'Original Title']);

    $this->actingAs($admin);

    Livewire::test('pages::app.blog.form', ['post' => $post])
        ->set('title', 'Updated Title')
        ->call('save')
        ->assertHasNoErrors();

    expect($post->fresh()->title)->toBe('Updated Title');
});

test('admin can delete a post', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $post = Post::factory()->create();

    $this->actingAs($admin);

    Livewire::test('pages::app.blog')->call('delete', $post->id);

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

test('creating a post without a slug generates one from the title', function () {
    $post = Post::create([
        'title' => 'Hello World',
        'slug' => '',
        'body' => 'Body.',
        'is_published' => false,
    ]);

    expect($post->slug)->toBe('hello-world');
});

test('creating a post with a duplicate slug gets a unique suffix', function () {
    Post::factory()->create(['slug' => 'hello-world']);

    $post = Post::create([
        'title' => 'Hello World',
        'slug' => 'hello-world',
        'body' => 'Body.',
        'is_published' => false,
    ]);

    expect($post->slug)->toBe('hello-world-1');
});

test('updating a post\'s title does not change its existing slug', function () {
    $post = Post::factory()->create(['title' => 'Original Title', 'slug' => 'original-title']);

    $post->update(['title' => 'A Completely Different Title']);

    expect($post->fresh()->slug)->toBe('original-title');
});

test('editing a post logs activity', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $post = Post::factory()->create(['is_published' => false]);

    $this->actingAs($admin);

    $countBeforeEdit = Activity::count();

    Livewire::test('pages::app.blog.form', ['post' => $post])
        ->set('isPublished', true)
        ->call('save')
        ->assertHasNoErrors();

    expect(Activity::count())->toBe($countBeforeEdit + 1);

    $activity = Activity::query()->latest('id')->first();

    expect($activity->event)->toBe('updated');
    expect($activity->description)->toContain($post->title);
});
