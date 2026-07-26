<nav
    x-data="{ open: false, scrolled: false }"
    x-on:scroll.window="scrolled = window.scrollY > 20"
    :class="scrolled ? 'shadow-sm bg-brand-snow/95' : 'bg-brand-snow/80'"
    class="fixed inset-x-0 top-0 z-50 backdrop-blur transition-colors"
>
    <div class="mx-auto max-w-7xl px-6">
        <div class="flex h-16 items-center justify-between lg:h-20">
            <a href="/" class="flex items-center gap-3">
                <span class="relative flex size-10 shrink-0 items-center justify-center rounded-xl bg-brand-navy">
                    <svg viewBox="0 0 24 24" class="size-5 text-brand-accent" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 4v16M4 12h16" />
                        <circle cx="12" cy="12" r="2" fill="currentColor" stroke="none" />
                    </svg>
                </span>
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
                @foreach ([
                    ['label' => 'Services', 'url' => '#services'],
                    ['label' => 'Infrastructure', 'url' => '#infrastructure'],
                    ['label' => 'Solutions', 'url' => '#solutions'],
                    ['label' => 'About', 'url' => '#about'],
                    ['label' => 'Blog', 'url' => '/blog'],
                    ['label' => 'Contact', 'url' => '#contact'],
                ] as $item)
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
                    href="#contact"
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
                    <x-landing.icon x-show="!open" name="menu" class="size-5" />
                    <x-landing.icon x-show="open" x-cloak name="close" class="size-5" />
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" x-collapse x-cloak class="border-t border-brand-navy/10 lg:hidden">
        <div class="mx-auto flex max-w-7xl flex-col gap-1 px-6 py-4">
            @foreach ([
                ['label' => 'Services', 'url' => '#services'],
                ['label' => 'Infrastructure', 'url' => '#infrastructure'],
                ['label' => 'Solutions', 'url' => '#solutions'],
                ['label' => 'About', 'url' => '#about'],
                ['label' => 'Blog', 'url' => '/blog'],
                ['label' => 'Contact', 'url' => '#contact'],
            ] as $item)
                <a
                    href="{{ $item['url'] }}"
                    x-on:click="open = false"
                    class="rounded-lg px-3 py-2 text-sm font-medium text-brand-navy/70 transition hover:bg-brand-navy/5 hover:text-brand-navy"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
            <a
                href="#contact"
                class="mt-2 inline-flex items-center justify-center gap-2 rounded-full bg-brand-navy px-5 py-2.5 text-sm font-medium text-brand-snow transition hover:bg-brand-navy-light"
            >
                Get started
            </a>
        </div>
    </div>
</nav>
