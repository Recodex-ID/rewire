<?php

use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

new #[Title('Media Library')] class extends Component
{
    use WithPagination;

    public function delete(int $mediaId): void
    {
        $media = Media::query()->findOrFail($mediaId);
        $media->delete();

        Flux::toast(variant: 'success', text: "\"{$media->file_name}\" was deleted.");
    }

    #[Computed]
    public function media()
    {
        return Media::query()->with('model')->latest()->paginate(15);
    }
}; ?>

<div class="w-full space-y-6">
    <div>
        <div class="flex items-center gap-3">
            <flux:heading size="xl">Media Library</flux:heading>
            <flux:badge color="zinc" size="sm">{{ $this->media->total() }} files</flux:badge>
        </div>
        <flux:subheading>Every file uploaded through Spatie Media Library, across all models.</flux:subheading>
    </div>

    <flux:card class="w-full">
        <flux:table :paginate="$this->media">
            <flux:table.columns>
                <flux:table.column>Preview</flux:table.column>
                <flux:table.column>File</flux:table.column>
                <flux:table.column>Collection</flux:table.column>
                <flux:table.column>Attached to</flux:table.column>
                <flux:table.column>Size</flux:table.column>
                <flux:table.column>Uploaded</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->media as $item)
                    <flux:table.row :key="$item->id">
                        <flux:table.cell>
                            @if (str_starts_with($item->mime_type, 'image/'))
                                <img src="{{ $item->getUrl() }}" alt="{{ $item->file_name }}" class="size-12 rounded-lg border border-zinc-200 object-cover" />
                            @else
                                <div class="flex size-12 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50">
                                    <flux:icon icon="document" variant="micro" class="text-zinc-400" />
                                </div>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell variant="strong">
                            <flux:link :href="$item->getUrl()" target="_blank">{{ $item->file_name }}</flux:link>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm" color="zinc">{{ $item->collection_name }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">
                            {{ class_basename($item->model_type) }} #{{ $item->model_id }}
                        </flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">{{ $item->human_readable_size }}</flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">{{ $item->created_at->diffForHumans() }}</flux:table.cell>
                        <flux:table.cell class="py-0">
                            <flux:modal.trigger name="delete-media-{{ $item->id }}">
                                <flux:button type="button" variant="danger" size="sm" icon="trash" />
                            </flux:modal.trigger>

                            <flux:modal name="delete-media-{{ $item->id }}" class="max-w-md" focusable>
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">Delete "{{ $item->file_name }}"?</flux:heading>
                                        <flux:subheading>This permanently removes the file from disk. This cannot be undone.</flux:subheading>
                                    </div>

                                    <div class="flex justify-end gap-2">
                                        <flux:modal.close>
                                            <flux:button variant="filled">Cancel</flux:button>
                                        </flux:modal.close>

                                        <flux:button variant="danger" wire:click="delete({{ $item->id }})">
                                            Delete
                                        </flux:button>
                                    </div>
                                </div>
                            </flux:modal>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="7">
                            <div class="flex flex-col items-center gap-3 py-8 text-center">
                                <div class="flex size-12 items-center justify-center rounded-full bg-zinc-100 text-zinc-400">
                                    <flux:icon icon="photo" variant="micro" />
                                </div>
                                <flux:text>No media files yet.</flux:text>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
