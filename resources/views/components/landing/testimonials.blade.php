@php
    $items = [
        ['quote' => 'This starter kit saved us weeks of setup on our last three client projects.', 'name' => 'Jane Doe', 'role' => 'Founder, Acme Inc', 'rating' => 5],
        ['quote' => 'Handing the blog over to the client was painless — they publish posts themselves now.', 'name' => 'John Smith', 'role' => 'Lead Developer', 'rating' => 5],
        ['quote' => 'Roles were already wired up, so gating our admin panel took minutes instead of days.', 'name' => 'Amelia Putri', 'role' => 'CTO, Nimbus Studio', 'rating' => 5],
    ];
@endphp

<section class="bg-brand-snow">
    <div class="mx-auto max-w-7xl px-6 py-24">
        <div class="landing-reveal flex flex-col items-center text-center">
            <div class="flex items-center gap-3">
                <span class="h-px w-8 bg-brand-accent"></span>
                <span class="font-mono text-xs uppercase tracking-widest text-brand-accent">
                    Voices
                </span>
                <span class="h-px w-8 bg-brand-accent"></span>
            </div>
            <h2 class="mt-4 font-display text-4xl font-semibold tracking-tight text-brand-navy sm:text-5xl">
                What people say
            </h2>
        </div>

        <div class="mt-16 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($items as $item)
                @php
                    $initials = collect(explode(' ', trim($item['name'])))
                        ->filter()
                        ->take(2)
                        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
                        ->implode('');
                    $delay = ($loop->index % 4) + 1;
                @endphp
                <div
                    class="landing-card-hover landing-reveal landing-reveal-delay-{{ $delay }} flex flex-col rounded-2xl border border-brand-navy/10 bg-white p-8"
                >
                    <div class="flex items-center gap-1">
                        @for ($i = 1; $i <= $item['rating']; $i++)
                            <x-landing.icon name="star" class="size-3 text-brand-accent" />
                        @endfor
                    </div>

                    <p class="mt-6 text-base text-brand-navy/80">
                        &ldquo;{{ $item['quote'] }}&rdquo;
                    </p>

                    <div class="mt-8 flex items-center gap-3 border-t border-brand-navy/10 pt-6">
                        <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-navy/5 font-mono text-xs font-medium text-brand-navy">
                            {{ $initials }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-brand-navy">
                                {{ $item['name'] }}
                            </p>
                            <p class="text-xs text-brand-navy/50">
                                {{ $item['role'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
