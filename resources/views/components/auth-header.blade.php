@props([
    'title',
    'description',
    'eyebrow' => null,
])

<div class="flex w-full flex-col">
    @if ($eyebrow)
        <span class="mb-3 font-mono text-[10px] font-medium tracking-[0.2em] text-brand-accent-dark uppercase">
            {{ $eyebrow }}
        </span>
    @endif
    <flux:heading size="xl" class="font-display!">{{ $title }}</flux:heading>
    <flux:subheading class="mt-2">{{ $description }}</flux:subheading>
</div>
