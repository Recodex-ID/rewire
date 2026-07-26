<?php

use App\Models\LandingPageSection;
use Flux\Flux;
use Livewire\Component;

new class extends Component
{
    public array $data = ['logo_text' => '', 'logo_subtext' => '', 'nav_items' => [], 'cta_text' => '', 'cta_url' => '', 'is_visible' => true];

    public function mount(): void
    {
        $section = LandingPageSection::query()->where('key', 'navbar')->first();

        if ($section) {
            $this->data = [...$this->data, ...$section->content, 'is_visible' => $section->is_visible];
        }
    }

    public function addNavItem(): void
    {
        $this->data['nav_items'][] = ['label' => '', 'url' => ''];
    }

    public function removeNavItem(int $index): void
    {
        unset($this->data['nav_items'][$index]);
        $this->data['nav_items'] = array_values($this->data['nav_items']);
    }

    public function save(): void
    {
        $isVisible = (bool) ($this->data['is_visible'] ?? true);
        $content = $this->data;
        unset($content['is_visible']);

        LandingPageSection::query()->where('key', 'navbar')->firstOrFail()->update([
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
            <flux:heading size="lg">Navbar</flux:heading>
            <flux:switch wire:model="data.is_visible" label="Visible" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="data.logo_text" label="Logo text" />
            <flux:input wire:model="data.logo_subtext" label="Logo subtext" />
        </div>

        <div class="space-y-4">
            <flux:heading size="sm">Nav links</flux:heading>
            @foreach ($data['nav_items'] as $index => $item)
                <div wire:key="nav-item-{{ $index }}" class="flex items-end gap-3">
                    <flux:input wire:model="data.nav_items.{{ $index }}.label" label="Label" class="flex-1" />
                    <flux:input wire:model="data.nav_items.{{ $index }}.url" label="URL" class="flex-1" />
                    <flux:button type="button" variant="danger" size="sm" icon="trash" wire:click="removeNavItem({{ $index }})" />
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addNavItem">Add link</flux:button>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="data.cta_text" label="CTA text" />
            <flux:input wire:model="data.cta_url" label="CTA URL" />
        </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:card>
