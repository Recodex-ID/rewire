<?php

use App\Models\LandingPageSection;
use Flux\Flux;
use Livewire\Component;

new class extends Component
{
    public array $data = ['eyebrow' => '', 'heading_line1' => '', 'heading_highlight' => '', 'subheading' => '', 'status_label' => '', 'latency_value' => '', 'data_centers_value' => '', 'regions' => [], 'is_visible' => true];

    public function mount(): void
    {
        $section = LandingPageSection::query()->where('key', 'infrastructure')->first();

        if ($section) {
            $this->data = [...$this->data, ...$section->content, 'is_visible' => $section->is_visible];
        }
    }

    public function addRegion(): void
    {
        $this->data['regions'][] = ['name' => '', 'cities' => ''];
    }

    public function removeRegion(int $index): void
    {
        unset($this->data['regions'][$index]);
        $this->data['regions'] = array_values($this->data['regions']);
    }

    public function save(): void
    {
        $isVisible = (bool) ($this->data['is_visible'] ?? true);
        $content = $this->data;
        unset($content['is_visible']);

        LandingPageSection::query()->where('key', 'infrastructure')->update([
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
            <flux:heading size="lg">Infrastructure</flux:heading>
            <flux:switch wire:model="data.is_visible" label="Visible" />
        </div>

        <flux:input wire:model="data.eyebrow" label="Eyebrow" />
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="data.heading_line1" label="Heading line 1" />
            <flux:input wire:model="data.heading_highlight" label="Heading highlight" />
        </div>
        <flux:textarea wire:model="data.subheading" label="Subheading" rows="2" />
        <div class="grid grid-cols-3 gap-4">
            <flux:input wire:model="data.status_label" label="Status label" />
            <flux:input wire:model="data.latency_value" label="Latency (ms)" />
            <flux:input wire:model="data.data_centers_value" label="Data centers" />
        </div>

        <div class="space-y-4">
            <flux:heading size="sm">Regions</flux:heading>
            @foreach ($data['regions'] as $index => $region)
                <div wire:key="region-{{ $index }}" class="flex items-end gap-3">
                    <flux:input wire:model="data.regions.{{ $index }}.name" label="Name" class="w-40" />
                    <flux:input wire:model="data.regions.{{ $index }}.cities" label="Detail" class="flex-1" />
                    <flux:button type="button" variant="danger" size="sm" icon="trash" wire:click="removeRegion({{ $index }})" />
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addRegion">Add region</flux:button>
        </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:card>
