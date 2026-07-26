@php
    $items = [
        [
            'category' => 'Internal tool',
            'year' => '2026',
            'title' => 'Spin up an admin-gated back office in an afternoon.',
            'description' => 'Roles, a blog, and an authenticated dashboard are already wired together — customize the parts that make this project unique.',
            'metrics' => [
                ['value' => '1', 'label' => 'Afternoon'],
                ['value' => '0', 'label' => 'Boilerplate'],
            ],
        ],
        [
            'category' => 'Client site',
            'year' => '2026',
            'title' => 'Give your client a blog they can run themselves.',
            'description' => 'Every post — title, images, publish state — is managed from the admin panel, so content updates never need a developer.',
            'metrics' => [
                ['value' => '1', 'label' => 'Blog, ready to go'],
                ['value' => '0', 'label' => 'Redeploys needed'],
            ],
        ],
    ];
@endphp

<section class="bg-brand-snow py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="landing-reveal max-w-2xl">
            <p class="font-mono text-sm uppercase tracking-widest text-brand-accent-dark">
                Solutions
            </p>
            <h2 class="mt-4 font-display text-4xl font-bold tracking-tight text-brand-navy sm:text-5xl">
                Built for how client work actually happens
            </h2>
        </div>

        <div class="mt-16 grid gap-8 lg:grid-cols-2">
            @foreach ($items as $item)
                @if ($loop->first)
                    <div class="landing-reveal landing-reveal-delay-1 rounded-3xl bg-brand-navy p-10 sm:p-12">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs uppercase tracking-widest text-brand-accent">
                                {{ $item['category'] }}
                            </span>
                            <span class="font-mono text-xs text-brand-snow/60">
                                {{ $item['year'] }}
                            </span>
                        </div>
                        <h3 class="mt-6 font-display text-3xl font-bold text-brand-snow sm:text-4xl">
                            {{ $item['title'] }}
                        </h3>
                        <p class="mt-4 text-lg leading-relaxed text-brand-snow/80">
                            {{ $item['description'] }}
                        </p>

                        <div class="mt-10 grid grid-cols-2 gap-6 border-t border-white/10 pt-8 sm:grid-cols-3">
                            @foreach ($item['metrics'] as $metric)
                                <div>
                                    <p class="font-display text-3xl font-bold text-brand-accent">
                                        {{ $metric['value'] }}
                                    </p>
                                    <p class="mt-1 text-xs text-brand-snow/60">
                                        {{ $metric['label'] }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="landing-reveal landing-card-hover landing-reveal-delay-{{ min($loop->index + 1, 4) }} rounded-3xl border border-brand-navy/10 bg-brand-snow p-10 sm:p-12">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs uppercase tracking-widest text-brand-accent-dark">
                                {{ $item['category'] }}
                            </span>
                            <span class="font-mono text-xs text-brand-navy/50">
                                {{ $item['year'] }}
                            </span>
                        </div>
                        <h3 class="mt-6 font-display text-2xl font-bold text-brand-navy">
                            {{ $item['title'] }}
                        </h3>
                        <p class="mt-4 leading-relaxed text-brand-navy/70">
                            {{ $item['description'] }}
                        </p>

                        <div class="mt-10 grid grid-cols-2 gap-6 border-t border-brand-navy/10 pt-8 sm:grid-cols-3">
                            @foreach ($item['metrics'] as $metric)
                                <div>
                                    <p class="font-display text-3xl font-bold text-brand-accent-dark">
                                        {{ $metric['value'] }}
                                    </p>
                                    <p class="mt-1 text-xs text-brand-navy/50">
                                        {{ $metric['label'] }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
