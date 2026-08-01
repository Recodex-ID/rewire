@props([
    'label' => 'Image',
    'currentUrl' => null,
    'newUpload' => null,
    'removeAction' => null,
])

<div class="space-y-3">
    <flux:heading size="sm">{{ $label }}</flux:heading>

    @if ($currentUrl && ! $newUpload)
        <div class="flex items-center gap-4">
            <img src="{{ $currentUrl }}" class="h-20 w-32 rounded-lg object-cover" alt="">
            @if ($removeAction)
                <flux:button type="button" variant="danger" size="sm" wire:click="{{ $removeAction }}">Remove</flux:button>
            @endif
        </div>
    @endif

    <flux:input type="file" {{ $attributes }} label="{{ $currentUrl ? 'Replace image' : 'Upload image' }}" accept="image/*" />

    @if ($newUpload)
        <img src="{{ $newUpload->temporaryUrl() }}" class="h-20 w-32 rounded-lg object-cover" alt="">
    @endif
</div>
