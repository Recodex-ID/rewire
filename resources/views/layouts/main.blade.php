@props([
    'title' => null,
    'seoDescription' => null,
    'analyticsId' => null,
    'metaImage' => null,
    'metaType' => 'website',
    'publishedAt' => null,
])

@php
    // Analytics and its consent banner apply to every public page, so read the setting here
    // instead of relying on each page to pass it in.
    $analyticsId = filled($analyticsId) ? $analyticsId : \App\Models\Setting::get('analytics_id');

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

    $footerSocialLabels = [
        'linkedin' => 'LinkedIn',
        'twitter' => 'X (Twitter)',
        'github' => 'GitHub',
        'instagram' => 'Instagram',
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
        @include('partials.head', [
            'metaDescription' => $seoDescription,
            'metaImage' => $metaImage,
            'metaType' => $metaType,
            'publishedAt' => $publishedAt,
        ])

        {{-- Without JavaScript the scroll-reveal never fires, so show everything. --}}
        <noscript>
            <style>
                .landing-reveal { opacity: 1; transform: none; }
            </style>
        </noscript>
    </head>
    <body class="min-h-screen bg-brand-snow">
        {{-- Navbar --}}
        <nav
            x-data="{ open: false, scrolled: false }"
            x-on:scroll.window="scrolled = window.scrollY > 20"
            :class="scrolled ? 'shadow-sm bg-brand-snow/95' : 'bg-brand-snow/80'"
            class="fixed inset-x-0 top-0 z-50 backdrop-blur transition-colors"
            aria-label="Main"
        >
            <div class="mx-auto max-w-7xl px-6">
                <div class="flex h-16 items-center justify-between lg:h-20">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="" width="40" height="40" class="size-10 shrink-0 rounded-xl border border-brand-navy bg-brand-snow p-1.5">
                        <span class="flex flex-col leading-none">
                            <span class="font-display text-lg font-bold text-brand-navy">
                                Rewire
                            </span>
                            <span class="font-mono text-[10px] font-medium uppercase tracking-widest text-brand-navy/70">
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
                            Sign in
                        </a>

                        <button
                            type="button"
                            x-on:click="open = !open"
                            x-bind:aria-expanded="open.toString()"
                            aria-controls="mobile-menu"
                            class="inline-flex size-11 items-center justify-center rounded-full text-brand-navy hover:bg-brand-navy/5 lg:hidden"
                            aria-label="Toggle menu"
                        >
                            <x-heroicon-o-bars-3 x-show="!open" class="size-5" />
                            <x-heroicon-o-x-mark x-show="open" x-cloak class="size-5" />
                        </button>
                    </div>
                </div>
            </div>

            <div id="mobile-menu" x-show="open" x-collapse x-cloak class="border-t border-brand-navy/10 lg:hidden">
                <div class="mx-auto flex max-w-7xl flex-col gap-1 px-6 py-4">
                    @foreach ($navLinks as $item)
                        <a
                            href="{{ $item['url'] }}"
                            x-on:click="open = false"
                            class="rounded-lg px-3 py-3 text-sm font-medium text-brand-navy/70 transition hover:bg-brand-navy/5 hover:text-brand-navy"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                    <a
                        href="{{ route('login') }}"
                        wire:navigate
                        class="mt-2 inline-flex items-center justify-center gap-2 rounded-full bg-brand-navy px-5 py-3 text-sm font-medium text-brand-snow transition hover:bg-brand-navy-light"
                    >
                        Sign in
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
                            <img src="{{ asset('images/logo.png') }}" alt="" width="36" height="36" loading="lazy" class="size-9 rounded-lg border border-brand-navy bg-brand-snow p-1.5">
                            <span class="font-display text-lg font-semibold text-brand-snow">Rewire Starter Kit</span>
                        </a>
                        <p class="mt-5 max-w-sm text-sm text-brand-silver/80">
                            A reusable Laravel starter kit for internal and client projects: authentication, roles, a blog, and a back office, ready to go.
                        </p>
                        @if ($footerSocialLinks->isNotEmpty())
                            <div class="mt-6 flex items-center gap-3">
                                @foreach ($footerSocialLinks as $platform => $url)
                                    <a
                                        href="{{ $url }}"
                                        target="_blank"
                                        rel="noopener"
                                        aria-label="{{ $footerSocialLabels[$platform] }} (opens in a new tab)"
                                        class="flex size-11 items-center justify-center rounded-lg border border-brand-snow/15 text-brand-silver transition hover:border-brand-accent/40 hover:text-brand-accent"
                                    >
                                        @if ($platform === 'linkedin')
                                            {{-- No maintained Blade icon package ships a LinkedIn mark (Simple Icons dropped it over trademark concerns) --}}
                                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <rect x="3" y="3" width="18" height="18" rx="3" /><circle cx="8" cy="8.5" r="1" fill="currentColor" stroke="none" /><path d="M8 11v6M12 17v-3.5a1.8 1.8 0 0 1 3.6 0V17M12 11v1.2" />
                                            </svg>
                                        @else
                                            <x-dynamic-component :component="$footerSocialComponents[$platform]" class="size-4" aria-hidden="true" />
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @foreach ($footerColumns as $column)
                        <div class="landing-reveal landing-reveal-delay-{{ min($loop->iteration, 4) }} lg:col-span-2">
                            <p class="font-mono text-xs font-medium uppercase tracking-widest text-brand-silver/80">
                                {{ $column['heading'] }}
                            </p>
                            <ul class="mt-4 space-y-1">
                                @foreach ($column['links'] as $link)
                                    <li>
                                        <a href="{{ $link['url'] }}" class="inline-block py-1.5 text-sm text-brand-silver/80 transition hover:text-brand-snow">
                                            {{ $link['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>

                <div class="mt-16 flex flex-col gap-6 border-t border-brand-snow/10 pt-8 lg:flex-row lg:items-start lg:justify-between">
                    <div class="space-y-1.5 text-sm text-brand-silver/80">
                        <p>&copy; {{ date('Y') }} Rewire Starter Kit. All rights reserved.</p>
                        <p>
                            Built by
                            <a
                                href="https://recodex.id"
                                target="_blank"
                                rel="noopener"
                                class="font-medium text-[#CFF008] underline-offset-4 hover:underline focus-visible:underline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#CFF008]"
                            >Recodex ID<span class="sr-only"> (opens in a new tab)</span></a>
                            &middot; PT Reka Mitra Teknologi
                        </p>
                    </div>

                    <nav aria-label="Legal" class="flex flex-wrap items-center gap-x-6 gap-y-1 text-sm">
                        <a href="{{ route('privacy') }}" class="inline-block py-1.5 text-brand-silver/80 transition hover:text-brand-snow">Privacy Policy</a>
                        <a href="{{ route('terms') }}" class="inline-block py-1.5 text-brand-silver/80 transition hover:text-brand-snow">Terms of Service</a>
                        @if (filled($analyticsId))
                            <button
                                type="button"
                                onclick="window.dispatchEvent(new CustomEvent('open-cookie-settings'))"
                                class="inline-block py-1.5 text-brand-silver/80 transition hover:text-brand-snow"
                            >Cookie settings</button>
                        @endif
                    </nav>
                </div>
            </div>
        </footer>

        {{-- Cookie consent: only rendered when analytics is configured, since that is the only non-essential cookie source. --}}
        @if (filled($analyticsId))
            <div
                x-data="cookieConsent(@js($analyticsId))"
                x-on:open-cookie-settings.window="reopen()"
                x-show="open"
                x-cloak
                role="region"
                aria-labelledby="cookie-consent-title"
                class="fixed inset-x-0 bottom-0 z-[60] p-4 sm:p-6"
            >
                <div class="mx-auto flex max-w-3xl flex-col gap-5 rounded-2xl border border-brand-navy/15 bg-white p-5 shadow-lg sm:flex-row sm:items-center sm:p-6">
                    <div class="flex-1">
                        <h2 id="cookie-consent-title" class="font-display text-base font-semibold text-brand-navy">Analytics cookies</h2>
                        <p class="mt-1 text-sm leading-relaxed text-brand-navy/70">
                            With your permission we load Google Analytics to count visits. Nothing loads until you choose, and you can change your mind from the footer.
                            Details are in the <a href="{{ route('privacy') }}" class="font-medium text-brand-accent-dark underline underline-offset-2 hover:text-brand-navy">Privacy Policy</a>.
                        </p>
                    </div>
                    <div class="flex flex-col gap-2 sm:shrink-0 sm:flex-row">
                        <button
                            type="button"
                            x-ref="decline"
                            x-on:click="decline()"
                            class="inline-flex items-center justify-center rounded-full border border-brand-navy/30 px-6 py-3 text-sm font-medium text-brand-navy transition hover:bg-brand-navy/5"
                        >Decline</button>
                        <button
                            type="button"
                            x-on:click="accept()"
                            class="inline-flex items-center justify-center rounded-full bg-brand-navy px-6 py-3 text-sm font-medium text-brand-snow transition hover:bg-brand-navy-light"
                        >Accept analytics</button>
                    </div>
                </div>
            </div>
        @endif

        @fluxScripts
    </body>
</html>
