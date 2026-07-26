<?php

use App\Models\Setting;
use Flux\Flux;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Settings')] class extends Component
{
    public string $seoDescription = '';

    public string $analyticsId = '';

    public function mount(): void
    {
        $this->seoDescription = Setting::get('seo_description', '') ?? '';
        $this->analyticsId = Setting::get('analytics_id', '') ?? '';
    }

    public function save(): void
    {
        $this->validate([
            'seoDescription' => ['nullable', 'string', 'max:255'],
            'analyticsId' => ['nullable', 'string', 'max:64'],
        ]);

        Setting::put('seo_description', $this->seoDescription);
        Setting::put('analytics_id', $this->analyticsId);

        Flux::toast(variant: 'success', text: 'Settings updated.');
    }
};
?>

<div class="w-full space-y-6">
    <div>
        <flux:heading size="xl">Site settings</flux:heading>
        <flux:subheading>App-wide values used across the public site.</flux:subheading>
    </div>

    <flux:card class="w-full space-y-6">
        <form wire:submit="save" class="space-y-6">
            <flux:textarea
                wire:model="seoDescription"
                label="SEO meta description"
                description="Shown in search results and social previews. Falls back to nothing if left blank."
                rows="3"
            />

            <flux:input
                wire:model="analyticsId"
                label="Google Analytics measurement ID"
                description="e.g. G-XXXXXXXXXX. Leave blank to disable tracking."
            />

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:card>
</div>
