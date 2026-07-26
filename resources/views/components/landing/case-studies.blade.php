@if ($section?->is_visible)
    <section class="bg-brand-snow py-24 dark:bg-zinc-900 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="landing-reveal max-w-2xl">
                <p class="font-mono text-sm uppercase tracking-widest text-brand-accent-dark dark:text-brand-accent">
                    {{ $section->content['eyebrow'] ?? '' }}
                </p>
                <h2 class="mt-4 font-display text-4xl font-bold tracking-tight text-brand-navy dark:text-brand-snow sm:text-5xl">
                    {{ $section->content['heading'] ?? '' }}
                </h2>
            </div>

            <div class="mt-16 grid gap-8 lg:grid-cols-2">
                @foreach ($section->content['items'] ?? [] as $item)
                    @if ($loop->first)
                        <div class="landing-reveal landing-reveal-delay-1 rounded-3xl bg-brand-navy p-10 dark:ring-1 dark:ring-white/10 sm:p-12">
                            <div class="flex items-center justify-between">
                                <span class="font-mono text-xs uppercase tracking-widest text-brand-accent">
                                    {{ $item['category'] ?? '' }}
                                </span>
                                <span class="font-mono text-xs text-brand-snow/60">
                                    {{ $item['year'] ?? '' }}
                                </span>
                            </div>
                            <h3 class="mt-6 font-display text-3xl font-bold text-brand-snow sm:text-4xl">
                                {{ $item['title'] ?? '' }}
                            </h3>
                            <p class="mt-4 text-lg leading-relaxed text-brand-snow/80">
                                {{ $item['description'] ?? '' }}
                            </p>

                            <div class="mt-10 grid grid-cols-2 gap-6 border-t border-white/10 pt-8 sm:grid-cols-3">
                                @foreach ($item['metrics'] ?? [] as $metric)
                                    <div>
                                        <p class="font-display text-3xl font-bold text-brand-accent">
                                            {{ $metric['value'] ?? '' }}
                                        </p>
                                        <p class="mt-1 text-xs text-brand-snow/60">
                                            {{ $metric['label'] ?? '' }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="landing-reveal landing-card-hover landing-reveal-delay-{{ min($loop->index + 1, 4) }} rounded-3xl border border-brand-navy/10 bg-brand-snow p-10 dark:border-zinc-700 dark:bg-zinc-800 sm:p-12">
                            <div class="flex items-center justify-between">
                                <span class="font-mono text-xs uppercase tracking-widest text-brand-accent-dark dark:text-brand-accent">
                                    {{ $item['category'] ?? '' }}
                                </span>
                                <span class="font-mono text-xs text-brand-navy/50 dark:text-brand-silver/60">
                                    {{ $item['year'] ?? '' }}
                                </span>
                            </div>
                            <h3 class="mt-6 font-display text-2xl font-bold text-brand-navy dark:text-brand-snow">
                                {{ $item['title'] ?? '' }}
                            </h3>
                            <p class="mt-4 leading-relaxed text-brand-navy/70 dark:text-brand-silver/80">
                                {{ $item['description'] ?? '' }}
                            </p>

                            <div class="mt-10 grid grid-cols-2 gap-6 border-t border-brand-navy/10 pt-8 dark:border-zinc-700 sm:grid-cols-3">
                                @foreach ($item['metrics'] ?? [] as $metric)
                                    <div>
                                        <p class="font-display text-3xl font-bold text-brand-accent-dark dark:text-brand-accent">
                                            {{ $metric['value'] ?? '' }}
                                        </p>
                                        <p class="mt-1 text-xs text-brand-navy/50 dark:text-brand-silver/60">
                                            {{ $metric['label'] ?? '' }}
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
@endif
