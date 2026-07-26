<?php $socialLinks = collect([
    'linkedin' => \App\Models\Setting::get('social_linkedin'),
    'twitter' => \App\Models\Setting::get('social_twitter'),
    'github' => \App\Models\Setting::get('social_github'),
    'instagram' => \App\Models\Setting::get('social_instagram'),
])->filter(); ?>
<footer class="landing-grid-bg-dark relative overflow-hidden bg-brand-navy text-brand-snow">
    <div class="relative mx-auto max-w-7xl px-6 py-20">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-12">
            <div class="landing-reveal lg:col-span-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="size-9 rounded-lg ring-1 ring-brand-snow/10">
                    <span class="font-display text-lg font-semibold text-brand-snow">{{ config('app.name') }}</span>
                </a>
                <p class="mt-5 max-w-sm text-sm text-brand-silver/80">
                    A reusable Laravel starter kit for internal and client projects — authentication, roles, a blog, and a back office, ready to go.
                </p>
                @if ($socialLinks->isNotEmpty())
                    <div class="mt-6 flex items-center gap-3">
                        @foreach ($socialLinks as $platform => $url)
                            <a
                                href="{{ $url }}"
                                target="_blank"
                                rel="noopener"
                                class="flex size-9 items-center justify-center rounded-lg border border-brand-snow/15 text-brand-silver transition hover:border-brand-accent/40 hover:text-brand-accent"
                            >
                                <x-landing.icon :name="$platform" class="size-4" />
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            @foreach ([
                [
                    'heading' => 'Product',
                    'links' => [
                        ['label' => 'Services', 'url' => route('home').'#services'],
                        ['label' => 'Infrastructure', 'url' => route('home').'#infrastructure'],
                        ['label' => 'Solutions', 'url' => route('home').'#solutions'],
                        ['label' => 'Blog', 'url' => route('blogs')],
                    ],
                ],
                [
                    'heading' => 'Company',
                    'links' => [
                        ['label' => 'About', 'url' => route('home').'#about'],
                        ['label' => 'Contact', 'url' => route('home').'#contact'],
                    ],
                ],
                [
                    'heading' => 'Account',
                    'links' => [
                        ['label' => 'Log in', 'url' => route('login')],
                        ['label' => 'Register', 'url' => route('register')],
                    ],
                ],
            ] as $column)
                <div class="landing-reveal landing-reveal-delay-{{ min($loop->iteration, 4) }} lg:col-span-2">
                    <p class="font-mono text-xs font-medium uppercase tracking-widest text-brand-silver/60">
                        {{ $column['heading'] }}
                    </p>
                    <ul class="mt-5 space-y-3">
                        @foreach ($column['links'] as $link)
                            <li>
                                <a href="{{ $link['url'] }}" class="text-sm text-brand-silver/80 transition hover:text-brand-snow">
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <div class="mt-16 flex flex-col gap-6 border-t border-brand-snow/10 pt-8 lg:flex-row lg:items-center lg:justify-between">
            <p class="text-sm text-brand-silver/60">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
            <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
                <a href="#" class="text-sm text-brand-silver/60 transition hover:text-brand-snow">Privacy Policy</a>
                <a href="#" class="text-sm text-brand-silver/60 transition hover:text-brand-snow">Terms</a>
                <span class="flex items-center gap-2 text-sm text-brand-silver/60">
                    <span class="landing-animate-pulse-soft size-2 rounded-full bg-emerald-400"></span>
                    All systems operational
                </span>
            </div>
        </div>
    </div>
</footer>
