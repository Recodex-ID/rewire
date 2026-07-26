<?php

use App\Models\LandingPageSection;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

test('non-admin cannot access the landing page editor', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('app.landing-page.edit'))->assertForbidden();
});

test('admin can view the landing page editor', function () {
    $admin = User::factory()->create();
    $admin->assignRole(Role::findOrCreate('admin'));

    $this->actingAs($admin)->get(route('app.landing-page.edit'))->assertOk();
});

test('admin can update the hero section', function () {
    LandingPageSection::create([
        'key' => 'hero',
        'content' => [
            'heading_line1' => 'H1', 'heading_highlight' => 'H2', 'heading_line2' => 'H3', 'subheading' => 'S',
            'primary_cta_text' => 'Go', 'primary_cta_url' => '/', 'secondary_cta_text' => '', 'secondary_cta_url' => '',
            'badge_text' => '', 'badge_secondary' => '', 'stats' => [],
        ],
        'is_visible' => true,
    ]);

    $admin = User::factory()->create();
    $admin->assignRole(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    Livewire::test('pages::app.landing-page.hero')
        ->set('data.heading_line1', 'New heading')
        ->call('save')
        ->assertHasNoErrors();

    expect(LandingPageSection::where('key', 'hero')->first()->content['heading_line1'])->toBe('New heading');
});

test('admin can add and save a service item', function () {
    LandingPageSection::create([
        'key' => 'services',
        'content' => ['eyebrow' => '', 'heading' => 'H', 'subheading' => '', 'items' => []],
        'is_visible' => true,
    ]);

    $admin = User::factory()->create();
    $admin->assignRole(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    Livewire::test('pages::app.landing-page.services')
        ->call('addItem')
        ->set('data.items.0.number', '01')
        ->set('data.items.0.category', 'Cat')
        ->set('data.items.0.icon', 'cloud')
        ->set('data.items.0.title', 'Fast')
        ->set('data.items.0.description', 'Really fast')
        ->set('data.items.0.tags', 'A, B')
        ->call('save')
        ->assertHasNoErrors();

    expect(LandingPageSection::where('key', 'services')->first()->content['items'])->toBe([
        ['number' => '01', 'category' => 'Cat', 'icon' => 'cloud', 'title' => 'Fast', 'description' => 'Really fast', 'tags' => ['A', 'B']],
    ]);
});

test('admin can save a footer column with links', function () {
    LandingPageSection::create([
        'key' => 'footer',
        'content' => ['tagline' => '', 'columns' => [], 'social' => [], 'copyright_text' => ''],
        'is_visible' => true,
    ]);

    $admin = User::factory()->create();
    $admin->assignRole(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    Livewire::test('pages::app.landing-page.footer')
        ->call('addColumn')
        ->set('data.columns.0.heading', 'Product')
        ->set('data.columns.0.links', "Services|#services\nAbout|#about")
        ->call('save')
        ->assertHasNoErrors();

    expect(LandingPageSection::where('key', 'footer')->first()->content['columns'])->toBe([
        [
            'heading' => 'Product',
            'links' => [
                ['label' => 'Services', 'url' => '#services'],
                ['label' => 'About', 'url' => '#about'],
            ],
        ],
    ]);
});

test('admin can upload a hero background image', function () {
    Storage::fake('public');

    LandingPageSection::create([
        'key' => 'hero',
        'content' => [
            'heading_line1' => 'H1', 'heading_highlight' => 'H2', 'heading_line2' => 'H3', 'subheading' => 'S',
            'primary_cta_text' => 'Go', 'primary_cta_url' => '/', 'secondary_cta_text' => '', 'secondary_cta_url' => '',
            'badge_text' => '', 'badge_secondary' => '', 'background_image' => '', 'stats' => [],
        ],
        'is_visible' => true,
    ]);

    $admin = User::factory()->create();
    $admin->assignRole(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    Livewire::test('pages::app.landing-page.hero')
        ->set('backgroundImageUpload', UploadedFile::fake()->image('hero.jpg'))
        ->call('save')
        ->assertHasNoErrors();

    $path = LandingPageSection::where('key', 'hero')->first()->content['background_image'];

    expect($path)->not->toBeEmpty();
    Storage::disk('public')->assertExists($path);
});

test('admin can upload a trusted-by logo image', function () {
    Storage::fake('public');

    LandingPageSection::create([
        'key' => 'trusted_by',
        'content' => ['heading' => 'H', 'logos' => []],
        'is_visible' => true,
    ]);

    $admin = User::factory()->create();
    $admin->assignRole(Role::findOrCreate('admin'));

    $this->actingAs($admin);

    Livewire::test('pages::app.landing-page.trusted-by')
        ->call('addLogo')
        ->set('data.logos.0.name', 'Acme')
        ->set('data.logos.0.upload', UploadedFile::fake()->image('logo.png'))
        ->call('save')
        ->assertHasNoErrors();

    $logos = LandingPageSection::where('key', 'trusted_by')->first()->content['logos'];

    expect($logos)->toHaveCount(1);
    expect($logos[0]['name'])->toBe('Acme');
    expect($logos[0])->not->toHaveKey('upload');
    Storage::disk('public')->assertExists($logos[0]['image']);
});
