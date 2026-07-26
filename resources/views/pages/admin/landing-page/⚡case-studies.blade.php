<?php

use App\Models\LandingPageSection;
use Flux\Flux;
use Livewire\Component;

new class extends Component
{
    public array $data = ['eyebrow' => '', 'heading' => '', 'items' => [], 'is_visible' => true];

    public function mount(): void
    {
        $section = LandingPageSection::query()->where('key', 'case_studies')->first();

        if ($section) {
            $content = $section->content;
            $content['items'] = array_map(
                fn (array $item) => [...$item, 'metrics' => implode(', ', array_map(
                    fn (array $m) => ($m['value'] ?? '').':'.($m['label'] ?? ''),
                    $item['metrics'] ?? []
                ))],
                $content['items'] ?? []
            );

            $this->data = [...$this->data, ...$content, 'is_visible' => $section->is_visible];
        }
    }

    public function addItem(): void
    {
        $this->data['items'][] = ['category' => '', 'year' => '', 'title' => '', 'description' => '', 'metrics' => ''];
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

        $content['items'] = array_map(function (array $item) {
            $item['metrics'] = array_values(array_filter(array_map(function (string $pair) {
                [$value, $label] = array_pad(explode(':', trim($pair), 2), 2, '');

                return $value === '' && $label === '' ? null : ['value' => trim($value), 'label' => trim($label)];
            }, explode(',', $item['metrics'] ?? ''))));

            return $item;
        }, $content['items']);

        LandingPageSection::query()->where('key', 'case_studies')->update([
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
            <flux:heading size="lg">Case studies</flux:heading>
            <flux:switch wire:model="data.is_visible" label="Visible" />
        </div>

        <flux:input wire:model="data.eyebrow" label="Eyebrow" />
        <flux:input wire:model="data.heading" label="Heading" />

        <div class="space-y-4">
            @foreach ($data['items'] as $index => $item)
                <div wire:key="case-study-{{ $index }}" class="space-y-3 rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                    <div class="flex items-start gap-3">
                        <div class="flex-1 space-y-3">
                            <div class="grid grid-cols-2 gap-3">
                                <flux:input wire:model="data.items.{{ $index }}.category" label="Category" />
                                <flux:input wire:model="data.items.{{ $index }}.year" label="Year" />
                            </div>
                            <flux:input wire:model="data.items.{{ $index }}.title" label="Title" />
                            <flux:textarea wire:model="data.items.{{ $index }}.description" label="Description" rows="2" />
                            <flux:input wire:model="data.items.{{ $index }}.metrics" label="Metrics" description="Format: value:label, value:label — e.g. 73%:Latency Cut, 8M:Active Users" />
                        </div>
                        <flux:button type="button" variant="danger" size="sm" icon="trash" wire:click="removeItem({{ $index }})" />
                    </div>
                </div>
            @endforeach
        </div>
        <flux:button type="button" variant="outline" icon="plus" wire:click="addItem">Add case study</flux:button>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:card>
