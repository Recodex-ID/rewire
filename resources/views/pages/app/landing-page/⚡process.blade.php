<?php

use App\Models\LandingPageSection;
use Flux\Flux;
use Livewire\Component;

new class extends Component
{
    public array $data = ['eyebrow' => '', 'heading' => '', 'subheading' => '', 'stats' => [], 'steps' => [], 'is_visible' => true];

    public function mount(): void
    {
        $section = LandingPageSection::query()->where('key', 'process')->first();

        if ($section) {
            $this->data = [...$this->data, ...$section->content, 'is_visible' => $section->is_visible];
        }
    }

    public function addStat(): void
    {
        $this->data['stats'][] = ['value' => '', 'label' => ''];
    }

    public function removeStat(int $index): void
    {
        unset($this->data['stats'][$index]);
        $this->data['stats'] = array_values($this->data['stats']);
    }

    public function addStep(): void
    {
        $this->data['steps'][] = ['number' => '', 'title' => '', 'description' => '', 'duration' => ''];
    }

    public function removeStep(int $index): void
    {
        unset($this->data['steps'][$index]);
        $this->data['steps'] = array_values($this->data['steps']);
    }

    public function save(): void
    {
        $isVisible = (bool) ($this->data['is_visible'] ?? true);
        $content = $this->data;
        unset($content['is_visible']);

        LandingPageSection::query()->where('key', 'process')->firstOrFail()->update([
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
            <flux:heading size="lg">Process</flux:heading>
            <flux:switch wire:model="data.is_visible" label="Visible" />
        </div>

        <flux:input wire:model="data.eyebrow" label="Eyebrow" />
        <flux:input wire:model="data.heading" label="Heading" />
        <flux:textarea wire:model="data.subheading" label="Subheading" rows="2" />

        <div class="space-y-4">
            <flux:heading size="sm">Supporting stats</flux:heading>
            @foreach ($data['stats'] as $index => $stat)
                <div wire:key="process-stat-{{ $index }}" class="flex items-end gap-3">
                    <flux:input wire:model="data.stats.{{ $index }}.value" label="Value" class="w-24" />
                    <flux:input wire:model="data.stats.{{ $index }}.label" label="Label" class="flex-1" />
                    <flux:button type="button" variant="danger" size="sm" icon="trash" wire:click="removeStat({{ $index }})" />
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addStat">Add stat</flux:button>
        </div>

        <div class="space-y-4">
            <flux:heading size="sm">Steps</flux:heading>
            @foreach ($data['steps'] as $index => $step)
                <div wire:key="process-step-{{ $index }}" class="space-y-3 rounded-lg border border-zinc-200 p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-1 space-y-3">
                            <div class="grid grid-cols-3 gap-3">
                                <flux:input wire:model="data.steps.{{ $index }}.number" label="Number" />
                                <flux:input wire:model="data.steps.{{ $index }}.title" label="Title" class="col-span-2" />
                            </div>
                            <flux:textarea wire:model="data.steps.{{ $index }}.description" label="Description" rows="2" />
                            <flux:input wire:model="data.steps.{{ $index }}.duration" label="Duration" />
                        </div>
                        <flux:button type="button" variant="danger" size="sm" icon="trash" wire:click="removeStep({{ $index }})" />
                    </div>
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addStep">Add step</flux:button>
        </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:card>
