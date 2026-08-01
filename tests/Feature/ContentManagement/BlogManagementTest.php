<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

test('any verified member can access the blog list page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('content-management.blogs'))->assertOk();
});

test('admin can view the blog list', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $post = Post::factory()->create(['title' => 'Seeded Post']);

    $this->actingAs($admin)
        ->get(route('content-management.blogs'))
        ->assertOk()
        ->assertSee($post->title);
});

test('admin can create a post', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    Livewire::test('pages::app.content-management.blogs')
        ->call('create')
        ->set('title', 'My New Post')
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

    Livewire::test('pages::app.content-management.blogs')
        ->call('edit', $post->id)
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

    Livewire::test('pages::app.content-management.blogs')->call('delete', $post->id);

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

test('uploading a featured image creates media with thumb, card, and hero conversions', function () {
    Storage::fake('public');

    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    Livewire::test('pages::app.content-management.blogs')
        ->call('create')
        ->set('title', 'Post with image')
        ->set('body', 'Body.')
        ->set('featuredImageUpload', UploadedFile::fake()->image('photo.jpg', 1200, 800))
        ->call('save')
        ->assertHasNoErrors();

    $post = Post::query()->where('title', 'Post with image')->firstOrFail();

    expect($post->getFirstMedia('featured_image'))->not->toBeNull();
    expect($post->getFirstMediaUrl('featured_image', 'thumb'))->not->toBe('');
    expect($post->getFirstMediaUrl('featured_image', 'card'))->not->toBe('');
    expect($post->getFirstMediaUrl('featured_image', 'hero'))->not->toBe('');
});

test('uploading a new featured image replaces the old one', function () {
    Storage::fake('public');

    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $post = Post::factory()->create();
    $post->addMedia(UploadedFile::fake()->image('first.jpg'))->toMediaCollection('featured_image');
    $firstMediaId = $post->getFirstMedia('featured_image')->id;

    $this->actingAs($admin);

    Livewire::test('pages::app.content-management.blogs')
        ->call('edit', $post->id)
        ->set('featuredImageUpload', UploadedFile::fake()->image('second.jpg'))
        ->call('save')
        ->assertHasNoErrors();

    $post->refresh();

    expect($post->getMedia('featured_image'))->toHaveCount(1);
    expect($post->getFirstMedia('featured_image')->id)->not->toBe($firstMediaId);
});

test('removing a featured image clears the media collection', function () {
    Storage::fake('public');

    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $post = Post::factory()->create();
    $post->addMedia(UploadedFile::fake()->image('photo.jpg'))->toMediaCollection('featured_image');

    $this->actingAs($admin);

    Livewire::test('pages::app.content-management.blogs')
        ->call('edit', $post->id)
        ->call('removeFeaturedImage');

    expect($post->fresh()->getFirstMedia('featured_image'))->toBeNull();
});

test('deleting a post also deletes its featured image media', function () {
    Storage::fake('public');

    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $post = Post::factory()->create();
    $post->addMedia(UploadedFile::fake()->image('photo.jpg'))->toMediaCollection('featured_image');
    $mediaId = $post->getFirstMedia('featured_image')->id;

    $this->actingAs($admin);

    Livewire::test('pages::app.content-management.blogs')->call('delete', $post->id);

    $this->assertDatabaseMissing('media', ['id' => $mediaId]);
});

test('editing a post logs activity', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $post = Post::factory()->create(['is_published' => false]);

    $this->actingAs($admin);

    $countBeforeEdit = Activity::count();

    Livewire::test('pages::app.content-management.blogs')
        ->call('edit', $post->id)
        ->set('isPublished', true)
        ->call('save')
        ->assertHasNoErrors();

    expect(Activity::count())->toBe($countBeforeEdit + 1);

    $activity = Activity::query()->latest('id')->first();

    expect($activity->event)->toBe('updated');
    expect($activity->description)->toContain($post->title);
});
