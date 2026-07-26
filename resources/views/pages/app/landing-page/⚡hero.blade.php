<?php

use App\Models\LandingPageSection;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public array $data = ['badge_text' => '', 'badge_secondary' => '', 'heading_line1' => '', 'heading_highlight' => '', 'heading_line2' => '', 'subheading' => '', 'primary_cta_text' => '', 'primary_cta_url' => '', 'secondary_cta_text' => '', 'secondary_cta_url' => '', 'background_image' => '', 'stats' => [], 'is_visible' => true];

    public $backgroundImageUpload = null;

    public function mount(): void
    {
        $section = LandingPageSection::query()->where('key', 'hero')->first();

        if ($section) {
            $this->data = [...$this->data, ...$section->content, 'is_visible' => $section->is_visible];
        }
    }

    public function removeBackgroundImage(): void
    {
        if ($this->data['background_image']) {
            Storage::disk('public')->delete($this->data['background_image']);
        }

        $this->data['background_image'] = '';
    }

    public function addStat(): void
    {
        $this->data['stats'][] = ['value' => '', 'suffix' => '', 'label' => ''];
    }

    public function removeStat(int $index): void
    {
        unset($this->data['stats'][$index]);
        $this->data['stats'] = array_values($this->data['stats']);
    }

    public function save(): void
    {
        $this->validate([
            'backgroundImageUpload' => ['nullable', 'image', 'max:2048'],
        ]);

        $isVisible = (bool) ($this->data['is_visible'] ?? true);
        $content = $this->data;
        unset($content['is_visible']);

        if ($this->backgroundImageUpload) {
            if ($content['background_image']) {
                Storage::disk('public')->delete($content['background_image']);
            }

            $content['background_image'] = $this->backgroundImageUpload->store('landing/hero', 'public');
            $this->backgroundImageUpload = null;
        }

        LandingPageSection::query()->where('key', 'hero')->update([
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
            <flux:heading size="lg">Hero</flux:heading>
            <flux:switch wire:model="data.is_visible" label="Visible" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="data.badge_text" label="Badge text" />
            <flux:input wire:model="data.badge_secondary" label="Badge secondary text" />
        </div>
        <div class="grid grid-cols-3 gap-4">
            <flux:input wire:model="data.heading_line1" label="Heading line 1" />
            <flux:input wire:model="data.heading_highlight" label="Heading highlight" />
            <flux:input wire:model="data.heading_line2" label="Heading line 2" />
        </div>
        <flux:textarea wire:model="data.subheading" label="Subheading" rows="2" />
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="data.primary_cta_text" label="Primary button text" />
            <flux:input wire:model="data.primary_cta_url" label="Primary button URL" />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="data.secondary_cta_text" label="Secondary button text" />
            <flux:input wire:model="data.secondary_cta_url" label="Secondary button URL" />
        </div>

        <div class="space-y-3">
            <flux:heading size="sm">Background image</flux:heading>
            @if ($data['background_image'])
                <div class="flex items-center gap-4">
                    <img src="{{ Storage::disk('public')->url($data['background_image']) }}" class="h-20 w-32 rounded-lg object-cover" alt="">
                    <flux:button type="button" variant="danger" size="sm" wire:click="removeBackgroundImage">Remove</flux:button>
                </div>
            @endif
            <flux:input type="file" wire:model="backgroundImageUpload" label="{{ $data['background_image'] ? 'Replace image' : 'Upload image' }}" accept="image/*" />
            @if ($backgroundImageUpload)
                <img src="{{ $backgroundImageUpload->temporaryUrl() }}" class="h-20 w-32 rounded-lg object-cover" alt="">
            @endif
        </div>

        <div class="space-y-4">
            <flux:heading size="sm">Stats</flux:heading>
            @foreach ($data['stats'] as $index => $stat)
                <div wire:key="hero-stat-{{ $index }}" class="flex items-end gap-3">
                    <flux:input wire:model="data.stats.{{ $index }}.value" label="Value" class="w-24" />
                    <flux:input wire:model="data.stats.{{ $index }}.suffix" label="Suffix" class="w-20" />
                    <flux:input wire:model="data.stats.{{ $index }}.label" label="Label" class="flex-1" />
                    <flux:button type="button" variant="danger" size="sm" icon="trash" wire:click="removeStat({{ $index }})" />
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addStat">Add stat</flux:button>
        </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:card>
