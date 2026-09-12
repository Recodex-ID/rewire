<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

test('non-admin cannot access the media library page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('system.media-library'))->assertForbidden();
});

test('admin can view uploaded media', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $post = Post::factory()->create();
    $post->addMedia(UploadedFile::fake()->image('featured.jpg'))->toMediaCollection('featured_image');

    $this->actingAs($admin)->get(route('system.media-library'))
        ->assertOk()
        ->assertSee('featured.jpg');
});

test('admin can delete a media file', function () {
    $admin = User::factory()->create();
    $admin->syncRoles(Role::findOrCreate('admin'));

    $post = Post::factory()->create();
    $media = $post->addMedia(UploadedFile::fake()->image('featured.jpg'))->toMediaCollection('featured_image');

    $this->actingAs($admin);

    Livewire::test('pages::app.system.media-library')->call('delete', $media->id);

    $this->assertDatabaseMissing('media', ['id' => $media->id]);
});
