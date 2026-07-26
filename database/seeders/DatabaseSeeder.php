<?php

namespace Database\Seeders;

use App\Models\LandingPageSection;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@recodex.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole(Role::findOrCreate('admin'));

        $member = User::create([
            'name' => 'Member',
            'email' => 'member@recodex.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $member->assignRole(Role::findOrCreate('member'));

        $this->seedLandingPageSections();
    }

    /**
     * Seed the default landing page CMS content.
     */
    private function seedLandingPageSections(): void
    {
        LandingPageSection::query()->updateOrCreate(['key' => 'hero'], [
            'content' => [
                'heading' => 'Build your next project faster',
                'subheading' => 'A starter kit with auth, roles, and a CMS-managed landing page ready to go.',
                'cta_text' => 'Get started',
                'cta_url' => '#',
            ],
        ]);

        LandingPageSection::query()->updateOrCreate(['key' => 'features'], [
            'content' => [
                'heading' => 'Everything you need',
                'items' => [
                    ['title' => 'Authentication', 'description' => 'Login, registration, and password reset out of the box.'],
                    ['title' => 'Roles & permissions', 'description' => 'Users get roles automatically, admins get a back office.'],
                    ['title' => 'Editable content', 'description' => 'This whole page is managed from the admin panel.'],
                ],
            ],
        ]);

        LandingPageSection::query()->updateOrCreate(['key' => 'testimonials'], [
            'content' => [
                'heading' => 'What people say',
                'items' => [
                    ['name' => 'Jane Doe', 'role' => 'Founder, Acme Inc', 'quote' => 'This starter kit saved us weeks of setup.'],
                ],
            ],
        ]);

        LandingPageSection::query()->updateOrCreate(['key' => 'cta'], [
            'content' => [
                'heading' => 'Ready to dive in?',
                'button_text' => 'Create an account',
                'button_url' => '#',
            ],
        ]);
    }
}
