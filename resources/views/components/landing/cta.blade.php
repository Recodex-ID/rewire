@if ($section?->is_visible)
    <section class="bg-brand-snow py-24">
        <div class="landing-reveal relative mx-auto max-w-6xl overflow-hidden rounded-3xl bg-brand-navy px-6 py-16 sm:px-12 lg:px-16">
            <div class="landing-grid-bg-dark absolute inset-0"></div>

            <div class="landing-animate-float absolute -top-24 -left-24 size-72 rounded-full bg-brand-accent/20 blur-3xl"></div>
            <div class="landing-animate-float-slow absolute -bottom-24 -right-24 size-72 rounded-full bg-brand-accent/20 blur-3xl"></div>

            <div class="relative grid grid-cols-1 gap-12 lg:grid-cols-12 lg:items-center">
                <div class="lg:col-span-7">
                    <p class="font-mono text-sm font-medium tracking-wide text-brand-accent">
                        {{ $section->content['eyebrow'] ?? '' }}
                    </p>
                    <h2 class="mt-4 font-display text-3xl font-bold tracking-tight text-brand-snow sm:text-4xl lg:text-5xl">
                        {{ $section->content['heading_line1'] ?? '' }}
                        <br>
                        {{ $section->content['heading_line2'] ?? '' }}
                    </h2>
                    <p class="mt-6 max-w-xl text-lg text-brand-snow/70">
                        {{ $section->content['subheading'] ?? '' }}
                    </p>

                    <div class="mt-10 flex flex-wrap items-center gap-4">
                        <a href="{{ $section->content['primary_url'] ?? '#' }}" class="inline-flex items-center gap-2 rounded-full bg-brand-accent px-6 py-3 text-sm font-medium text-brand-navy transition hover:bg-brand-accent-dark">
                            {{ $section->content['primary_text'] ?? '' }}
                            <x-landing.icon name="arrow-right" class="size-4" />
                        </a>
                        <a href="{{ $section->content['secondary_url'] ?? '#' }}" class="inline-flex items-center gap-2 rounded-full border border-brand-snow/20 px-6 py-3 text-sm font-medium text-brand-snow transition hover:bg-brand-snow/10">
                            <x-landing.icon name="mail" class="size-4" />
                            {{ $section->content['secondary_text'] ?? '' }}
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="rounded-2xl border border-brand-snow/10 bg-brand-snow/5 p-8 backdrop-blur">
                        <p class="font-mono text-xs font-medium tracking-wide text-brand-accent uppercase">
                            {{ $section->content['contact_label'] ?? '' }}
                        </p>

                        <div class="mt-6 space-y-6">
                            <div class="flex items-start gap-4">
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-accent/10">
                                    <x-landing.icon name="location" class="size-5 text-brand-accent" />
                                </span>
                                <div>
                                    <p class="text-sm text-brand-snow/60">{{ $section->content['address_label'] ?? '' }}</p>
                                    <p class="mt-1 font-medium text-brand-snow">{{ $section->content['address'] ?? '' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-accent/10">
                                    <x-landing.icon name="mail" class="size-5 text-brand-accent" />
                                </span>
                                <div>
                                    <p class="text-sm text-brand-snow/60">Email</p>
                                    <p class="mt-1 font-medium text-brand-snow">{{ $section->content['email'] ?? '' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-accent/10">
                                    <x-landing.icon name="phone" class="size-5 text-brand-accent" />
                                </span>
                                <div>
                                    <p class="text-sm text-brand-snow/60">Phone</p>
                                    <p class="mt-1 font-medium text-brand-snow">{{ $section->content['phone'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
