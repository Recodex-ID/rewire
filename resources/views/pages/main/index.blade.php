<x-layouts::main :seo-description="$seoDescription" :analytics-id="$analyticsId">
    @php
        $icons = [
            'arrow-right' => '<path d="M4 12h16M14 6l6 6-6 6" />',
            'check' => '<path d="m5 12 5 5L20 7" />',
            'cloud' => '<path d="M6.5 19a4.5 4.5 0 0 1-.4-8.98 5.5 5.5 0 0 1 10.6-1.98A4.5 4.5 0 0 1 17.5 19h-11Z" />',
            'shield' => '<path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3Z" /><path d="m9 12 2 2 4-4" />',
            'brain' => '<circle cx="12" cy="12" r="8" /><path d="M12 8v8M8.5 10l7 4M8.5 14l7-4" />',
            'code' => '<path d="m8 8-4 4 4 4M16 8l4 4-4 4M13 6l-2 12" />',
            'cog' => '<circle cx="12" cy="12" r="3" /><path d="M12 3v2M12 19v2M4.2 6.2l1.4 1.4M18.4 16.4l1.4 1.4M3 12h2M19 12h2M4.2 17.8l1.4-1.4M18.4 7.6l1.4-1.4" />',
            'compass' => '<circle cx="12" cy="12" r="9" /><path d="m14.5 9.5-2 5-5 2 2-5 5-2Z" />',
            'mail' => '<rect x="3" y="5" width="18" height="14" rx="2" /><path d="m4 7 8 6 8-6" />',
            'location' => '<path d="M12 21s7-6.4 7-11.5A7 7 0 0 0 5 9.5C5 14.6 12 21 12 21Z" /><circle cx="12" cy="9.5" r="2.5" />',
            'phone' => '<path d="M6.6 10.8a15 15 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.24 9 9 0 0 0 2.8.45 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.3a1 1 0 0 1 1 1 9 9 0 0 0 .45 2.8 1 1 0 0 1-.25 1l-2.2 2.2Z" />',
        ];

        $heroStats = [
            ['value' => '12', 'suffix' => '', 'label' => 'Packages included'],
            ['value' => '3', 'suffix' => '', 'label' => 'Roles built in'],
            ['value' => '8', 'suffix' => '', 'label' => 'Landing page sections'],
        ];
        $trustedByLogos = ['Laravel', 'Livewire', 'Flux UI', 'Pest', 'Tailwind', 'Spatie'];
        $services = [
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
                'description' => 'Every user gets a role automatically. Admins and super admins get a gated back office, with roles and permissions managed at runtime.',
                'tags' => ['Spatie', 'Roles'],
            ],
            [
                'number' => '03',
                'category' => 'Content',
                'icon' => 'brain',
                'title' => 'Blog CMS',
                'description' => 'A full blog with drafts, featured images, and slugs — publish updates without a redeploy.',
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
        ];
        $lastService = count($services) - 1;
        $infrastructureRegions = [
            ['name' => 'Backend', 'cities' => 'Laravel 13 · Fortify · Spatie Permission'],
            ['name' => 'Frontend', 'cities' => 'Livewire 4 · Flux UI · Tailwind v4'],
            ['name' => 'Quality', 'cities' => 'Pest 4 · Pint · Larastan'],
        ];
        $impactStats = [
            ['value' => '90', 'suffix' => '%', 'label' => 'Less boilerplate', 'sublabel' => 'per new project'],
            ['value' => '3', 'suffix' => '', 'label' => 'Roles ready', 'sublabel' => 'super-admin, admin & staff'],
            ['value' => '102', 'suffix' => '', 'label' => 'Tests passing', 'sublabel' => 'on every push'],
            ['value' => '1', 'suffix' => ' day', 'label' => 'To first deploy', 'sublabel' => 'from clone to live'],
        ];
        $caseStudies = [
            [
                'category' => 'Internal tool',
                'year' => '2026',
                'title' => 'Spin up an admin-gated back office in an afternoon.',
                'description' => 'Roles, a blog, and an authenticated dashboard are already wired together — customize the parts that make this project unique.',
                'metrics' => [
                    ['value' => '1', 'label' => 'Afternoon'],
                    ['value' => '0', 'label' => 'Boilerplate'],
                ],
            ],
            [
                'category' => 'Client site',
                'year' => '2026',
                'title' => 'Give your client a blog they can run themselves.',
                'description' => 'Every post — title, images, publish state — is managed from the dashboard by any signed-in team member, so content updates never need a developer.',
                'metrics' => [
                    ['value' => '1', 'label' => 'Blog, ready to go'],
                    ['value' => '0', 'label' => 'Redeploys needed'],
                ],
            ],
        ];
        $processStats = [
            ['value' => '4', 'label' => 'Steps'],
            ['value' => '1', 'label' => 'Codebase'],
        ];
        $processSteps = [
            ['number' => '01', 'title' => 'Clone & configure', 'description' => 'Set the app name, environment, and database for the new project.', 'duration' => '~10 min'],
            ['number' => '02', 'title' => 'Set the essentials', 'description' => 'Log in as admin and configure SEO details, social links, and contact info.', 'duration' => '~15 min'],
            ['number' => '03', 'title' => 'Build what is unique', 'description' => 'Add the features that make this client project different from the last one.', 'duration' => 'Varies'],
            ['number' => '04', 'title' => 'Ship it', 'description' => 'Deploy with the same auth, roles, and tests already in place.', 'duration' => '~1 day'],
        ];
        $contactAddress = \App\Models\Setting::get('contact_address');
        $contactEmail = \App\Models\Setting::get('contact_email');
        $contactPhone = \App\Models\Setting::get('contact_phone');
    @endphp

    {{-- Hero --}}
    <section id="hero" class="relative h-screen overflow-hidden bg-brand-navy">
        <div class="landing-grid-bg-dark absolute inset-0 opacity-50"></div>

        <div class="landing-animate-float absolute -top-24 -left-24 size-72 rounded-full bg-brand-accent/20 blur-3xl"></div>
        <div class="landing-animate-float-slow absolute right-0 -bottom-24 size-72 rounded-full bg-brand-accent/10 blur-3xl"></div>

        <div class="relative mx-auto grid h-full max-w-7xl grid-cols-1 content-center items-center gap-16 px-6 lg:grid-cols-2">
            <div>
                <div class="landing-reveal inline-flex items-center gap-2 rounded-full border border-brand-snow/10 bg-brand-snow/5 px-4 py-1.5 font-mono text-xs text-brand-snow backdrop-blur-sm">
                    <span>Built on Laravel &amp; Livewire</span>
                    <span class="text-brand-snow/30">/</span>
                    <span class="text-brand-accent">Ready for your next client project</span>
                </div>

                <h1 class="landing-reveal landing-reveal-delay-1 mt-6 font-display text-5xl leading-[1.05] font-semibold tracking-tight text-brand-snow sm:text-6xl">
                    Ship your next<br>
                    <span class="text-brand-accent underline decoration-brand-accent/40 decoration-8 underline-offset-4">client project</span><br>
                    in days, not weeks.
                </h1>

                <p class="landing-reveal landing-reveal-delay-2 mt-6 max-w-xl text-lg text-brand-silver/80">
                    A reusable Laravel starter kit with authentication, roles, and a blog ready to publish — so every new project starts from a working foundation, not a blank repo.
                </p>

                <div class="landing-reveal landing-reveal-delay-3 mt-10 flex flex-wrap items-center gap-4">
                    <a href="{{ route('login') }}" wire:navigate class="inline-flex items-center gap-2 rounded-full bg-brand-accent px-6 py-3 text-sm font-medium text-brand-navy transition hover:bg-brand-accent-dark">
                        Get started
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! $icons['arrow-right'] !!}</svg>
                    </a>
                    <a href="{{ route('home') }}#services" class="inline-flex items-center gap-2 rounded-full border border-brand-snow/20 px-6 py-3 text-sm font-medium text-brand-snow transition hover:bg-brand-snow/10">
                        Explore features
                    </a>
                </div>

                <div class="landing-reveal landing-reveal-delay-4 mt-16 flex flex-wrap gap-10">
                    @foreach ($heroStats as $stat)
                        <div>
                            <div class="font-display text-4xl font-semibold text-brand-snow">
                                @if (is_numeric($stat['value']))
                                    <span class="landing-counter" data-target="{{ $stat['value'] }}" data-decimals="0">0</span>{{ $stat['suffix'] }}
                                @else
                                    {{ $stat['value'] }}{{ $stat['suffix'] }}
                                @endif
                            </div>
                            <div class="mt-1 font-mono text-xs tracking-wide text-brand-silver/60 uppercase">
                                {{ $stat['label'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="relative hidden h-[28rem] items-center justify-center lg:flex">
                <div class="landing-animate-spin-slow absolute size-96 rounded-full border border-brand-accent/15">
                    <div class="absolute top-0 left-1/2 size-3 -translate-x-1/2 -translate-y-1/2 rounded-full bg-brand-accent shadow-[0_0_60px_rgba(77,163,255,0.4)]"></div>
                </div>
                <div class="landing-animate-spin-reverse absolute size-72 rounded-full border border-brand-snow/10">
                    <div class="absolute top-0 left-1/2 size-2.5 -translate-x-1/2 -translate-y-1/2 rounded-full bg-brand-snow"></div>
                    <div class="absolute bottom-0 left-1/2 size-2 -translate-x-1/2 translate-y-1/2 rounded-full bg-brand-accent/60"></div>
                </div>
                <div class="absolute size-48 rounded-full bg-brand-accent/10"></div>

                <div class="relative flex size-28 items-center justify-center rounded-3xl border border-brand-snow/10 bg-brand-navy-light shadow-2xl backdrop-blur-sm">
                    <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-brand-accent/20 to-transparent"></div>
                    <svg class="relative size-9 text-brand-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! $icons['check'] !!}</svg>
                </div>

                <div class="landing-animate-float absolute -top-4 left-4 flex items-center gap-3 rounded-2xl bg-brand-snow p-4 shadow-xl">
                    <span class="flex size-8 items-center justify-center rounded-full bg-brand-accent/10 text-brand-accent-dark">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! $icons['check'] !!}</svg>
                    </span>
                    <span class="font-mono text-xs font-medium text-brand-navy">All systems go</span>
                </div>

                <div class="landing-animate-float-slow absolute right-0 bottom-8 flex items-center gap-3 rounded-2xl bg-brand-snow p-4 shadow-xl">
                    <span class="flex size-8 items-center justify-center rounded-full bg-brand-navy/10 text-brand-navy">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! $icons['cloud'] !!}</svg>
                    </span>
                    <span class="font-mono text-xs font-medium text-brand-navy">No page reloads</span>
                </div>

                <div class="landing-animate-float absolute top-1/2 -right-2 flex -translate-y-1/2 items-center gap-2 rounded-xl bg-brand-snow p-3 shadow-lg" style="animation-delay: 2s;">
                    <span class="relative flex size-2">
                        <span class="landing-animate-pulse-soft absolute inline-flex size-full rounded-full bg-green-400"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-green-500"></span>
                    </span>
                    <span class="font-mono text-xs font-medium text-brand-navy">Tests passing</span>
                </div>

                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 font-mono text-[10px] tracking-wider text-brand-silver/40">
                    MIT LICENSED &middot; OPEN SOURCE
                </div>
            </div>
        </div>
    </section>

    {{-- Trusted by --}}
    <section class="border-y border-brand-navy/10 bg-brand-snow py-14">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="landing-reveal mb-10 flex items-center justify-center gap-4">
                <span class="h-px flex-1 max-w-24 bg-brand-navy/15"></span>
                <p class="whitespace-nowrap font-mono text-xs font-medium uppercase tracking-[0.25em] text-brand-navy/50">
                    Built with tools you already trust
                </p>
                <span class="h-px flex-1 max-w-24 bg-brand-navy/15"></span>
            </div>

            <div class="landing-marquee-mask landing-reveal landing-reveal-delay-1 overflow-hidden">
                <div class="landing-animate-scroll-x flex w-max items-center gap-16">
                    @foreach ($trustedByLogos as $name)
                        <span class="shrink-0 font-display text-2xl font-bold tracking-tight text-brand-navy/30 transition hover:text-brand-navy/60">
                            {{ $name }}
                        </span>
                    @endforeach
                    @foreach ($trustedByLogos as $name)
                        <span aria-hidden="true" class="shrink-0 font-display text-2xl font-bold tracking-tight text-brand-navy/30 transition hover:text-brand-navy/60">
                            {{ $name }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Services --}}
    <section id="services" class="scroll-mt-24 bg-brand-snow">
        <div class="mx-auto max-w-7xl px-6 py-24">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="landing-reveal lg:w-3/5">
                    <div class="flex items-center gap-3">
                        <span class="h-px w-8 bg-brand-accent"></span>
                        <span class="font-mono text-xs uppercase tracking-widest text-brand-accent">
                            01 &mdash; Capabilities
                        </span>
                    </div>
                    <h2 class="mt-4 font-display text-4xl font-semibold tracking-tight text-brand-navy sm:text-5xl">
                        Everything a client project starts with
                    </h2>
                </div>
                <div class="landing-reveal landing-reveal-delay-1 lg:w-2/5">
                    <p class="text-base text-brand-navy/70">
                        Foundational features every new project needs, already wired together so you can focus on what makes each client different.
                    </p>
                </div>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $item)
                    @php
                        $delay = ($loop->index % 4) + 1;
                        $isLastService = $loop->index === $lastService;
                    @endphp

                    @if ($isLastService)
                        <a
                            href="#contact"
                            class="landing-card-hover landing-reveal landing-reveal-delay-{{ $delay }} group flex flex-col justify-between rounded-2xl bg-brand-navy p-8"
                        >
                            <div>
                                <div class="flex size-11 items-center justify-center rounded-xl bg-brand-snow/10">
                                    <svg class="size-5 text-brand-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! $icons[$item['icon']] !!}</svg>
                                </div>
                                <p class="mt-6 font-mono text-xs uppercase tracking-widest text-brand-silver">
                                    {{ $item['number'] }} &mdash; {{ $item['category'] }}
                                </p>
                                <h3 class="mt-2 font-display text-xl font-semibold text-brand-snow">
                                    {{ $item['title'] }}
                                </h3>
                                <p class="mt-3 text-sm text-brand-silver">
                                    {{ $item['description'] }}
                                </p>
                            </div>
                            <span class="mt-8 inline-flex items-center gap-2 text-sm font-medium text-brand-accent">
                                Get in touch
                                <svg class="size-4 transition group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! $icons['arrow-right'] !!}</svg>
                            </span>
                        </a>
                    @else
                        <div
                            class="landing-card-hover landing-reveal landing-reveal-delay-{{ $delay }} flex flex-col rounded-2xl border border-brand-navy/10 bg-white p-8"
                        >
                            <div class="flex size-11 items-center justify-center rounded-xl bg-brand-navy">
                                <svg class="size-5 text-brand-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! $icons[$item['icon']] !!}</svg>
                            </div>
                            <p class="mt-6 font-mono text-xs uppercase tracking-widest text-brand-navy/50">
                                {{ $item['number'] }} &mdash; {{ $item['category'] }}
                            </p>
                            <h3 class="mt-2 font-display text-xl font-semibold text-brand-navy">
                                {{ $item['title'] }}
                            </h3>
                            <p class="mt-3 text-sm text-brand-navy/70">
                                {{ $item['description'] }}
                            </p>

                            <div class="mt-6 flex flex-wrap gap-2">
                                @foreach ($item['tags'] as $tag)
                                    <span class="rounded bg-brand-navy/5 px-2 py-1 text-xs text-brand-navy">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    {{-- Infrastructure --}}
    <section id="infrastructure" class="relative scroll-mt-24 overflow-hidden bg-brand-navy text-brand-snow">
        <div class="landing-grid-bg-dark absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-6 py-24 lg:px-8">
            <div class="grid gap-16 lg:grid-cols-12 lg:items-center lg:gap-8">
                <div class="landing-reveal lg:col-span-5">
                    <p class="font-mono text-sm uppercase tracking-widest text-brand-accent">
                        Foundation
                    </p>
                    <h2 class="mt-4 font-display text-4xl font-bold text-brand-snow sm:text-5xl">
                        One codebase.
                        <span class="block font-light text-brand-accent italic">Every client project.</span>
                    </h2>
                    <p class="mt-6 text-lg text-brand-silver">
                        Clone this starter kit for each new engagement and keep the same reliable core: auth, roles, and a blog ready to publish.
                    </p>

                    <div class="mt-10">
                        @foreach ($infrastructureRegions as $region)
                            <div class="flex items-center justify-between border-b border-brand-snow/10 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="landing-animate-pulse-soft size-2 rounded-full bg-brand-accent"></span>
                                    <span class="font-mono text-sm uppercase tracking-wide text-brand-snow">{{ $region['name'] }}</span>
                                </div>
                                <span class="text-sm text-brand-silver">{{ $region['cities'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="landing-reveal landing-reveal-delay-2 lg:col-span-7">
                    <div class="relative overflow-hidden rounded-3xl border border-brand-snow/10 bg-brand-navy-light/30 p-8 sm:p-10">
                        <div class="landing-dot-pattern pointer-events-none absolute inset-0 opacity-40"></div>

                        <div class="relative flex items-center gap-2">
                            <span class="landing-animate-pulse-soft size-2 rounded-full bg-green-400"></span>
                            <span class="font-mono text-xs uppercase tracking-widest text-brand-silver">
                                Test Suite &middot; All checks passing
                            </span>
                        </div>

                        <div class="relative mt-24 grid grid-cols-2 gap-8 sm:mt-40">
                            <div>
                                <p class="font-display text-4xl font-bold text-brand-snow sm:text-5xl">
                                    102
                                </p>
                                <p class="mt-2 font-mono text-xs uppercase tracking-widest text-brand-silver">Tests Passing</p>
                            </div>
                            <div>
                                <p class="font-display text-4xl font-bold text-brand-snow sm:text-5xl">
                                    3
                                </p>
                                <p class="mt-2 font-mono text-xs uppercase tracking-widest text-brand-silver">Roles Built In</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="relative overflow-hidden bg-brand-snow py-24">
        <div class="landing-dot-pattern absolute inset-0 opacity-50"></div>

        <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
            <div class="landing-reveal mb-16 grid gap-8 lg:grid-cols-12">
                <div class="lg:col-span-6">
                    <div class="flex items-center gap-3">
                        <span class="h-px w-8 bg-brand-accent"></span>
                        <span class="font-mono text-xs uppercase tracking-widest text-brand-accent">
                            Impact
                        </span>
                    </div>
                    <h2 class="mt-4 font-display text-4xl font-bold tracking-tight text-brand-navy sm:text-5xl">
                        Less setup.
                        <br>
                        <span class="italic font-light text-brand-navy/50">More building.</span>
                    </h2>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 lg:grid-cols-4 lg:gap-8">
                @foreach ($impactStats as $item)
                    @php
                        $value = (string) $item['value'];
                        $decimals = str_contains($value, '.') ? strlen(substr(strrchr($value, '.'), 1)) : 0;
                    @endphp
                    <div @class([
                        'landing-reveal',
                        'landing-reveal-delay-1' => $loop->iteration === 2,
                        'landing-reveal-delay-2' => $loop->iteration === 3,
                        'landing-reveal-delay-3' => $loop->iteration === 4,
                    ])>
                        <div class="font-display text-5xl font-bold tracking-tight text-brand-navy lg:text-7xl">
                            <span class="landing-counter" data-target="{{ $value }}" data-decimals="{{ $decimals }}">0</span><span class="text-brand-accent-dark">{{ $item['suffix'] }}</span>
                        </div>
                        <div class="mt-4 border-t border-brand-navy/10 pt-4">
                            <p class="font-medium text-brand-navy">{{ $item['label'] }}</p>
                            <p class="mt-1 text-sm text-brand-navy/50">{{ $item['sublabel'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Case studies --}}
    <section id="solutions" class="scroll-mt-24 bg-brand-snow py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="landing-reveal max-w-2xl">
                <p class="font-mono text-sm uppercase tracking-widest text-brand-accent-dark">
                    Solutions
                </p>
                <h2 class="mt-4 font-display text-4xl font-bold tracking-tight text-brand-navy sm:text-5xl">
                    Built for how client work actually happens
                </h2>
            </div>

            <div class="mt-16 grid gap-8 lg:grid-cols-2">
                @foreach ($caseStudies as $item)
                    @if ($loop->first)
                        <div class="landing-reveal landing-reveal-delay-1 rounded-3xl bg-brand-navy p-10 sm:p-12">
                            <div class="flex items-center justify-between">
                                <span class="font-mono text-xs uppercase tracking-widest text-brand-accent">
                                    {{ $item['category'] }}
                                </span>
                                <span class="font-mono text-xs text-brand-snow/60">
                                    {{ $item['year'] }}
                                </span>
                            </div>
                            <h3 class="mt-6 font-display text-3xl font-bold text-brand-snow sm:text-4xl">
                                {{ $item['title'] }}
                            </h3>
                            <p class="mt-4 text-lg leading-relaxed text-brand-snow/80">
                                {{ $item['description'] }}
                            </p>

                            <div class="mt-10 grid grid-cols-2 gap-6 border-t border-white/10 pt-8 sm:grid-cols-3">
                                @foreach ($item['metrics'] as $metric)
                                    <div>
                                        <p class="font-display text-3xl font-bold text-brand-accent">
                                            {{ $metric['value'] }}
                                        </p>
                                        <p class="mt-1 text-xs text-brand-snow/60">
                                            {{ $metric['label'] }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="landing-reveal landing-card-hover landing-reveal-delay-{{ min($loop->index + 1, 4) }} rounded-3xl border border-brand-navy/10 bg-brand-snow p-10 sm:p-12">
                            <div class="flex items-center justify-between">
                                <span class="font-mono text-xs uppercase tracking-widest text-brand-accent-dark">
                                    {{ $item['category'] }}
                                </span>
                                <span class="font-mono text-xs text-brand-navy/50">
                                    {{ $item['year'] }}
                                </span>
                            </div>
                            <h3 class="mt-6 font-display text-2xl font-bold text-brand-navy">
                                {{ $item['title'] }}
                            </h3>
                            <p class="mt-4 leading-relaxed text-brand-navy/70">
                                {{ $item['description'] }}
                            </p>

                            <div class="mt-10 grid grid-cols-2 gap-6 border-t border-brand-navy/10 pt-8 sm:grid-cols-3">
                                @foreach ($item['metrics'] as $metric)
                                    <div>
                                        <p class="font-display text-3xl font-bold text-brand-accent-dark">
                                            {{ $metric['value'] }}
                                        </p>
                                        <p class="mt-1 text-xs text-brand-navy/50">
                                            {{ $metric['label'] }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    {{-- Process --}}
    <section id="about" class="scroll-mt-24 bg-brand-snow py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-8">
                <div class="landing-reveal lg:col-span-5">
                    <span class="font-mono text-sm uppercase tracking-widest text-brand-accent">
                        How it works
                    </span>
                    <h2 class="mt-4 font-display text-3xl font-bold tracking-tight text-brand-navy sm:text-4xl">
                        From clone to client-ready
                    </h2>
                    <p class="mt-4 text-base text-brand-navy/70">
                        A predictable path from starter kit to a project you can hand off.
                    </p>

                    <div class="mt-10 flex flex-wrap gap-8">
                        @foreach ($processStats as $stat)
                            <div class="{{ $loop->first ? '' : 'border-l border-brand-navy/10 pl-8' }}">
                                <div class="font-display text-2xl font-bold text-brand-navy">
                                    {{ $stat['value'] }}
                                </div>
                                <div class="mt-1 text-sm text-brand-navy/60">
                                    {{ $stat['label'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="landing-reveal landing-reveal-delay-2 lg:col-span-7">
                    <div class="divide-y divide-brand-navy/10 border-t border-brand-navy/10">
                        @foreach ($processSteps as $step)
                            <div class="grid grid-cols-12 items-start gap-4 rounded-lg px-4 py-6 -mx-4 transition hover:bg-brand-navy/[0.03]">
                                <div class="col-span-2 font-mono text-sm text-brand-accent sm:col-span-1">
                                    {{ $step['number'] }}
                                </div>
                                <div class="col-span-10 sm:col-span-8">
                                    <h3 class="font-display text-lg font-bold text-brand-navy">
                                        {{ $step['title'] }}
                                    </h3>
                                    <p class="mt-1 text-sm text-brand-navy/60">
                                        {{ $step['description'] }}
                                    </p>
                                </div>
                                <div class="col-span-12 text-right font-mono text-xs text-brand-navy/40 sm:col-span-3">
                                    {{ $step['duration'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section id="contact" class="scroll-mt-24 bg-brand-snow py-24">
        <div class="landing-reveal relative mx-auto max-w-6xl overflow-hidden rounded-3xl bg-brand-navy px-6 py-16 sm:px-12 lg:px-16">
            <div class="landing-grid-bg-dark absolute inset-0"></div>

            <div class="landing-animate-float absolute -top-24 -left-24 size-72 rounded-full bg-brand-accent/20 blur-3xl"></div>
            <div class="landing-animate-float-slow absolute -bottom-24 -right-24 size-72 rounded-full bg-brand-accent/20 blur-3xl"></div>

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
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! $icons['arrow-right'] !!}</svg>
                        </a>
                        <a href="mailto:{{ $contactEmail }}" class="inline-flex items-center gap-2 rounded-full border border-brand-snow/20 px-6 py-3 text-sm font-medium text-brand-snow transition hover:bg-brand-snow/10">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! $icons['mail'] !!}</svg>
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
                                    <svg class="size-5 text-brand-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! $icons['location'] !!}</svg>
                                </span>
                                <div>
                                    <p class="text-sm text-brand-snow/60">HQ</p>
                                    <p class="mt-1 font-medium text-brand-snow">{{ $contactAddress }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-accent/10">
                                    <svg class="size-5 text-brand-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! $icons['mail'] !!}</svg>
                                </span>
                                <div>
                                    <p class="text-sm text-brand-snow/60">Email</p>
                                    <p class="mt-1 font-medium text-brand-snow">{{ $contactEmail }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-accent/10">
                                    <svg class="size-5 text-brand-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! $icons['phone'] !!}</svg>
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
