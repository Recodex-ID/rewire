<?php

use App\Models\Post;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

new #[Title('Blog')] class extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';

    public ?Post $editingPost = null;

    public string $title = '';

    public string $excerpt = '';

    public string $body = '';

    public bool $isPublished = false;

    public $featuredImageUpload = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();

        Flux::modal('post-form')->show();
    }

    public function edit(int $postId): void
    {
        $post = Post::query()->findOrFail($postId);

        $this->editingPost = $post;
        $this->title = $post->title;
        $this->excerpt = $post->excerpt ?? '';
        $this->body = $post->body;
        $this->isPublished = $post->is_published;
        $this->featuredImageUpload = null;

        Flux::modal('post-form')->show();
    }

    public function removeFeaturedImage(): void
    {
        $this->editingPost?->clearMediaCollection('featured_image');
    }

    public function save(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'featuredImageUpload' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'title' => $this->title,
            'excerpt' => $this->excerpt ?: null,
            'body' => $this->body,
            'is_published' => $this->isPublished,
        ];

        if ($this->editingPost === null) {
            $data['author_id'] = Auth::id();

            $post = Post::create($data);
        } else {
            $post = $this->editingPost;
            $post->update($data);
        }

        if ($this->featuredImageUpload) {
            $post->addMedia($this->featuredImageUpload)->toMediaCollection('featured_image');
        }

        Flux::toast(variant: 'success', text: 'Post saved.');
        Flux::modal('post-form')->close();

        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->editingPost = null;
        $this->reset('title', 'excerpt', 'body', 'isPublished', 'featuredImageUpload');
    }

    public function delete(int $postId): void
    {
        $post = Post::query()->findOrFail($postId);

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

        <flux:button variant="primary" icon="plus" wire:click="create">New post</flux:button>
    </div>

    <flux:input wire:model.live.debounce.300ms="search" placeholder="Search by title" icon="magnifying-glass" class="max-w-sm" />

    <flux:card class="w-full">
        <flux:table :paginate="$this->posts">
            <flux:table.columns>
                <flux:table.column>Image</flux:table.column>
                <flux:table.column>Title</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Author</flux:table.column>
                <flux:table.column>Updated</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->posts as $post)
                    <flux:table.row :key="$post->id">
                        <flux:table.cell class="py-2">
                            @if ($post->getFirstMediaUrl('featured_image', 'thumb'))
                                <img src="{{ $post->getFirstMediaUrl('featured_image', 'thumb') }}" alt="" class="h-10 w-16 rounded-lg object-cover">
                            @else
                                <div class="flex h-10 w-16 items-center justify-center rounded-lg bg-zinc-100 text-zinc-400">
                                    <flux:icon icon="photo" variant="micro" />
                                </div>
                            @endif
                        </flux:table.cell>
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
                                <flux:button type="button" variant="outline" size="sm" icon="pencil" wire:click="edit({{ $post->id }})" />

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

    <flux:modal flyout name="post-form" class="w-3xl" focusable>
        <form wire:submit="save" class="space-y-6">
            <flux:heading size="lg">{{ $editingPost ? 'Edit post' : 'Create post' }}</flux:heading>

            <flux:input wire:model="title" label="Title" />

            <flux:textarea wire:model="excerpt" label="Excerpt" rows="3" />

            <flux:textarea wire:model="body" label="Body" rows="10" />

            <x-media-upload
                wire:model="featuredImageUpload"
                label="Featured image"
                :current-url="$editingPost?->getFirstMediaUrl('featured_image')"
                :new-upload="$featuredImageUpload"
                remove-action="removeFeaturedImage"
            />

            <flux:switch wire:model="isPublished" label="Published" />

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="filled">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
