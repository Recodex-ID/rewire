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
        $admin->syncRoles(Role::findOrCreate('admin'));

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
        LandingPageSection::query()->updateOrCreate(['key' => 'navbar'], [
            'content' => [
                'logo_text' => 'Rewire',
                'logo_subtext' => 'Starter Kit',
                'nav_items' => [
                    ['label' => 'Services', 'url' => '#services'],
                    ['label' => 'Infrastructure', 'url' => '#infrastructure'],
                    ['label' => 'Solutions', 'url' => '#solutions'],
                    ['label' => 'About', 'url' => '#about'],
                    ['label' => 'Contact', 'url' => '#contact'],
                ],
                'cta_text' => 'Get started',
                'cta_url' => '#contact',
            ],
        ]);

        LandingPageSection::query()->updateOrCreate(['key' => 'hero'], [
            'content' => [
                'badge_text' => 'Built on Laravel & Livewire',
                'badge_secondary' => 'Ready for your next client project',
                'heading_line1' => 'Ship your next',
                'heading_highlight' => 'client project',
                'heading_line2' => 'in days, not weeks.',
                'subheading' => 'A reusable Laravel starter kit with authentication, roles, and a fully CMS-managed landing page — so every new project starts from a working foundation, not a blank repo.',
                'primary_cta_text' => 'Get started',
                'primary_cta_url' => '#contact',
                'secondary_cta_text' => 'Explore features',
                'secondary_cta_url' => '#services',
                'stats' => [
                    ['value' => '15', 'suffix' => '+', 'label' => 'Reusable modules'],
                    ['value' => '2', 'suffix' => '', 'label' => 'Roles built in'],
                    ['value' => '100', 'suffix' => '%', 'label' => 'Content editable'],
                ],
            ],
        ]);

        LandingPageSection::query()->updateOrCreate(['key' => 'trusted_by'], [
            'content' => [
                'heading' => 'Built with tools you already trust',
                'logos' => [
                    ['name' => 'Laravel'],
                    ['name' => 'Livewire'],
                    ['name' => 'Flux UI'],
                    ['name' => 'Pest'],
                    ['name' => 'Tailwind'],
                    ['name' => 'Spatie'],
                ],
            ],
        ]);

        LandingPageSection::query()->updateOrCreate(['key' => 'services'], [
            'content' => [
                'eyebrow' => 'Capabilities',
                'heading' => 'Everything a client project starts with',
                'subheading' => 'Foundational features every new project needs, already wired together so you can focus on what makes each client different.',
                'items' => [
                    [
                        'number' => '01',
                        'category' => 'Auth',
                        'icon' => 'cloud',
                        'title' => 'Authentication',
                        'description' => 'Login, registration, and password reset out of the box, built on Laravel Fortify.',
                        'tags' => ['Fortify', 'Sessions'],
                    ],
                    [
                        'number' => '02',
                        'category' => 'Access',
                        'icon' => 'shield',
                        'title' => 'Roles & Permissions',
                        'description' => 'Every user gets a role automatically. Admins get a gated back office.',
                        'tags' => ['Spatie', 'Roles'],
                    ],
                    [
                        'number' => '03',
                        'category' => 'Content',
                        'icon' => 'brain',
                        'title' => 'CMS-Managed Content',
                        'description' => 'This entire landing page is edited from the admin panel — no redeploy needed.',
                        'tags' => ['Livewire', 'CMS'],
                    ],
                    [
                        'number' => '04',
                        'category' => 'UI',
                        'icon' => 'code',
                        'title' => 'Flux UI Components',
                        'description' => 'A consistent component library for every screen behind the login.',
                        'tags' => ['Flux', 'Tailwind'],
                    ],
                    [
                        'number' => '05',
                        'category' => 'Quality',
                        'icon' => 'cog',
                        'title' => 'Tests From Day One',
                        'description' => 'Pest feature tests, Pint formatting, and Larastan static analysis, wired in.',
                        'tags' => ['Pest', 'Pint', 'Larastan'],
                    ],
                    [
                        'number' => '06',
                        'category' => 'Strategy',
                        'icon' => 'compass',
                        'title' => 'Ready to Extend',
                        'description' => 'Add billing, media, or notifications when a project actually needs them.',
                        'tags' => ['YAGNI'],
                    ],
                ],
            ],
        ]);

        LandingPageSection::query()->updateOrCreate(['key' => 'infrastructure'], [
            'content' => [
                'eyebrow' => 'Foundation',
                'heading_line1' => 'One codebase.',
                'heading_highlight' => 'Every client project.',
                'subheading' => 'Clone this starter kit for each new engagement and keep the same reliable core: auth, roles, and an editable landing page.',
                'status_label' => 'All checks passing',
                'latency_value' => '35',
                'data_centers_value' => '2',
                'regions' => [
                    ['name' => 'Backend', 'cities' => 'Laravel 13 · Fortify · Spatie Permission'],
                    ['name' => 'Frontend', 'cities' => 'Livewire 4 · Flux UI · Tailwind v4'],
                    ['name' => 'Quality', 'cities' => 'Pest 4 · Pint · Larastan'],
                ],
            ],
        ]);

        LandingPageSection::query()->updateOrCreate(['key' => 'stats'], [
            'content' => [
                'eyebrow' => 'Impact',
                'heading_line1' => 'Less setup.',
                'heading_highlight' => 'More building.',
                'items' => [
                    ['value' => '90', 'suffix' => '%', 'label' => 'Less boilerplate', 'sublabel' => 'per new project'],
                    ['value' => '2', 'suffix' => '', 'label' => 'Roles ready', 'sublabel' => 'admin & member'],
                    ['value' => '100', 'suffix' => '%', 'label' => 'Test coverage', 'sublabel' => 'on core features'],
                    ['value' => '1', 'suffix' => ' day', 'label' => 'To first deploy', 'sublabel' => 'from clone to live'],
                ],
            ],
        ]);

        LandingPageSection::query()->updateOrCreate(['key' => 'case_studies'], [
            'content' => [
                'eyebrow' => 'Solutions',
                'heading' => 'Built for how client work actually happens',
                'items' => [
                    [
                        'category' => 'Internal tool',
                        'year' => '2026',
                        'title' => 'Spin up an admin-gated back office in an afternoon.',
                        'description' => 'Roles, a landing page, and an authenticated dashboard are already wired together — customize the parts that make this project unique.',
                        'metrics' => [
                            ['value' => '1', 'label' => 'Afternoon'],
                            ['value' => '0', 'label' => 'Boilerplate'],
                        ],
                    ],
                    [
                        'category' => 'Client site',
                        'year' => '2026',
                        'title' => 'Hand the landing page to a non-technical client.',
                        'description' => 'Every section — copy, images, links — is editable from the admin panel, so content updates never need a developer.',
                        'metrics' => [
                            ['value' => '11', 'label' => 'Editable sections'],
                            ['value' => '0', 'label' => 'Redeploys needed'],
                        ],
                    ],
                ],
            ],
        ]);

        LandingPageSection::query()->updateOrCreate(['key' => 'process'], [
            'content' => [
                'eyebrow' => 'How it works',
                'heading' => 'From clone to client-ready',
                'subheading' => 'A predictable path from starter kit to a project you can hand off.',
                'stats' => [
                    ['value' => '4', 'label' => 'Steps'],
                    ['value' => '1', 'label' => 'Codebase'],
                ],
                'steps' => [
                    ['number' => '01', 'title' => 'Clone & configure', 'description' => 'Set the app name, environment, and database for the new project.', 'duration' => '~10 min'],
                    ['number' => '02', 'title' => 'Edit the content', 'description' => 'Log in as admin and update the landing page copy, services, and contact details.', 'duration' => '~30 min'],
                    ['number' => '03', 'title' => 'Build what is unique', 'description' => 'Add the features that make this client project different from the last one.', 'duration' => 'Varies'],
                    ['number' => '04', 'title' => 'Ship it', 'description' => 'Deploy with the same auth, roles, and tests already in place.', 'duration' => '~1 day'],
                ],
            ],
        ]);

        LandingPageSection::query()->updateOrCreate(['key' => 'testimonials'], [
            'content' => [
                'eyebrow' => 'Voices',
                'heading' => 'What people say',
                'items' => [
                    ['quote' => 'This starter kit saved us weeks of setup on our last three client projects.', 'name' => 'Jane Doe', 'role' => 'Founder, Acme Inc', 'rating' => 5],
                    ['quote' => 'Handing the landing page over to the client was painless — they edit it themselves now.', 'name' => 'John Smith', 'role' => 'Lead Developer', 'rating' => 5],
                    ['quote' => 'Roles were already wired up, so gating our admin panel took minutes instead of days.', 'name' => 'Amelia Putri', 'role' => 'CTO, Nimbus Studio', 'rating' => 5],
                ],
            ],
        ]);

        LandingPageSection::query()->updateOrCreate(['key' => 'cta'], [
            'content' => [
                'eyebrow' => "Let's build",
                'heading_line1' => 'Ready to start',
                'heading_line2' => 'your next project?',
                'subheading' => 'Clone the starter kit, log in as admin, and make it yours.',
                'primary_text' => 'Create an account',
                'primary_url' => '#',
                'secondary_text' => 'Contact us',
                'secondary_url' => 'mailto:hello@recodex.id',
                'contact_label' => 'Direct contact',
                'address_label' => 'HQ',
                'address' => 'Jakarta, Indonesia',
                'email' => 'hello@recodex.id',
                'phone' => '+62 21 0000 0000',
            ],
        ]);

        LandingPageSection::query()->updateOrCreate(['key' => 'footer'], [
            'content' => [
                'tagline' => 'A reusable Laravel starter kit for internal and client projects — authentication, roles, and a CMS-managed landing page, ready to go.',
                'columns' => [
                    [
                        'heading' => 'Product',
                        'links' => [
                            ['label' => 'Services', 'url' => '#services'],
                            ['label' => 'Infrastructure', 'url' => '#infrastructure'],
                            ['label' => 'Solutions', 'url' => '#solutions'],
                        ],
                    ],
                    [
                        'heading' => 'Company',
                        'links' => [
                            ['label' => 'About', 'url' => '#about'],
                            ['label' => 'Contact', 'url' => '#contact'],
                        ],
                    ],
                    [
                        'heading' => 'Account',
                        'links' => [
                            ['label' => 'Log in', 'url' => '#'],
                            ['label' => 'Register', 'url' => '#'],
                        ],
                    ],
                ],
                'social' => [
                    ['platform' => 'linkedin', 'url' => '#'],
                    ['platform' => 'twitter', 'url' => '#'],
                    ['platform' => 'github', 'url' => '#'],
                ],
                'copyright_text' => '© '.date('Y').' Rewire Starterkit. All rights reserved.',
            ],
        ]);
    }
}
