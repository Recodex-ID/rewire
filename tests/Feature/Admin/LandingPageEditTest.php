<?php

use App\Models\LandingPageSection;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    LandingPageSection::create(['key' => 'hero', 'content' => ['heading' => 'H', 'subheading' => 'S', 'cta_text' => 'C', 'cta_url' => '/'], 'is_visible' => true]);
    LandingPageSection::create(['key' => 'features', 'content' => ['heading' => 'F', 'items' => []], 'is_visible' => true]);
    LandingPageSection::create(['key' => 'testimonials', 'content' => ['heading' => 'T', 'items' => []], 'is_visible' => true]);
    LandingPageSection::create(['key' => 'cta', 'content' => ['heading' => 'C', 'button_text' => 'B', 'button_url' => '/'], 'is_visible' => true]);
});

test('non-admin cannot access the landing page editor', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('admin.landing-page.edit'))->assertForbidden();
});

test('admin can view the landing page editor', function () {
    $admin = User::factory()->create();
    $admin->assignRole(Role::findOrCreate('admin'));

    $this->actingAs($admin)->get(route('admin.landing-page.edit'))->assertOk();
});

test('admin can update the hero section', function () {
    $admin = User::factory()->create();
    $admin->assignRole(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    Livewire::test('pages::admin.landing-page')
        ->set('hero.heading', 'New heading')
        ->set('hero.subheading', 'New subheading')
        ->set('hero.cta_text', 'Go')
        ->set('hero.cta_url', '/go')
        ->call('saveHero')
        ->assertHasNoErrors();

    expect(LandingPageSection::where('key', 'hero')->first()->content['heading'])->toBe('New heading');
});

test('admin can add and save a feature item', function () {
    $admin = User::factory()->create();
    $admin->assignRole(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    Livewire::test('pages::admin.landing-page')
        ->call('addFeature')
        ->set('features.heading', 'Why us')
        ->set('features.items.0.title', 'Fast')
        ->set('features.items.0.description', 'Really fast')
        ->call('saveFeatures')
        ->assertHasNoErrors();

    expect(LandingPageSection::where('key', 'features')->first()->content['items'])->toBe([
        ['title' => 'Fast', 'description' => 'Really fast'],
    ]);
});
