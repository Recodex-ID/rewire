@if ($section?->is_visible)
    <section class="relative overflow-hidden bg-brand-snow py-24 dark:bg-zinc-900">
        <div class="landing-dot-pattern absolute inset-0"></div>

        <div class="relative mx-auto max-w-6xl px-6">
            <div class="landing-reveal mx-auto max-w-2xl text-center">
                <p class="font-mono text-sm font-medium tracking-wide text-brand-accent-dark dark:text-brand-accent">
                    {{ $section->content['eyebrow'] ?? '' }}
                </p>
                <h2 class="mt-4 font-display text-3xl font-bold tracking-tight text-brand-navy sm:text-4xl dark:text-brand-snow">
                    {{ $section->content['heading_line1'] ?? '' }}
                    <span class="italic text-brand-accent-dark/70 dark:text-brand-accent/70">{{ $section->content['heading_highlight'] ?? '' }}</span>
                </h2>
            </div>

            <div class="mt-16 grid grid-cols-2 gap-x-6 gap-y-12 lg:grid-cols-4">
                @foreach ($section->content['items'] ?? [] as $item)
                    @php
                        $value = (string) ($item['value'] ?? '0');
                        $decimals = str_contains($value, '.') ? strlen(substr(strrchr($value, '.'), 1)) : 0;
                    @endphp
                    <div @class([
                        'landing-reveal text-center',
                        'landing-reveal-delay-1' => $loop->iteration === 2,
                        'landing-reveal-delay-2' => $loop->iteration === 3,
                        'landing-reveal-delay-3' => $loop->iteration === 4,
                    ])>
                        <div class="flex items-baseline justify-center font-display text-4xl font-bold text-brand-navy sm:text-5xl dark:text-brand-snow">
                            <span class="landing-counter" data-target="{{ $value }}" data-decimals="{{ $decimals }}">0</span><span class="text-brand-accent-dark dark:text-brand-accent">{{ $item['suffix'] ?? '' }}</span>
                        </div>
                        <div class="mx-auto mt-4 w-10 border-t border-brand-navy/15 pt-4 dark:border-brand-snow/15">
                            <p class="font-medium text-brand-navy dark:text-brand-snow">{{ $item['label'] ?? '' }}</p>
                            <p class="mt-1 text-sm text-brand-navy/60 dark:text-brand-snow/60">{{ $item['sublabel'] ?? '' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
