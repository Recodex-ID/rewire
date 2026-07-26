<?php

use App\Models\Post;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

new #[Title('Blog')] class extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $postId): void
    {
        $post = Post::query()->findOrFail($postId);

        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $title = $post->title;

        $post->delete();

        Flux::toast(variant: 'success', text: "\"{$title}\" was deleted.");
    }

    #[Computed]
    public function posts()
    {
        return Post::query()
            ->when($this->search, fn ($query) => $query->where('title', 'like', "%{$this->search}%"))
            ->with('author')
            ->latest()
            ->paginate(10);
    }
}; ?>

<div class="w-full space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <flux:heading size="xl">Blog posts</flux:heading>
            <flux:subheading>Manage published and draft blog posts.</flux:subheading>
        </div>

        <flux:button variant="primary" icon="plus" :href="route('app.blog.create')" wire:navigate>New post</flux:button>
    </div>

    <flux:input wire:model.live.debounce.300ms="search" placeholder="Search by title" icon="magnifying-glass" class="max-w-sm" />

    <flux:card class="w-full">
        <flux:table :paginate="$this->posts">
            <flux:table.columns>
                <flux:table.column>Title</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Author</flux:table.column>
                <flux:table.column>Updated</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->posts as $post)
                    <flux:table.row :key="$post->id">
                        <flux:table.cell variant="strong">{{ $post->title }}</flux:table.cell>
                        <flux:table.cell>
                            @if ($post->is_published)
                                <flux:badge color="lime" size="sm">Published</flux:badge>
                            @else
                                <flux:badge color="zinc" size="sm">Draft</flux:badge>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">{{ $post->author?->name ?? '—' }}</flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">{{ $post->updated_at->diffForHumans() }}</flux:table.cell>
                        <flux:table.cell class="py-0">
                            <div class="flex items-center gap-2">
                                <flux:button variant="outline" size="sm" icon="pencil" :href="route('app.blog.edit', $post)" wire:navigate />

                                <flux:modal.trigger name="delete-post-{{ $post->id }}">
                                    <flux:button type="button" variant="danger" size="sm" icon="trash" />
                                </flux:modal.trigger>

                                <flux:modal name="delete-post-{{ $post->id }}" class="max-w-md" focusable>
                                    <div class="space-y-6">
                                        <div>
                                            <flux:heading size="lg">Delete "{{ $post->title }}"?</flux:heading>
                                            <flux:subheading>This permanently removes the post. This cannot be undone.</flux:subheading>
                                        </div>

                                        <div class="flex justify-end gap-2">
                                            <flux:modal.close>
                                                <flux:button variant="filled">Cancel</flux:button>
                                            </flux:modal.close>

                                            <flux:button variant="danger" wire:click="delete({{ $post->id }})">
                                                Delete
                                            </flux:button>
                                        </div>
                                    </div>
                                </flux:modal>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
