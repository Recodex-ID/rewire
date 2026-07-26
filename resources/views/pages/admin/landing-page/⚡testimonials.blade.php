<?php

use App\Models\LandingPageSection;
use Flux\Flux;
use Livewire\Component;

new class extends Component
{
    public array $data = ['eyebrow' => '', 'heading' => '', 'items' => [], 'is_visible' => true];

    public function mount(): void
    {
        $section = LandingPageSection::query()->where('key', 'testimonials')->first();

        if ($section) {
            $this->data = [...$this->data, ...$section->content, 'is_visible' => $section->is_visible];
        }
    }

    public function addItem(): void
    {
        $this->data['items'][] = ['quote' => '', 'name' => '', 'role' => '', 'rating' => 5];
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

        LandingPageSection::query()->where('key', 'testimonials')->update([
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
            <flux:heading size="lg">Testimonials</flux:heading>
            <flux:switch wire:model="data.is_visible" label="Visible" />
        </div>

        <flux:input wire:model="data.eyebrow" label="Eyebrow" />
        <flux:input wire:model="data.heading" label="Heading" />

        <div class="space-y-4">
            @foreach ($data['items'] as $index => $item)
                <div wire:key="testimonial-{{ $index }}" class="flex items-start gap-3 rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                    <div class="flex-1 space-y-3">
                        <div class="grid grid-cols-3 gap-3">
                            <flux:input wire:model="data.items.{{ $index }}.name" label="Name" />
                            <flux:input wire:model="data.items.{{ $index }}.role" label="Role" />
                            <flux:input wire:model="data.items.{{ $index }}.rating" label="Rating (1-5)" type="number" min="1" max="5" />
                        </div>
                        <flux:textarea wire:model="data.items.{{ $index }}.quote" label="Quote" rows="2" />
                    </div>
                    <flux:button type="button" variant="danger" size="sm" icon="trash" wire:click="removeItem({{ $index }})" />
                </div>
            @endforeach
        </div>
        <flux:button type="button" variant="outline" icon="plus" wire:click="addItem">Add testimonial</flux:button>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:card>
