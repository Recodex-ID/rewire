@if ($section?->is_visible)
    <section class="relative overflow-hidden bg-brand-navy text-brand-snow">
        <div class="landing-grid-bg-dark absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-6 py-24 lg:px-8">
            <div class="grid gap-16 lg:grid-cols-12 lg:items-center lg:gap-8">
                <div class="landing-reveal lg:col-span-5">
                    <p class="font-mono text-sm uppercase tracking-widest text-brand-accent">
                        {{ $section->content['eyebrow'] ?? '' }}
                    </p>
                    <h2 class="mt-4 font-display text-4xl font-bold text-brand-snow sm:text-5xl">
                        {{ $section->content['heading_line1'] ?? '' }}
                        <span class="block font-light text-brand-accent italic">{{ $section->content['heading_highlight'] ?? '' }}</span>
                    </h2>
                    <p class="mt-6 text-lg text-brand-silver">
                        {{ $section->content['subheading'] ?? '' }}
                    </p>

                    <div class="mt-10">
                        @foreach ($section->content['regions'] ?? [] as $region)
                            <div class="flex items-center justify-between border-b border-brand-snow/10 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="landing-animate-pulse-soft size-2 rounded-full bg-brand-accent"></span>
                                    <span class="font-mono text-sm uppercase tracking-wide text-brand-snow">{{ $region['name'] ?? '' }}</span>
                                </div>
                                <span class="text-sm text-brand-silver">{{ $region['cities'] ?? '' }}</span>
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
                                Network Status &middot; {{ $section->content['status_label'] ?? '' }}
                            </span>
                        </div>

                        <div class="relative mt-24 grid grid-cols-2 gap-8 sm:mt-40">
                            <div>
                                <p class="font-display text-4xl font-bold text-brand-snow sm:text-5xl">
                                    {{ $section->content['latency_value'] ?? '' }}<span class="text-xl text-brand-accent">ms</span>
                                </p>
                                <p class="mt-2 font-mono text-xs uppercase tracking-widest text-brand-silver">Avg. Latency</p>
                            </div>
                            <div>
                                <p class="font-display text-4xl font-bold text-brand-snow sm:text-5xl">
                                    {{ $section->content['data_centers_value'] ?? '' }}
                                </p>
                                <p class="mt-2 font-mono text-xs uppercase tracking-widest text-brand-silver">Data Centers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
