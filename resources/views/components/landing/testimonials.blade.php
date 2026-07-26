@if ($section?->is_visible)
    <section class="bg-brand-snow dark:bg-zinc-900">
        <div class="mx-auto max-w-7xl px-6 py-24">
            <div class="landing-reveal flex flex-col items-center text-center">
                <div class="flex items-center gap-3">
                    <span class="h-px w-8 bg-brand-accent"></span>
                    <span class="font-mono text-xs uppercase tracking-widest text-brand-accent">
                        {{ $section->content['eyebrow'] ?? '' }}
                    </span>
                    <span class="h-px w-8 bg-brand-accent"></span>
                </div>
                <h2 class="mt-4 font-display text-4xl font-semibold tracking-tight text-brand-navy sm:text-5xl dark:text-brand-snow">
                    {{ $section->content['heading'] ?? '' }}
                </h2>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($section->content['items'] ?? [] as $item)
                    @php
                        $initials = collect(explode(' ', trim($item['name'] ?? '')))
                            ->filter()
                            ->take(2)
                            ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
                            ->implode('');
                        $delay = ($loop->index % 4) + 1;
                    @endphp
                    <div
                        class="landing-card-hover landing-reveal landing-reveal-delay-{{ $delay }} flex flex-col rounded-2xl border border-brand-navy/10 bg-white p-8 dark:border-brand-snow/10 dark:bg-zinc-800"
                    >
                        <div class="flex items-center gap-1">
                            @for ($i = 1; $i <= ($item['rating'] ?? 0); $i++)
                                <x-landing.icon name="star" class="size-3 text-brand-accent" />
                            @endfor
                        </div>

                        <p class="mt-6 text-base text-brand-navy/80 dark:text-brand-silver">
                            &ldquo;{{ $item['quote'] ?? '' }}&rdquo;
                        </p>

                        <div class="mt-8 flex items-center gap-3 border-t border-brand-navy/10 pt-6 dark:border-brand-snow/10">
                            @if ($item['avatar'] ?? null)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item['avatar']) }}" class="size-10 shrink-0 rounded-full object-cover" alt="{{ $item['name'] ?? '' }}">
                            @else
                                <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-navy/5 font-mono text-xs font-medium text-brand-navy dark:bg-brand-snow/10 dark:text-brand-snow">
                                    {{ $initials }}
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-brand-navy dark:text-brand-snow">
                                    {{ $item['name'] ?? '' }}
                                </p>
                                <p class="text-xs text-brand-navy/50 dark:text-brand-silver/70">
                                    {{ $item['role'] ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
