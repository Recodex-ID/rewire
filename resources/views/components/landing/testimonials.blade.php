@if ($section?->is_visible)
    <section class="bg-white dark:bg-zinc-900">
        <div class="mx-auto max-w-5xl px-6 py-24">
            <flux:heading size="lg" class="text-center text-3xl font-bold">
                {{ $section->content['heading'] }}
            </flux:heading>
            <div class="mt-12 grid gap-8 sm:grid-cols-2">
                @foreach ($section->content['items'] ?? [] as $item)
                    <blockquote class="rounded-xl border border-zinc-200 p-6 dark:border-zinc-700">
                        <flux:text>&ldquo;{{ $item['quote'] }}&rdquo;</flux:text>
                        <footer class="mt-4 text-sm font-medium">
                            {{ $item['name'] }}
                            @if (! empty($item['role']))
                                <span class="text-zinc-500 dark:text-zinc-400">&middot; {{ $item['role'] }}</span>
                            @endif
                        </footer>
                    </blockquote>
                @endforeach
            </div>
        </div>
    </section>
@endif
