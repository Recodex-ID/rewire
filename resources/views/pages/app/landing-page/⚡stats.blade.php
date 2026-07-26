<?php

use App\Models\LandingPageSection;
use Flux\Flux;
use Livewire\Component;

new class extends Component
{
    public array $data = ['eyebrow' => '', 'heading_line1' => '', 'heading_highlight' => '', 'items' => [], 'is_visible' => true];

    public function mount(): void
    {
        $section = LandingPageSection::query()->where('key', 'stats')->first();

        if ($section) {
            $this->data = [...$this->data, ...$section->content, 'is_visible' => $section->is_visible];
        }
    }

    public function addItem(): void
    {
        $this->data['items'][] = ['value' => '', 'suffix' => '', 'label' => '', 'sublabel' => ''];
    }

    public function removeItem(int $index): void
    {
        unset($this->data['items'][$index]);
        $this->data['items'] = array_values($this->data['items']);
    }

    public function save(): void
    {
        $isVisible = (bool) ($this->data['is_visible'] ?? true);
        $content = $this->data;
        unset($content['is_visible']);

        LandingPageSection::query()->where('key', 'stats')->firstOrFail()->update([
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
            <flux:heading size="lg">Stats</flux:heading>
            <flux:switch wire:model="data.is_visible" label="Visible" />
        </div>

        <flux:input wire:model="data.eyebrow" label="Eyebrow" />
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="data.heading_line1" label="Heading line 1" />
            <flux:input wire:model="data.heading_highlight" label="Heading highlight" />
        </div>

        <div class="space-y-4">
            @foreach ($data['items'] as $index => $item)
                <div wire:key="stat-item-{{ $index }}" class="flex items-end gap-3">
                    <flux:input wire:model="data.items.{{ $index }}.value" label="Value" class="w-24" />
                    <flux:input wire:model="data.items.{{ $index }}.suffix" label="Suffix" class="w-20" />
                    <flux:input wire:model="data.items.{{ $index }}.label" label="Label" class="flex-1" />
                    <flux:input wire:model="data.items.{{ $index }}.sublabel" label="Sublabel" class="flex-1" />
                    <flux:button type="button" variant="danger" size="sm" icon="trash" wire:click="removeItem({{ $index }})" />
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addItem">Add stat</flux:button>
        </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:card>
