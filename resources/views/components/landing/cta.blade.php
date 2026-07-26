@if ($section?->is_visible)
    <section class="bg-zinc-900 dark:bg-zinc-950">
        <div class="mx-auto max-w-3xl px-6 py-24 text-center">
            <flux:heading size="lg" class="text-3xl font-bold text-white">
                {{ $section->content['heading'] }}
            </flux:heading>
            <div class="mt-8">
                <flux:button variant="primary" :href="$section->content['button_url']">
                    {{ $section->content['button_text'] }}
                </flux:button>
            </div>
        </div>
    </section>
@endif
