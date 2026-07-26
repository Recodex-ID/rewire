@if ($section?->is_visible)
    <section class="border-y border-brand-navy/10 bg-brand-snow py-14 dark:border-brand-snow/10 dark:bg-zinc-900">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="landing-reveal mb-10 flex items-center justify-center gap-4">
                <span class="h-px flex-1 max-w-24 bg-brand-navy/15 dark:bg-brand-snow/15"></span>
                <p class="whitespace-nowrap font-mono text-xs font-medium uppercase tracking-[0.25em] text-brand-navy/50 dark:text-brand-silver/60">
                    {{ $section->content['heading'] ?? '' }}
                </p>
                <span class="h-px flex-1 max-w-24 bg-brand-navy/15 dark:bg-brand-snow/15"></span>
            </div>

            <div class="landing-marquee-mask landing-reveal landing-reveal-delay-1 overflow-hidden">
                <div class="landing-animate-scroll-x flex w-max items-center gap-16">
                    @foreach ($section->content['logos'] ?? [] as $logo)
                        <span class="shrink-0 font-display text-2xl font-bold tracking-tight text-brand-navy/30 transition hover:text-brand-navy/60 dark:text-brand-snow/30 dark:hover:text-brand-snow/60">
                            {{ $logo['name'] ?? '' }}
                        </span>
                    @endforeach
                    @foreach ($section->content['logos'] ?? [] as $logo)
                        <span aria-hidden="true" class="shrink-0 font-display text-2xl font-bold tracking-tight text-brand-navy/30 transition hover:text-brand-navy/60 dark:text-brand-snow/30 dark:hover:text-brand-snow/60">
                            {{ $logo['name'] ?? '' }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
