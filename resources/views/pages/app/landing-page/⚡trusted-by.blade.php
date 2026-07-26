<?php

use App\Models\LandingPageSection;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public array $data = ['heading' => '', 'logos' => [], 'is_visible' => true];

    public function mount(): void
    {
        $section = LandingPageSection::query()->where('key', 'trusted_by')->first();

        if ($section) {
            $content = $section->content;
            $content['logos'] = array_map(
                fn (array $logo) => ['name' => '', 'image' => '', ...$logo, 'upload' => null],
                $content['logos'] ?? []
            );

            $this->data = [...$this->data, ...$content, 'is_visible' => $section->is_visible];
        }
    }

    public function addLogo(): void
    {
        $this->data['logos'][] = ['name' => '', 'image' => '', 'upload' => null];
    }

    public function removeLogo(int $index): void
    {
        $image = $this->data['logos'][$index]['image'] ?? null;

        if ($image) {
            Storage::disk('public')->delete($image);
        }

        unset($this->data['logos'][$index]);
        $this->data['logos'] = array_values($this->data['logos']);
    }

    public function removeLogoImage(int $index): void
    {
        $image = $this->data['logos'][$index]['image'] ?? null;

        if ($image) {
            Storage::disk('public')->delete($image);
        }

        $this->data['logos'][$index]['image'] = '';
    }

    public function save(): void
    {
        $this->validate([
            'data.logos.*.upload' => ['nullable', 'image', 'max:2048'],
        ]);

        $isVisible = (bool) ($this->data['is_visible'] ?? true);
        $content = $this->data;
        unset($content['is_visible']);

        $content['logos'] = array_map(function (array $logo) {
            if ($logo['upload'] ?? null) {
                if ($logo['image']) {
                    Storage::disk('public')->delete($logo['image']);
                }

                $logo['image'] = $logo['upload']->store('landing/trusted-by', 'public');
            }

            unset($logo['upload']);

            return $logo;
        }, $content['logos']);

        LandingPageSection::query()->where('key', 'trusted_by')->update([
            'content' => $content,
            'is_visible' => $isVisible,
        ]);

        $this->data['logos'] = array_map(fn (array $logo) => [...$logo, 'upload' => null], $content['logos']);

        Flux::toast(variant: 'success', text: 'Section updated.');
    }
};
?>

<flux:card class="w-full space-y-6">
    <form wire:submit="save" class="space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="lg">Trusted by</flux:heading>
            <flux:switch wire:model="data.is_visible" label="Visible" />
        </div>

        <flux:input wire:model="data.heading" label="Heading" />

        <div class="space-y-4">
            <flux:heading size="sm">Logos</flux:heading>
            <div class="grid grid-cols-2 gap-3">
                @foreach ($data['logos'] as $index => $logo)
                    <div wire:key="logo-{{ $index }}" class="space-y-3 rounded-lg border border-zinc-200 p-4">
                        <div class="flex items-end gap-3">
                            <flux:input wire:model="data.logos.{{ $index }}.name" label="Name" class="flex-1" />
                            <flux:button type="button" variant="danger" size="sm" icon="trash" wire:click="removeLogo({{ $index }})" />
                        </div>

                        @if ($logo['image'])
                            <div class="flex items-center gap-3">
                                <img src="{{ Storage::disk('public')->url($logo['image']) }}" class="h-10 w-10 rounded object-contain" alt="">
                                <flux:button type="button" variant="danger" size="sm" wire:click="removeLogoImage({{ $index }})">Remove image</flux:button>
                            </div>
                        @endif
                        <flux:input type="file" wire:model="data.logos.{{ $index }}.upload" label="{{ $logo['image'] ? 'Replace image' : 'Upload image' }}" accept="image/*" />
                        @if ($logo['upload'] ?? null)
                            <img src="{{ $logo['upload']->temporaryUrl() }}" class="h-10 w-10 rounded object-contain" alt="">
                        @endif
                    </div>
                @endforeach
            </div>
            <flux:button type="button" variant="outline" icon="plus" wire:click="addLogo">Add logo</flux:button>
        </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:card>
