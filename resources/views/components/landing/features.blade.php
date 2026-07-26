@if ($section?->is_visible)
    <section class="bg-zinc-50 dark:bg-zinc-800">
        <div class="mx-auto max-w-5xl px-6 py-24">
            <flux:heading size="lg" class="text-center text-3xl font-bold">
                {{ $section->content['heading'] }}
            </flux:heading>
            <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($section->content['items'] ?? [] as $item)
                    <div>
                        <flux:heading size="lg">{{ $item['title'] }}</flux:heading>
                        <flux:text class="mt-2">{{ $item['description'] }}</flux:text>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
