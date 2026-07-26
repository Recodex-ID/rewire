<?php

use App\Models\LandingPageSection;
use Flux\Flux;
use Livewire\Component;

new class extends Component
{
    public array $data = ['heading' => '', 'logos' => [], 'is_visible' => true];

    public function mount(): void
    {
        $section = LandingPageSection::query()->where('key', 'trusted_by')->first();

        if ($section) {
            $this->data = [...$this->data, ...$section->content, 'is_visible' => $section->is_visible];
        }
    }

    public function addLogo(): void
    {
        $this->data['logos'][] = ['name' => ''];
    }

    public function removeLogo(int $index): void
    {
        unset($this->data['logos'][$index]);
        $this->data['logos'] = array_values($this->data['logos']);
    }

    public function save(): void
    {
        $isVisible = (bool) ($this->data['is_visible'] ?? true);
        $content = $this->data;
        unset($content['is_visible']);

        LandingPageSection::query()->where('key', 'trusted_by')->update([
            'content' => $content,
            'is_visible' => $isVisible,
        ]);

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
                    <div wire:key="logo-{{ $index }}" class="flex items-end gap-3">
                        <flux:input wire:model="data.logos.{{ $index }}.name" label="Name" class="flex-1" />
                        <flux:button type="button" variant="danger" size="sm" icon="trash" wire:click="removeLogo({{ $index }})" />
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
