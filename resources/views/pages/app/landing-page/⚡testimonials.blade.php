<?php

use App\Models\LandingPageSection;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public array $data = ['eyebrow' => '', 'heading' => '', 'items' => [], 'is_visible' => true];

    public function mount(): void
    {
        $section = LandingPageSection::query()->where('key', 'testimonials')->first();

        if ($section) {
            $content = $section->content;
            $content['items'] = array_map(
                fn (array $item) => ['quote' => '', 'name' => '', 'role' => '', 'rating' => 5, 'avatar' => '', ...$item, 'upload' => null],
                $content['items'] ?? []
            );

            $this->data = [...$this->data, ...$content, 'is_visible' => $section->is_visible];
        }
    }

    public function addItem(): void
    {
        $this->data['items'][] = ['quote' => '', 'name' => '', 'role' => '', 'rating' => 5, 'avatar' => '', 'upload' => null];
    }

    public function removeItem(int $index): void
    {
        $avatar = $this->data['items'][$index]['avatar'] ?? null;

        if ($avatar) {
            Storage::disk('public')->delete($avatar);
        }

        unset($this->data['items'][$index]);
        $this->data['items'] = array_values($this->data['items']);
    }

    public function removeAvatar(int $index): void
    {
        $avatar = $this->data['items'][$index]['avatar'] ?? null;

        if ($avatar) {
            Storage::disk('public')->delete($avatar);
        }

        $this->data['items'][$index]['avatar'] = '';
    }

    public function save(): void
    {
        $this->validate([
            'data.items.*.upload' => ['nullable', 'image', 'max:2048'],
        ]);

        $isVisible = (bool) ($this->data['is_visible'] ?? true);
        $content = $this->data;
        unset($content['is_visible']);

        $content['items'] = array_map(function (array $item) {
            if ($item['upload'] ?? null) {
                if ($item['avatar']) {
                    Storage::disk('public')->delete($item['avatar']);
                }

                $item['avatar'] = $item['upload']->store('landing/testimonials', 'public');
            }

            unset($item['upload']);

            return $item;
        }, $content['items']);

        LandingPageSection::query()->where('key', 'testimonials')->firstOrFail()->update([
            'content' => $content,
            'is_visible' => $isVisible,
        ]);

        $this->data['items'] = array_map(fn (array $item) => [...$item, 'upload' => null], $content['items']);

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
                <div wire:key="testimonial-{{ $index }}" class="flex items-start gap-3 rounded-lg border border-zinc-200 p-4">
                    <div class="flex-1 space-y-3">
                        <div class="grid grid-cols-3 gap-3">
                            <flux:input wire:model="data.items.{{ $index }}.name" label="Name" />
                            <flux:input wire:model="data.items.{{ $index }}.role" label="Role" />
                            <flux:input wire:model="data.items.{{ $index }}.rating" label="Rating (1-5)" type="number" min="1" max="5" />
                        </div>
                        <flux:textarea wire:model="data.items.{{ $index }}.quote" label="Quote" rows="2" />

                        @if ($item['avatar'] ?? null)
                            <div class="flex items-center gap-3">
                                <img src="{{ Storage::disk('public')->url($item['avatar']) }}" class="size-10 rounded-full object-cover" alt="">
                                <flux:button type="button" variant="danger" size="sm" wire:click="removeAvatar({{ $index }})">Remove photo</flux:button>
                            </div>
                        @endif
                        <flux:input type="file" wire:model="data.items.{{ $index }}.upload" label="{{ ($item['avatar'] ?? null) ? 'Replace photo' : 'Upload photo' }}" accept="image/*" />
                        @if ($item['upload'] ?? null)
                            <img src="{{ $item['upload']->temporaryUrl() }}" class="size-10 rounded-full object-cover" alt="">
                        @endif
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
