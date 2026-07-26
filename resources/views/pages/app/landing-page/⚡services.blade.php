<?php

use App\Models\LandingPageSection;
use Flux\Flux;
use Livewire\Component;

new class extends Component
{
    public array $data = ['eyebrow' => '', 'heading' => '', 'subheading' => '', 'items' => [], 'is_visible' => true];

    public function mount(): void
    {
        $section = LandingPageSection::query()->where('key', 'services')->first();

        if ($section) {
            $content = $section->content;
            $content['items'] = array_map(
                fn (array $item) => [...$item, 'tags' => implode(', ', $item['tags'] ?? [])],
                $content['items'] ?? []
            );

            $this->data = [...$this->data, ...$content, 'is_visible' => $section->is_visible];
        }
    }

    public function addItem(): void
    {
        $this->data['items'][] = ['number' => '', 'category' => '', 'icon' => 'cloud', 'title' => '', 'description' => '', 'tags' => ''];
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

        $content['items'] = array_map(
            fn (array $item) => [...$item, 'tags' => array_values(array_filter(array_map('trim', explode(',', $item['tags'] ?? ''))))],
            $content['items']
        );

        LandingPageSection::query()->where('key', 'services')->firstOrFail()->update([
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
            <flux:heading size="lg">Services</flux:heading>
            <flux:switch wire:model="data.is_visible" label="Visible" />
        </div>

        <flux:input wire:model="data.eyebrow" label="Eyebrow" />
        <flux:input wire:model="data.heading" label="Heading" />
        <flux:textarea wire:model="data.subheading" label="Subheading" rows="2" />

        <div class="space-y-4">
            @foreach ($data['items'] as $index => $item)
                <div wire:key="service-{{ $index }}" class="space-y-3 rounded-lg border border-zinc-200 p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-1 space-y-3">
                            <div class="grid grid-cols-3 gap-3">
                                <flux:input wire:model="data.items.{{ $index }}.number" label="Number" />
                                <flux:input wire:model="data.items.{{ $index }}.category" label="Category" />
                                <flux:select wire:model="data.items.{{ $index }}.icon" label="Icon">
                                    <flux:select.option value="cloud">cloud</flux:select.option>
                                    <flux:select.option value="shield">shield</flux:select.option>
                                    <flux:select.option value="brain">brain</flux:select.option>
                                    <flux:select.option value="code">code</flux:select.option>
                                    <flux:select.option value="cog">cog</flux:select.option>
                                    <flux:select.option value="compass">compass</flux:select.option>
                                </flux:select>
                            </div>
                            <flux:input wire:model="data.items.{{ $index }}.title" label="Title" />
                            <flux:textarea wire:model="data.items.{{ $index }}.description" label="Description" rows="2" />
                            <flux:input wire:model="data.items.{{ $index }}.tags" label="Tags" description="Comma-separated, e.g. Fortify, Sessions" />
                        </div>
                        <flux:button type="button" variant="danger" size="sm" icon="trash" wire:click="removeItem({{ $index }})" />
                    </div>
                </div>
            @endforeach
        </div>
        <flux:button type="button" variant="outline" icon="plus" wire:click="addItem">Add service</flux:button>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:card>
