@php
    $stats = [
        ['value' => '15', 'suffix' => '+', 'label' => 'Reusable modules'],
        ['value' => '2', 'suffix' => '', 'label' => 'Roles built in'],
        ['value' => '9', 'suffix' => '', 'label' => 'Landing page sections'],
    ];
@endphp

<section id="hero" class="relative overflow-hidden bg-brand-navy">
    <div class="landing-grid-bg-dark absolute inset-0 opacity-50"></div>

    <div class="landing-animate-float absolute -top-24 -left-24 size-72 rounded-full bg-brand-accent/20 blur-3xl"></div>
    <div class="landing-animate-float-slow absolute right-0 -bottom-24 size-72 rounded-full bg-brand-accent/10 blur-3xl"></div>

    <div class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-16 px-6 py-24 lg:grid-cols-2 lg:py-32">
        <div>
            <div class="landing-reveal inline-flex items-center gap-2 rounded-full border border-brand-snow/10 bg-brand-snow/5 px-4 py-1.5 font-mono text-xs text-brand-snow backdrop-blur-sm">
                <span>Built on Laravel &amp; Livewire</span>
                <span class="text-brand-snow/30">/</span>
                <span class="text-brand-accent">Ready for your next client project</span>
            </div>

            <h1 class="landing-reveal landing-reveal-delay-1 mt-6 font-display text-5xl leading-[1.05] font-semibold tracking-tight text-brand-snow sm:text-6xl">
                Ship your next<br>
                <span class="text-brand-accent underline decoration-brand-accent/40 decoration-8 underline-offset-4">client project</span><br>
                in days, not weeks.
            </h1>

            <p class="landing-reveal landing-reveal-delay-2 mt-6 max-w-xl text-lg text-brand-silver/80">
                A reusable Laravel starter kit with authentication, roles, and a blog ready to publish — so every new project starts from a working foundation, not a blank repo.
            </p>

            <div class="landing-reveal landing-reveal-delay-3 mt-10 flex flex-wrap items-center gap-4">
                <a href="{{ route('home') }}#contact" class="inline-flex items-center gap-2 rounded-full bg-brand-accent px-6 py-3 text-sm font-medium text-brand-navy transition hover:bg-brand-accent-dark">
                    Get started
                    <x-landing.icon name="arrow-right" class="size-4" />
                </a>
                <a href="{{ route('home') }}#services" class="inline-flex items-center gap-2 rounded-full border border-brand-snow/20 px-6 py-3 text-sm font-medium text-brand-snow transition hover:bg-brand-snow/10">
                    Explore features
                </a>
            </div>

            <div class="landing-reveal landing-reveal-delay-4 mt-16 flex flex-wrap gap-10">
                @foreach ($stats as $stat)
                    <div>
                        <div class="font-display text-4xl font-semibold text-brand-snow">
                            @if (is_numeric($stat['value']))
                                <span class="landing-counter" data-target="{{ $stat['value'] }}" data-decimals="0">0</span>{{ $stat['suffix'] }}
                            @else
                                {{ $stat['value'] }}{{ $stat['suffix'] }}
                            @endif
                        </div>
                        <div class="mt-1 font-mono text-xs tracking-wide text-brand-silver/60 uppercase">
                            {{ $stat['label'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="relative hidden h-[28rem] items-center justify-center lg:flex">
            <div class="landing-animate-spin-slow absolute size-96 rounded-full border border-brand-accent/15">
                <div class="absolute top-0 left-1/2 size-3 -translate-x-1/2 -translate-y-1/2 rounded-full bg-brand-accent shadow-[0_0_60px_rgba(77,163,255,0.4)]"></div>
            </div>
            <div class="landing-animate-spin-reverse absolute size-72 rounded-full border border-brand-snow/10">
                <div class="absolute top-0 left-1/2 size-2.5 -translate-x-1/2 -translate-y-1/2 rounded-full bg-brand-snow"></div>
                <div class="absolute bottom-0 left-1/2 size-2 -translate-x-1/2 translate-y-1/2 rounded-full bg-brand-accent/60"></div>
            </div>
            <div class="absolute size-48 rounded-full bg-brand-accent/10"></div>

            <div class="relative flex size-28 items-center justify-center rounded-3xl border border-brand-snow/10 bg-brand-navy-light shadow-2xl backdrop-blur-sm">
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-brand-accent/20 to-transparent"></div>
                <x-landing.icon name="check" class="relative size-9 text-brand-accent" />
            </div>

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
