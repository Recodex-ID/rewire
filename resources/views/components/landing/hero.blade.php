@if ($section?->is_visible)
    <section class="bg-white dark:bg-zinc-900">
        <div class="mx-auto max-w-5xl px-6 py-24 text-center">
            <flux:heading size="xl" class="text-4xl font-bold tracking-tight sm:text-5xl">
                {{ $section->content['heading'] }}
            </flux:heading>
            <flux:subheading class="mt-6 text-lg">
                {{ $section->content['subheading'] }}
            </flux:subheading>
            <div class="mt-10">
                <flux:button variant="primary" :href="$section->content['cta_url']">
                    {{ $section->content['cta_text'] }}
                </flux:button>
            </div>
        </div>
    </section>
@endif
