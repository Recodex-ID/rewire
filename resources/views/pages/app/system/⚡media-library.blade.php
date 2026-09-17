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
        return Media::query()->with('model')->latest()->paginate(24);
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

    @if ($this->media->isEmpty())
        <flux:card class="flex flex-col items-center gap-3 py-16 text-center">
            <div class="flex size-12 items-center justify-center rounded-full bg-zinc-100 text-zinc-400">
                <flux:icon icon="photo" variant="micro" />
            </div>
            <flux:text>No media files yet. Upload a featured image on a blog post to see it here.</flux:text>
        </flux:card>
    @else
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @foreach ($this->media as $item)
                <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white">
                    <div class="relative aspect-square bg-zinc-50">
                        @if (str_starts_with($item->mime_type, 'image/'))
                            <img
                                src="{{ $item->getUrl() }}"
                                alt="{{ $item->file_name }}"
                                loading="lazy"
                                class="size-full object-cover"
                            />
                        @else
                            <div class="flex size-full items-center justify-center">
                                <flux:icon icon="document" class="size-10 text-zinc-300" />
                            </div>
                        @endif

                        <flux:badge size="sm" color="zinc" class="absolute top-2 left-2">
                            {{ $item->collection_name }}
                        </flux:badge>

                        <flux:modal.trigger name="delete-media-{{ $item->id }}">
                            <flux:button
                                type="button"
                                variant="danger"
                                size="sm"
                                icon="trash"
                                class="absolute top-2 right-2"
                            />
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
                    </div>

                    <div class="space-y-1 p-3">
                        <flux:link :href="$item->getUrl()" target="_blank" class="block truncate text-sm font-medium!">
                            {{ $item->file_name }}
                        </flux:link>
                        <div class="flex items-center justify-between text-xs text-zinc-500">
                            <span class="truncate">{{ class_basename($item->model_type) }} #{{ $item->model_id }}</span>
                            <span class="shrink-0">{{ $item->human_readable_size }}</span>
                        </div>
                        <div class="text-xs text-zinc-500">{{ $item->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <flux:pagination :paginator="$this->media" />
    @endif
</div>
