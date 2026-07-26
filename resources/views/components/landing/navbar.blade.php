<nav
    x-data="{ open: false, scrolled: false }"
    x-on:scroll.window="scrolled = window.scrollY > 20"
    :class="scrolled ? 'shadow-sm bg-brand-snow/95' : 'bg-brand-snow/80'"
    class="fixed inset-x-0 top-0 z-50 backdrop-blur transition-colors"
>
    <div class="mx-auto max-w-7xl px-6">
        <div class="flex h-16 items-center justify-between lg:h-20">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="size-10 shrink-0 rounded-xl border border-brand-navy bg-brand-snow p-1.5">
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
                    ['label' => 'Services', 'url' => route('home').'#services'],
                    ['label' => 'Infrastructure', 'url' => route('home').'#infrastructure'],
                    ['label' => 'Solutions', 'url' => route('home').'#solutions'],
                    ['label' => 'About', 'url' => route('home').'#about'],
                    ['label' => 'Blog', 'url' => route('blogs')],
                    ['label' => 'Contact', 'url' => route('home').'#contact'],
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
                    href="{{ route('home') }}#contact"
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
                ['label' => 'Services', 'url' => route('home').'#services'],
                ['label' => 'Infrastructure', 'url' => route('home').'#infrastructure'],
                ['label' => 'Solutions', 'url' => route('home').'#solutions'],
                ['label' => 'About', 'url' => route('home').'#about'],
                ['label' => 'Blog', 'url' => route('blogs')],
                ['label' => 'Contact', 'url' => route('home').'#contact'],
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
                href="{{ route('home') }}#contact"
                class="mt-2 inline-flex items-center justify-center gap-2 rounded-full bg-brand-navy px-5 py-2.5 text-sm font-medium text-brand-snow transition hover:bg-brand-navy-light"
            >
                Get started
            </a>
        </div>
    </div>
</nav>
