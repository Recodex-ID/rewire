@props([
    'title' => null,
    'seoDescription' => null,
    'analyticsId' => null,
])

@php
    $navLinks = [
        ['label' => 'Code', 'url' => route('home').'#code'],
        ['label' => 'Features', 'url' => route('home').'#features'],
        ['label' => 'Blog', 'url' => route('blogs')],
        ['label' => 'Contact', 'url' => route('home').'#contact'],
    ];

    $footerSocialLinks = collect([
        'linkedin' => \App\Models\Setting::get('social_linkedin'),
        'twitter' => \App\Models\Setting::get('social_twitter'),
        'github' => \App\Models\Setting::get('social_github'),
        'instagram' => \App\Models\Setting::get('social_instagram'),
    ])->filter();

    $footerSocialComponents = [
        'twitter' => 'si-x',
        'github' => 'si-github',
        'instagram' => 'si-instagram',
    ];

    $footerColumns = [
        [
            'heading' => 'Product',
            'links' => [
                ['label' => 'Code', 'url' => route('home').'#code'],
                ['label' => 'Features', 'url' => route('home').'#features'],
                ['label' => 'Blog', 'url' => route('blogs')],
            ],
        ],
        [
            'heading' => 'Company',
            'links' => [
                ['label' => 'Contact', 'url' => route('home').'#contact'],
                ['label' => 'Repository', 'url' => 'https://github.com/Recodex-ID/rewire'],
            ],
        ],
        [
            'heading' => 'Account',
            'links' => [
                ['label' => 'Log in', 'url' => route('login')],
                ['label' => 'Register', 'url' => route('register')],
            ],
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')

        @if ($seoDescription)
            <meta name="description" content="{{ $seoDescription }}">
            <meta property="og:description" content="{{ $seoDescription }}">
        @endif

        @if ($analyticsId)
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ $analyticsId }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag() { dataLayer.push(arguments); }
                gtag('js', new Date());
                gtag('config', '{{ $analyticsId }}');
            </script>
        @endif
    </head>
    <body class="min-h-screen bg-brand-snow">
        {{-- Navbar --}}
        <nav
            x-data="{ open: false, scrolled: false }"
            x-on:scroll.window="scrolled = window.scrollY > 20"
            :class="scrolled ? 'shadow-sm bg-brand-snow/95' : 'bg-brand-snow/80'"
            class="fixed inset-x-0 top-0 z-50 backdrop-blur transition-colors"
        >
            <div class="mx-auto max-w-7xl px-6">
                <div class="flex h-16 items-center justify-between lg:h-20">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Rewire Starter Kit" class="size-10 shrink-0 rounded-xl border border-brand-navy bg-brand-snow p-1.5">
                        <span class="flex flex-col leading-none">
                            <span class="font-display text-lg font-bold text-brand-navy">
                                Rewire
                            </span>
                            <span class="font-mono text-[10px] font-medium uppercase tracking-widest text-brand-navy/50">
                                Starter Kit
                            </span>
                        </span>
                    </a>

                    <div class="hidden items-center gap-1 lg:flex">
                        @foreach ($navLinks as $item)
                            <a
                                href="{{ $item['url'] }}"
                                class="rounded-full px-4 py-2 text-sm font-medium text-brand-navy/70 transition hover:bg-brand-navy/5 hover:text-brand-navy"
                            >
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-2">
                        <a
                            href="{{ route('login') }}"
                            wire:navigate
                            class="hidden items-center gap-2 rounded-full bg-brand-navy px-5 py-2.5 text-sm font-medium text-brand-snow transition hover:bg-brand-navy-light lg:inline-flex"
                        >
                            Get started
                        </a>

                        <button
                            type="button"
                            x-on:click="open = !open"
                            class="inline-flex size-10 items-center justify-center rounded-full text-brand-navy hover:bg-brand-navy/5 lg:hidden"
                            aria-label="Toggle menu"
                        >
                            <x-heroicon-o-bars-3 x-show="!open" class="size-5" />
                            <x-heroicon-o-x-mark x-show="open" x-cloak class="size-5" />
                        </button>
                    </div>
                </div>
            </div>

            <div x-show="open" x-collapse x-cloak class="border-t border-brand-navy/10 lg:hidden">
                <div class="mx-auto flex max-w-7xl flex-col gap-1 px-6 py-4">
                    @foreach ($navLinks as $item)
                        <a
                            href="{{ $item['url'] }}"
                            x-on:click="open = false"
                            class="rounded-lg px-3 py-2 text-sm font-medium text-brand-navy/70 transition hover:bg-brand-navy/5 hover:text-brand-navy"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                    <a
                        href="{{ route('login') }}"
                        wire:navigate
                        class="mt-2 inline-flex items-center justify-center gap-2 rounded-full bg-brand-navy px-5 py-2.5 text-sm font-medium text-brand-snow transition hover:bg-brand-navy-light"
                    >
                        Get started
                    </a>
                </div>
            </div>
        </nav>

        {{ $slot }}

        {{-- Footer --}}
        <footer class="landing-grid-bg-dark relative overflow-hidden bg-brand-navy text-brand-snow">
            <div class="relative mx-auto max-w-7xl px-6 py-20">
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-12">
                    <div class="landing-reveal lg:col-span-4">
                        <a href="{{ route('home') }}" class="flex items-center gap-3">
                            <img src="{{ asset('images/logo.png') }}" alt="Rewire Starter Kit" class="size-9 rounded-lg border border-brand-navy bg-brand-snow p-1.5">
                            <span class="font-display text-lg font-semibold text-brand-snow">Rewire Starter Kit</span>
                        </a>
                        <p class="mt-5 max-w-sm text-sm text-brand-silver/80">
                            A reusable Laravel starter kit for internal and client projects — authentication, roles, a blog, and a back office, ready to go.
                        </p>
                        @if ($footerSocialLinks->isNotEmpty())
                            <div class="mt-6 flex items-center gap-3">
                                @foreach ($footerSocialLinks as $platform => $url)
                                    <a
                                        href="{{ $url }}"
                                        target="_blank"
                                        rel="noopener"
                                        class="flex size-9 items-center justify-center rounded-lg border border-brand-snow/15 text-brand-silver transition hover:border-brand-accent/40 hover:text-brand-accent"
                                    >
                                        @if ($platform === 'linkedin')
                                            {{-- No maintained Blade icon package ships a LinkedIn mark (Simple Icons dropped it over trademark concerns) --}}
                                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="3" y="3" width="18" height="18" rx="3" /><circle cx="8" cy="8.5" r="1" fill="currentColor" stroke="none" /><path d="M8 11v6M12 17v-3.5a1.8 1.8 0 0 1 3.6 0V17M12 11v1.2" />
                                            </svg>
                                        @else
                                            <x-dynamic-component :component="$footerSocialComponents[$platform]" class="size-4" />
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @foreach ($footerColumns as $column)
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
                        &copy; {{ date('Y') }} Rewire Starter Kit. All rights reserved.
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

        @fluxScripts
    </body>
</html>
