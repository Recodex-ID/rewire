@if ($section?->is_visible)
    <section class="bg-brand-snow py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-8">
                <div class="landing-reveal lg:col-span-5">
                    <span class="font-mono text-sm uppercase tracking-widest text-brand-accent">
                        {{ $section->content['eyebrow'] ?? '' }}
                    </span>
                    <h2 class="mt-4 font-display text-3xl font-bold tracking-tight text-brand-navy sm:text-4xl">
                        {{ $section->content['heading'] ?? '' }}
                    </h2>
                    <p class="mt-4 text-base text-brand-navy/70">
                        {{ $section->content['subheading'] ?? '' }}
                    </p>

                    <div class="mt-10 flex flex-wrap gap-8">
                        @foreach ($section->content['stats'] ?? [] as $stat)
                            <div class="{{ $loop->first ? '' : 'border-l border-brand-navy/10 pl-8' }}">
                                <div class="font-display text-2xl font-bold text-brand-navy">
                                    {{ $stat['value'] ?? '' }}
                                </div>
                                <div class="mt-1 text-sm text-brand-navy/60">
                                    {{ $stat['label'] ?? '' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="landing-reveal landing-reveal-delay-2 lg:col-span-7">
                    <div class="divide-y divide-brand-navy/10 border-t border-brand-navy/10">
                        @foreach ($section->content['steps'] ?? [] as $step)
                            <div class="grid grid-cols-12 items-start gap-4 rounded-lg px-4 py-6 -mx-4 transition hover:bg-brand-navy/[0.03]">
                                <div class="col-span-2 font-mono text-sm text-brand-accent sm:col-span-1">
                                    {{ $step['number'] ?? $loop->iteration }}
                                </div>
                                <div class="col-span-10 sm:col-span-8">
                                    <h3 class="font-display text-lg font-bold text-brand-navy">
                                        {{ $step['title'] ?? '' }}
                                    </h3>
                                    <p class="mt-1 text-sm text-brand-navy/60">
                                        {{ $step['description'] ?? '' }}
                                    </p>
                                </div>
                                <div class="col-span-12 text-right font-mono text-xs text-brand-navy/40 sm:col-span-3">
                                    {{ $step['duration'] ?? '' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
