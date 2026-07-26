<?php

use App\Models\LandingPageSection;
use Flux\Flux;
use Livewire\Component;

new class extends Component
{
    public array $data = ['eyebrow' => '', 'heading_line1' => '', 'heading_line2' => '', 'subheading' => '', 'primary_text' => '', 'primary_url' => '', 'secondary_text' => '', 'secondary_url' => '', 'contact_label' => '', 'address_label' => '', 'address' => '', 'email' => '', 'phone' => '', 'is_visible' => true];

    public function mount(): void
    {
        $section = LandingPageSection::query()->where('key', 'cta')->first();

        if ($section) {
            $this->data = [...$this->data, ...$section->content, 'is_visible' => $section->is_visible];
        }
    }

    public function save(): void
    {
        $isVisible = (bool) ($this->data['is_visible'] ?? true);
        $content = $this->data;
        unset($content['is_visible']);

        LandingPageSection::query()->where('key', 'cta')->update([
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
            <flux:heading size="lg">Call to action</flux:heading>
            <flux:switch wire:model="data.is_visible" label="Visible" />
        </div>

        <flux:input wire:model="data.eyebrow" label="Eyebrow" />
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="data.heading_line1" label="Heading line 1" />
            <flux:input wire:model="data.heading_line2" label="Heading line 2" />
        </div>
        <flux:textarea wire:model="data.subheading" label="Subheading" rows="2" />
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="data.primary_text" label="Primary button text" />
            <flux:input wire:model="data.primary_url" label="Primary button URL" />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="data.secondary_text" label="Secondary button text" />
            <flux:input wire:model="data.secondary_url" label="Secondary button URL" />
        </div>
        <flux:input wire:model="data.contact_label" label="Contact label" />
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="data.address_label" label="Address label" />
            <flux:input wire:model="data.address" label="Address" />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="data.email" label="Email" />
            <flux:input wire:model="data.phone" label="Phone" />
        </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:card>
