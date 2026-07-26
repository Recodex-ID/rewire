<x-layouts::main :title="$post->title">
    <article class="pt-32 pb-24 sm:pt-40 sm:pb-32">
        <div class="mx-auto max-w-3xl px-6 lg:px-8">
            <a href="{{ route('blogs') }}" class="landing-reveal text-sm font-medium text-brand-accent-dark hover:text-brand-navy">
                &larr; Back to blog
            </a>

            <h1 class="landing-reveal mt-6 font-display text-4xl font-bold tracking-tight text-brand-navy sm:text-5xl">
                {{ $post->title }}
            </h1>

            <div class="landing-reveal mt-6 flex items-center gap-2 text-sm text-brand-navy/50">
                <span>{{ $post->author?->name ?? config('app.name') }}</span>
                <span>&middot;</span>
                <span>{{ $post->created_at->format('M j, Y') }}</span>
            </div>

            @if ($post->featured_image)
                <img
                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image) }}"
                    alt="{{ $post->title }}"
                    class="landing-reveal mt-10 w-full rounded-3xl object-cover"
                >
            @endif

            <div class="landing-reveal mt-10 max-w-none whitespace-pre-line text-lg leading-relaxed text-brand-navy/80">{{ $post->body }}</div>
        </div>
    </article>
</x-layouts::main>
