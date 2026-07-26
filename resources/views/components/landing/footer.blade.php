@if ($section?->is_visible)
    <footer class="landing-grid-bg-dark relative overflow-hidden bg-brand-navy text-brand-snow">
        <div class="relative mx-auto max-w-7xl px-6 py-20">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-12">
                <div class="landing-reveal lg:col-span-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <span class="flex size-9 items-center justify-center rounded-lg bg-brand-accent font-display text-lg font-bold text-brand-navy">R</span>
                        <span class="font-display text-lg font-semibold text-brand-snow">{{ config('app.name') }}</span>
                    </a>
                    <p class="mt-5 max-w-sm text-sm text-brand-silver/80">
                        {{ $section->content['tagline'] ?? '' }}
                    </p>
                    <div class="mt-6 flex items-center gap-3">
                        @foreach ($section->content['social'] ?? [] as $s)
                            <a
                                href="{{ $s['url'] ?? '#' }}"
                                class="flex size-9 items-center justify-center rounded-lg border border-brand-snow/15 text-brand-silver transition hover:border-brand-accent/40 hover:text-brand-accent"
                            >
                                <x-landing.icon :name="$s['platform'] ?? ''" class="size-4" />
                            </a>
                        @endforeach
                    </div>
                </div>

                @foreach ($section->content['columns'] ?? [] as $column)
                    <div class="landing-reveal landing-reveal-delay-{{ min($loop->iteration, 4) }} lg:col-span-2">
                        <p class="font-mono text-xs font-medium uppercase tracking-widest text-brand-silver/60">
                            {{ $column['heading'] ?? '' }}
                        </p>
                        <ul class="mt-5 space-y-3">
                            @foreach ($column['links'] ?? [] as $link)
                                <li>
                                    <a href="{{ $link['url'] ?? '#' }}" class="text-sm text-brand-silver/80 transition hover:text-brand-snow">
                                        {{ $link['label'] ?? '' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

            <div class="mt-16 flex flex-col gap-6 border-t border-brand-snow/10 pt-8 lg:flex-row lg:items-center lg:justify-between">
                <p class="text-sm text-brand-silver/60">
                    {{ $section->content['copyright_text'] ?? '' }}
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
@endif
