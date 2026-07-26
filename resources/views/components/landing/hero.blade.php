@if ($section?->is_visible)
    @php
        $badgeText = $section->content['badge_text'] ?? '';
        $badgeSecondary = $section->content['badge_secondary'] ?? '';
        $headingLine1 = $section->content['heading_line1'] ?? '';
        $headingHighlight = $section->content['heading_highlight'] ?? '';
        $headingLine2 = $section->content['heading_line2'] ?? '';
        $subheading = $section->content['subheading'] ?? '';
        $primaryCtaText = $section->content['primary_cta_text'] ?? '';
        $primaryCtaUrl = $section->content['primary_cta_url'] ?? '#';
        $secondaryCtaText = $section->content['secondary_cta_text'] ?? '';
        $secondaryCtaUrl = $section->content['secondary_cta_url'] ?? '#';
        $stats = $section->content['stats'] ?? [];
        $backgroundImage = $section->content['background_image'] ?? null;
    @endphp

    <section class="relative overflow-hidden bg-brand-snow">
        @if ($backgroundImage)
            <div class="absolute inset-0">
                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($backgroundImage) }}" class="size-full object-cover" alt="">
                <div class="absolute inset-0 bg-brand-snow/85"></div>
            </div>
        @else
            <div class="landing-grid-bg absolute inset-0"></div>
            <div class="landing-grid-bg-dark absolute inset-0 hidden"></div>
        @endif

        <div class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-16 px-6 py-24 lg:grid-cols-2 lg:py-32">
            <div>
                @if ($badgeText || $badgeSecondary)
                    <div class="landing-reveal inline-flex items-center gap-2 rounded-full border border-brand-navy/10 bg-brand-navy/5 px-4 py-1.5 font-mono text-xs text-brand-navy">
                        @if ($badgeText)
                            <span>{{ $badgeText }}</span>
                        @endif
                        @if ($badgeText && $badgeSecondary)
                            <span class="text-brand-navy/30">/</span>
                        @endif
                        @if ($badgeSecondary)
                            <span class="text-brand-accent-dark">{{ $badgeSecondary }}</span>
                        @endif
                    </div>
                @endif

                <h1 class="landing-reveal landing-reveal-delay-1 mt-6 font-display text-5xl leading-[1.05] font-semibold tracking-tight text-brand-navy sm:text-6xl">
                    @if ($headingLine1)
                        {{ $headingLine1 }}<br>
                    @endif
                    @if ($headingHighlight)
                        <span class="text-brand-accent-dark underline decoration-brand-accent/40 decoration-8 underline-offset-4">{{ $headingHighlight }}</span><br>
                    @endif
                    {{ $headingLine2 }}
                </h1>

                @if ($subheading)
                    <p class="landing-reveal landing-reveal-delay-2 mt-6 max-w-xl text-lg text-brand-navy/70">
                        {{ $subheading }}
                    </p>
                @endif

                <div class="landing-reveal landing-reveal-delay-3 mt-10 flex flex-wrap items-center gap-4">
                    @if ($primaryCtaText)
                        <a href="{{ $primaryCtaUrl }}" class="inline-flex items-center gap-2 rounded-full bg-brand-navy px-6 py-3 text-sm font-medium text-brand-snow transition hover:bg-brand-navy-light">
                            {{ $primaryCtaText }}
                            <x-landing.icon name="arrow-right" class="size-4" />
                        </a>
                    @endif
                    @if ($secondaryCtaText)
                        <a href="{{ $secondaryCtaUrl }}" class="inline-flex items-center gap-2 rounded-full border border-brand-navy/20 px-6 py-3 text-sm font-medium text-brand-navy transition hover:bg-brand-navy/5">
                            {{ $secondaryCtaText }}
                        </a>
                    @endif
                </div>

                @if (count($stats))
                    <div class="landing-reveal landing-reveal-delay-4 mt-16 flex flex-wrap gap-10">
                        @foreach ($stats as $stat)
                            @php
                                $value = $stat['value'] ?? '';
                                $suffix = $stat['suffix'] ?? '';
                            @endphp
                            <div>
                                <div class="font-display text-4xl font-semibold text-brand-navy">
                                    @if (is_numeric($value))
                                        <span class="landing-counter" data-target="{{ $value }}" data-decimals="0">0</span>{{ $suffix }}
                                    @else
                                        {{ $value }}{{ $suffix }}
                                    @endif
                                </div>
                                <div class="mt-1 font-mono text-xs tracking-wide text-brand-navy/50 uppercase">
                                    {{ $stat['label'] ?? '' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="relative hidden h-[28rem] items-center justify-center lg:flex">
                <div class="landing-animate-spin-slow absolute size-96 rounded-full border border-brand-navy/10"></div>
                <div class="landing-animate-spin-reverse absolute size-72 rounded-full border border-brand-accent/20"></div>
                <div class="absolute size-48 rounded-full bg-brand-accent/10"></div>

                <div class="landing-animate-float absolute -top-4 left-4 flex items-center gap-3 rounded-2xl bg-brand-snow p-4 shadow-xl">
                    <span class="flex size-8 items-center justify-center rounded-full bg-brand-accent/10 text-brand-accent-dark">
                        <x-landing.icon name="check" class="size-4" />
                    </span>
                    <span class="font-mono text-xs font-medium text-brand-navy">All systems go</span>
                </div>

                <div class="landing-animate-float-slow absolute right-0 bottom-8 flex items-center gap-3 rounded-2xl bg-brand-snow p-4 shadow-xl">
                    <span class="flex size-8 items-center justify-center rounded-full bg-brand-navy/10 text-brand-navy">
                        <x-landing.icon name="cloud" class="size-4" />
                    </span>
                    <span class="font-mono text-xs font-medium text-brand-navy">Synced in realtime</span>
                </div>
            </div>
        </div>
    </section>
@endif
