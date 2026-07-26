<x-layouts::main :sections="$sections" title="Blog">
    <section class="landing-grid-bg relative overflow-hidden bg-brand-navy pt-32 pb-20 sm:pt-40 sm:pb-24">
        <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
            <div class="landing-reveal max-w-2xl">
                <p class="font-mono text-sm uppercase tracking-widest text-brand-accent">Blog</p>
                <h1 class="mt-4 font-display text-4xl font-bold tracking-tight text-brand-snow sm:text-5xl">
                    Insights &amp; updates
                </h1>
                <p class="mt-4 text-lg leading-relaxed text-brand-silver/80">
                    News, guides, and updates from the {{ config('app.name') }} team.
                </p>
            </div>
        </div>
    </section>

    <section class="bg-brand-snow py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            @if ($posts->isEmpty())
                <p class="text-brand-navy/60">No posts published yet.</p>
            @else
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <a
                            href="{{ route('blog.show', $post->slug) }}"
                            class="landing-reveal landing-card-hover landing-reveal-delay-{{ min($loop->iteration, 4) }} flex flex-col overflow-hidden rounded-3xl border border-brand-navy/10 bg-brand-snow"
                        >
                            @if ($post->featured_image)
                                <img
                                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image) }}"
                                    alt="{{ $post->title }}"
                                    class="h-48 w-full object-cover"
                                >
                            @else
                                <div class="h-48 w-full bg-brand-navy"></div>
                            @endif

                            <div class="flex flex-1 flex-col p-8">
                                <h2 class="font-display text-xl font-bold text-brand-navy">{{ $post->title }}</h2>
                                @if ($post->excerpt)
                                    <p class="mt-3 flex-1 text-sm leading-relaxed text-brand-navy/70">{{ $post->excerpt }}</p>
                                @endif
                                <div class="mt-6 flex items-center gap-2 text-xs text-brand-navy/50">
                                    <span>{{ $post->author?->name ?? config('app.name') }}</span>
                                    <span>&middot;</span>
                                    <span>{{ $post->created_at->format('M j, Y') }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-16">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>
</x-layouts::main>
