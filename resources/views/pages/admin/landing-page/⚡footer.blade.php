<?php

use App\Models\LandingPageSection;
use Flux\Flux;
use Livewire\Component;

new class extends Component
{
    public array $data = ['tagline' => '', 'columns' => [], 'social' => [], 'copyright_text' => '', 'is_visible' => true];

    public function mount(): void
    {
        $section = LandingPageSection::query()->where('key', 'footer')->first();

        if ($section) {
            $content = $section->content;
            $content['columns'] = array_map(
                fn (array $column) => [...$column, 'links' => implode("\n", array_map(
                    fn (array $l) => ($l['label'] ?? '').'|'.($l['url'] ?? ''),
                    $column['links'] ?? []
                ))],
                $content['columns'] ?? []
            );

            $this->data = [...$this->data, ...$content, 'is_visible' => $section->is_visible];
        }
    }

    public function addColumn(): void
    {
        $this->data['columns'][] = ['heading' => '', 'links' => ''];
    }

    public function removeColumn(int $index): void
    {
        unset($this->data['columns'][$index]);
        $this->data['columns'] = array_values($this->data['columns']);
    }

    public function addSocialLink(): void
    {
        $this->data['social'][] = ['platform' => 'linkedin', 'url' => ''];
    }

    public function removeSocialLink(int $index): void
    {
        unset($this->data['social'][$index]);
        $this->data['social'] = array_values($this->data['social']);
    }

    public function save(): void
    {
        $isVisible = (bool) ($this->data['is_visible'] ?? true);
        $content = $this->data;
        unset($content['is_visible']);

        $content['columns'] = array_map(function (array $column) {
            $column['links'] = array_values(array_filter(array_map(function (string $line) {
                [$label, $url] = array_pad(explode('|', trim($line), 2), 2, '');

                return $label === '' && $url === '' ? null : ['label' => trim($label), 'url' => trim($url)];
            }, explode("\n", $column['links'] ?? ''))));

            return $column;
        }, $content['columns']);

        LandingPageSection::query()->where('key', 'footer')->update([
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
            <flux:heading size="lg">Footer</flux:heading>
            <flux:switch wire:model="data.is_visible" label="Visible" />
        </div>

        <flux:textarea wire:model="data.tagline" label="Tagline" rows="2" />

        <div class="space-y-4">
            <flux:heading size="sm">Columns</flux:heading>
            @foreach ($data['columns'] as $index => $column)
                <div wire:key="footer-column-{{ $index }}" class="flex items-start gap-3 rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                    <div class="flex-1 space-y-3">
                        <flux:input wire:model="data.columns.{{ $index }}.heading" label="Column heading" />
                        <flux:textarea wire:model="data.columns.{{ $index }}.links" label="Links" rows="3" description="One per line, format: Label|URL" />
                    </div>
                    <flux:button type="button" variant="danger" size="sm" icon="trash" wire:click="removeColumn({{ $index }})" />
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addColumn">Add column</flux:button>
        </div>

        <div class="space-y-4">
            <flux:heading size="sm">Social links</flux:heading>
            @foreach ($data['social'] as $index => $social)
                <div wire:key="social-{{ $index }}" class="flex items-end gap-3">
                    <flux:select wire:model="data.social.{{ $index }}.platform" label="Platform" class="w-40">
                        <flux:select.option value="linkedin">LinkedIn</flux:select.option>
                        <flux:select.option value="twitter">X / Twitter</flux:select.option>
                        <flux:select.option value="github">GitHub</flux:select.option>
                    </flux:select>
                    <flux:input wire:model="data.social.{{ $index }}.url" label="URL" class="flex-1" />
                    <flux:button type="button" variant="danger" size="sm" icon="trash" wire:click="removeSocialLink({{ $index }})" />
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addSocialLink">Add social link</flux:button>
        </div>

        <flux:input wire:model="data.copyright_text" label="Copyright text" />

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:card>
