@if ($section?->is_visible)
    <nav
        x-data="{ open: false, scrolled: false, dark: document.documentElement.classList.contains('dark') }"
        x-on:scroll.window="scrolled = window.scrollY > 20"
        :class="scrolled ? 'shadow-sm bg-brand-snow/95 dark:bg-zinc-900/95' : 'bg-brand-snow/80 dark:bg-zinc-900/80'"
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
                        <span class="font-display text-lg font-bold text-brand-navy dark:text-brand-snow">
                            {{ $section->content['logo_text'] ?? '' }}
                        </span>
                        <span class="font-mono text-[10px] font-medium uppercase tracking-widest text-brand-navy/50 dark:text-brand-silver/60">
                            {{ $section->content['logo_subtext'] ?? '' }}
                        </span>
                    </span>
                </a>

                <div class="hidden items-center gap-1 lg:flex">
                    @foreach ($section->content['nav_items'] ?? [] as $item)
                        <a
                            href="{{ $item['url'] ?? '#' }}"
                            class="rounded-full px-4 py-2 text-sm font-medium text-brand-navy/70 transition hover:bg-brand-navy/5 hover:text-brand-navy dark:text-brand-silver dark:hover:bg-brand-snow/10 dark:hover:text-brand-snow"
                        >
                            {{ $item['label'] ?? '' }}
                        </a>
                    @endforeach
                </div>

                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        x-on:click="dark = !dark; document.documentElement.classList.toggle('dark', dark); localStorage.setItem('landing-theme', dark ? 'dark' : 'light')"
                        class="inline-flex size-10 items-center justify-center rounded-full text-brand-navy hover:bg-brand-navy/5 dark:text-brand-snow dark:hover:bg-brand-snow/10"
                        aria-label="Toggle color scheme"
                    >
                        <x-landing.icon x-show="!dark" name="sun" class="size-5" />
                        <x-landing.icon x-show="dark" x-cloak name="moon" class="size-5" />
                    </button>

                    <a
                        href="{{ $section->content['cta_url'] ?? '#' }}"
                        class="hidden items-center gap-2 rounded-full bg-brand-navy px-5 py-2.5 text-sm font-medium text-brand-snow transition hover:bg-brand-navy-light lg:inline-flex dark:bg-brand-accent dark:text-brand-navy dark:hover:bg-brand-accent-dark"
                    >
                        {{ $section->content['cta_text'] ?? '' }}
                    </a>

                    <button
                        type="button"
                        x-on:click="open = !open"
                        class="inline-flex size-10 items-center justify-center rounded-full text-brand-navy hover:bg-brand-navy/5 lg:hidden dark:text-brand-snow dark:hover:bg-brand-snow/10"
                        aria-label="Toggle menu"
                    >
                        <x-landing.icon x-show="!open" name="menu" class="size-5" />
                        <x-landing.icon x-show="open" x-cloak name="close" class="size-5" />
                    </button>
                </div>
            </div>
        </div>

        <div x-show="open" x-collapse x-cloak class="border-t border-brand-navy/10 lg:hidden dark:border-brand-snow/10">
            <div class="mx-auto flex max-w-7xl flex-col gap-1 px-6 py-4">
                @foreach ($section->content['nav_items'] ?? [] as $item)
                    <a
                        href="{{ $item['url'] ?? '#' }}"
                        x-on:click="open = false"
                        class="rounded-lg px-3 py-2 text-sm font-medium text-brand-navy/70 transition hover:bg-brand-navy/5 hover:text-brand-navy dark:text-brand-silver dark:hover:bg-brand-snow/10 dark:hover:text-brand-snow"
                    >
                        {{ $item['label'] ?? '' }}
                    </a>
                @endforeach
                <a
                    href="{{ $section->content['cta_url'] ?? '#' }}"
                    class="mt-2 inline-flex items-center justify-center gap-2 rounded-full bg-brand-navy px-5 py-2.5 text-sm font-medium text-brand-snow transition hover:bg-brand-navy-light dark:bg-brand-accent dark:text-brand-navy dark:hover:bg-brand-accent-dark"
                >
                    {{ $section->content['cta_text'] ?? '' }}
                </a>
            </div>
        </div>
    </nav>
@endif
