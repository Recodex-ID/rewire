@php
    $logos = ['Laravel', 'Livewire', 'Flux UI', 'Pest', 'Tailwind', 'Spatie'];
@endphp

<section class="border-y border-brand-navy/10 bg-brand-snow py-14">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="landing-reveal mb-10 flex items-center justify-center gap-4">
            <span class="h-px flex-1 max-w-24 bg-brand-navy/15"></span>
            <p class="whitespace-nowrap font-mono text-xs font-medium uppercase tracking-[0.25em] text-brand-navy/50">
                Built with tools you already trust
            </p>
            <span class="h-px flex-1 max-w-24 bg-brand-navy/15"></span>
        </div>

        <div class="landing-marquee-mask landing-reveal landing-reveal-delay-1 overflow-hidden">
            <div class="landing-animate-scroll-x flex w-max items-center gap-16">
                @foreach ($logos as $name)
                    <span class="shrink-0 font-display text-2xl font-bold tracking-tight text-brand-navy/30 transition hover:text-brand-navy/60">
                        {{ $name }}
                    </span>
                @endforeach
                @foreach ($logos as $name)
                    <span aria-hidden="true" class="shrink-0 font-display text-2xl font-bold tracking-tight text-brand-navy/30 transition hover:text-brand-navy/60">
                        {{ $name }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</section>
