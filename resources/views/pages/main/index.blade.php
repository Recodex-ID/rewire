<x-layouts::main :seo-description="$seoDescription" :analytics-id="$analyticsId">
    @php
        $heroStats = [
            ['value' => '12', 'label' => 'Composer packages'],
            ['value' => '3', 'label' => 'Roles built in'],
            ['value' => '101', 'label' => 'Pest tests passing'],
        ];

        $trustedByLogos = ['Laravel', 'Livewire', 'Flux UI', 'Tailwind', 'Pest', 'Spatie'];

        $codeTabs = [
            'auth' => [
                'label' => 'Auth',
                'file' => 'routes/app.php',
                'code' => <<<'CODE'
                    Route::middleware(['auth', 'verified'])->group(function () {
                        Route::livewire('dashboard', 'pages::app.dashboard')->name('dashboard');

                        Route::middleware(['role:super-admin|admin'])->prefix('system')->group(function () {
                            // Users, Sitemap, Settings, Media Library
                        });
                    });
                    CODE,
            ],
            'roles' => [
                'label' => 'Roles',
                'file' => 'app/Models/User.php',
                'code' => <<<'CODE'
                    protected static function booted(): void
                    {
                        static::created(
                            fn (User $user) => $user->assignRole(Role::findOrCreate('staff'))
                        );
                    }
                    CODE,
            ],
            'blog' => [
                'label' => 'Blog',
                'file' => 'app/Models/Post.php',
                'code' => <<<'CODE'
                    public function registerMediaCollections(): void
                    {
                        $this->addMediaCollection('featured_image')
                            ->singleFile()
                            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
                    }

                    public function getSlugOptions(): SlugOptions
                    {
                        return SlugOptions::create()
                            ->generateSlugsFrom('title')
                            ->saveSlugsTo('slug')
                            ->doNotGenerateSlugsOnUpdate();
                    }
                    CODE,
            ],
            'tests' => [
                'label' => 'Tests',
                'file' => 'tests/Feature/System/UserManagementTest.php',
                'code' => <<<'CODE'
                    test('admin can view the users list', function () {
                        $admin = User::factory()->create();
                        $admin->syncRoles(Role::findOrCreate('admin'));

                        $other = User::factory()->create(['name' => 'Jane Doe']);

                        $this->actingAs($admin)
                            ->get(route('system.users'))
                            ->assertOk()
                            ->assertSee('Jane Doe');
                    });
                    CODE,
            ],
        ];

        $features = [
            ['title' => 'Authentication', 'description' => 'Login, registration, password reset, and email verification, built on Laravel Fortify.'],
            ['title' => 'Roles & permissions', 'description' => '3 roles (super-admin, admin, staff) via Spatie Permission. New roles are created with tinker or a seeder: no admin UI, by design.'],
            ['title' => 'Blog CMS', 'description' => 'Title, excerpt, body, featured image, and a publish toggle, with stable slugs via Spatie Sluggable.'],
            ['title' => 'Media Library', 'description' => 'Browse and delete every uploaded file across every model from one System panel page.'],
            ['title' => 'Per-role dashboards', 'description' => 'Each role (super-admin, admin, staff) gets its own Livewire dashboard with Chart.js charts.'],
            ['title' => 'System panel', 'description' => 'Users, Sitemap, Settings, and Media Library, gated to admin and super-admin.'],
            ['title' => 'Activity log', 'description' => 'Every admin action is audited via Spatie Activitylog, visible to super-admins.'],
            ['title' => 'Tests from day one', 'description' => '101 Pest tests, Pint formatting, and Larastan static analysis, wired into CI.'],
            ['title' => 'Automated releases', 'description' => 'release-please publishes a GitHub Release with a real changelog from Conventional Commits.'],
        ];

        $whyStack = [
            ['title' => 'Why Livewire', 'description' => 'Server-driven UI: no separate API layer or SPA build to maintain alongside the backend.'],
            ['title' => 'Why Spatie packages', 'description' => 'Battle-tested roles, media, slugs, activity logging, and sitemaps: nothing reinvented.'],
            ['title' => 'Why Pest', 'description' => 'Readable test syntax, and a real safety net: 101 tests covering every role boundary in this repo.'],
        ];

        $statsStrip = [
            ['value' => '12', 'label' => 'Composer packages'],
            ['value' => '3', 'label' => 'Roles built in'],
            ['value' => '101', 'label' => 'Tests passing'],
            ['value' => 'MIT', 'label' => 'Licensed'],
        ];

        $contactAddress = \App\Models\Setting::get('contact_address');
        $contactEmail = \App\Models\Setting::get('contact_email');
        $contactPhone = \App\Models\Setting::get('contact_phone');
    @endphp

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-brand-snow pt-32 pb-20 lg:pt-44 lg:pb-28">
        <div class="landing-dot-pattern absolute inset-0 opacity-40"></div>

        <div class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-16 px-6 lg:grid-cols-2 lg:px-8">
            <div>
                <h1 class="font-display text-5xl leading-[1.05] font-bold tracking-tight text-brand-navy sm:text-6xl">
                    Ship your next<br>
                    <span class="text-brand-accent-dark">client project</span><br>
                    in days, not weeks.
                </h1>

                <p class="mt-6 max-w-xl text-lg text-brand-navy/70">
                    A reusable Laravel starter kit with authentication, roles, and a blog ready to publish, so every new project starts from a working foundation, not a blank repo.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="{{ route('login') }}" wire:navigate class="inline-flex items-center gap-2 rounded-full bg-brand-navy px-6 py-3 text-sm font-medium text-brand-snow transition hover:bg-brand-navy-light">
                        Sign in to the dashboard
                        <x-heroicon-o-arrow-right class="size-4" />
                    </a>
                    <a href="https://github.com/Recodex-ID/rewire" target="_blank" class="inline-flex items-center gap-2 rounded-full border border-brand-navy/20 px-6 py-3 text-sm font-medium text-brand-navy transition hover:bg-brand-navy/5">
                        <x-si-github class="size-4" />
                        View on GitHub
                    </a>
                </div>

                <div class="mt-14 grid grid-cols-3 gap-6 border-t border-brand-navy/10 pt-8">
                    @foreach ($heroStats as $stat)
                        <div>
                            <div class="font-display text-3xl font-bold text-brand-navy">{{ $stat['value'] }}</div>
                            <div class="mt-1 text-xs text-brand-navy/50">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-brand-navy/10 bg-brand-navy shadow-xl">
                <div class="flex items-center gap-1.5 border-b border-white/10 px-4 py-3">
                    <span class="size-2.5 rounded-full bg-red-400/70"></span>
                    <span class="size-2.5 rounded-full bg-yellow-400/70"></span>
                    <span class="size-2.5 rounded-full bg-green-400/70"></span>
                    <span class="ml-2 font-mono text-xs text-brand-silver/80">{{ $codeTabs['auth']['file'] }}</span>
                </div>
                <pre class="overflow-x-auto p-5 font-mono text-[13px] leading-relaxed text-brand-silver"><code>{{ $codeTabs['auth']['code'] }}</code></pre>
            </div>
        </div>
    </section>

    {{-- Built with --}}
    <section class="border-y border-brand-navy/10 bg-brand-snow py-8">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-center gap-x-10 gap-y-3 px-6 lg:px-8">
            @foreach ($trustedByLogos as $name)
                <span class="font-display text-sm font-semibold tracking-tight text-brand-navy/70">{{ $name }}</span>
            @endforeach
        </div>
    </section>

    {{-- Code showcase --}}
    <section id="code" class="scroll-mt-24 bg-brand-snow py-24">
        <div class="mx-auto max-w-5xl px-6 lg:px-8">
            <div class="text-center">
                <p class="font-mono text-xs font-semibold tracking-widest text-brand-accent-dark uppercase">Real code, not marketing copy</p>
                <h2 class="mt-4 font-display text-4xl font-bold tracking-tight text-brand-navy sm:text-5xl">
                    Every claim on this page ships in the repo
                </h2>
            </div>

            <div x-data="{ tab: 'auth' }" class="mt-14 overflow-hidden rounded-2xl border border-brand-navy/10 bg-brand-navy shadow-xl">
                <div class="flex items-center gap-1 overflow-x-auto border-b border-white/10 px-3">
                    @foreach ($codeTabs as $key => $tab)
                        <button
                            type="button"
                            x-on:click="tab = '{{ $key }}'"
                            :class="tab === '{{ $key }}' ? 'text-brand-snow border-brand-accent' : 'text-brand-silver/80 border-transparent'"
                            class="shrink-0 border-b-2 px-4 py-3 font-mono text-sm transition"
                        >
                            {{ $tab['label'] }}
                        </button>
                    @endforeach
                </div>

                @foreach ($codeTabs as $key => $tab)
                    <div x-show="tab === '{{ $key }}'" x-cloak>
                        <div class="border-b border-white/10 px-5 py-2 font-mono text-xs text-brand-silver/80">{{ $tab['file'] }}</div>
                        <pre class="overflow-x-auto p-5 font-mono text-[13px] leading-relaxed text-brand-silver"><code>{{ $tab['code'] }}</code></pre>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Checklist features --}}
    <section id="features" class="scroll-mt-24 bg-brand-snow py-24">
        <div class="mx-auto max-w-4xl px-6 lg:px-8">
            <h2 class="font-display text-4xl font-bold tracking-tight text-brand-navy sm:text-5xl">
                Everything this repo actually ships
            </h2>

            <div class="mt-12 divide-y divide-brand-navy/10 border-t border-brand-navy/10">
                @foreach ($features as $feature)
                    <div class="flex items-start gap-4 py-5">
                        <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-full bg-brand-accent/15 text-brand-accent-dark">
                            <x-heroicon-o-check class="size-3.5" />
                        </span>
                        <div>
                            <h3 class="font-medium text-brand-navy">{{ $feature['title'] }}</h3>
                            <p class="mt-1 text-sm text-brand-navy/70">{{ $feature['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Why this stack --}}
    <section class="bg-white py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <h2 class="text-center font-display text-3xl font-bold tracking-tight text-brand-navy sm:text-4xl">
                Why this stack
            </h2>

            <div class="mt-12 grid gap-6 lg:grid-cols-3">
                @foreach ($whyStack as $card)
                    <div class="rounded-2xl border border-brand-navy/10 p-8">
                        <h3 class="font-display text-lg font-semibold text-brand-navy">{{ $card['title'] }}</h3>
                        <p class="mt-3 text-sm text-brand-navy/70">{{ $card['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Stats strip --}}
    <section class="bg-brand-navy py-16">
        <div class="mx-auto grid max-w-7xl grid-cols-2 gap-8 px-6 lg:grid-cols-4 lg:px-8">
            @foreach ($statsStrip as $stat)
                <div class="text-center">
                    <div class="font-display text-4xl font-bold text-brand-snow">{{ $stat['value'] }}</div>
                    <div class="mt-1 text-xs tracking-wide text-brand-silver/80 uppercase">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- CTA --}}
    <section id="contact" class="scroll-mt-24 bg-brand-snow py-24">
        <div class="landing-reveal relative mx-auto max-w-6xl overflow-hidden rounded-3xl bg-brand-navy px-6 py-16 sm:px-12 lg:px-16">
            <div class="landing-grid-bg-dark absolute inset-0"></div>

            <div class="relative grid grid-cols-1 gap-12 lg:grid-cols-12 lg:items-center">
                <div class="lg:col-span-7">
                    <p class="font-mono text-sm font-medium tracking-wide text-brand-accent">
                        Let's build
                    </p>
                    <h2 class="mt-4 font-display text-3xl font-bold tracking-tight text-brand-snow sm:text-4xl lg:text-5xl">
                        Ready to start
                        <br>
                        your next project?
                    </h2>
                    <p class="mt-6 max-w-xl text-lg text-brand-snow/70">
                        Clone the starter kit, log in as admin, and make it yours.
                    </p>

                    <div class="mt-10 flex flex-wrap items-center gap-4">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-full bg-brand-accent px-6 py-3 text-sm font-medium text-brand-navy transition hover:bg-brand-accent-dark">
                            Create an account
                            <x-heroicon-o-arrow-right class="size-4" />
                        </a>
                        <a href="mailto:{{ $contactEmail }}" class="inline-flex items-center gap-2 rounded-full border border-brand-snow/20 px-6 py-3 text-sm font-medium text-brand-snow transition hover:bg-brand-snow/10">
                            <x-heroicon-o-envelope class="size-4" />
                            Contact us
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="rounded-2xl border border-brand-snow/10 bg-brand-snow/5 p-8 backdrop-blur">
                        <p class="font-mono text-xs font-medium tracking-wide text-brand-accent uppercase">
                            Direct contact
                        </p>

                        <div class="mt-6 space-y-6">
                            <div class="flex items-start gap-4">
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-accent/10">
                                    <x-heroicon-o-map-pin class="size-5 text-brand-accent" />
                                </span>
                                <div>
                                    <p class="text-sm text-brand-snow/60">HQ</p>
                                    <p class="mt-1 font-medium text-brand-snow">{{ $contactAddress }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-accent/10">
                                    <x-heroicon-o-envelope class="size-5 text-brand-accent" />
                                </span>
                                <div>
                                    <p class="text-sm text-brand-snow/60">Email</p>
                                    <p class="mt-1 font-medium text-brand-snow">{{ $contactEmail }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-accent/10">
                                    <x-heroicon-o-phone class="size-5 text-brand-accent" />
                                </span>
                                <div>
                                    <p class="text-sm text-brand-snow/60">Phone</p>
                                    <p class="mt-1 font-medium text-brand-snow">{{ $contactPhone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts::main>
