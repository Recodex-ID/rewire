<?php

use App\Models\Post;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Blog')] class extends Component
{
    use WithFileUploads;

    public ?Post $post = null;

    public string $title = '';

    public string $slug = '';

    public string $excerpt = '';

    public string $body = '';

    public bool $isPublished = false;

    public $featuredImageUpload = null;

    public function mount(?Post $post = null): void
    {
        $this->post = $post;

        if ($this->post) {
            $this->title = $this->post->title;
            $this->slug = $this->post->slug;
            $this->excerpt = $this->post->excerpt ?? '';
            $this->body = $this->post->body;
            $this->isPublished = $this->post->is_published;
        }
    }

    public function updatedTitle(): void
    {
        if ($this->post === null) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function removeFeaturedImage(): void
    {
        if ($this->post?->featured_image) {
            Storage::disk('public')->delete($this->post->featured_image);
            $this->post->update(['featured_image' => null]);
        }
    }

    public function save(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('posts', 'slug')->ignore($this->post?->id)],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'featuredImageUpload' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt ?: null,
            'body' => $this->body,
            'is_published' => $this->isPublished,
        ];

        if ($this->featuredImageUpload) {
            if ($this->post?->featured_image) {
                Storage::disk('public')->delete($this->post->featured_image);
            }

            $data['featured_image'] = $this->featuredImageUpload->store('blog', 'public');
        }

        if ($this->post === null) {
            $data['author_id'] = Auth::id();

            Post::create($data);
        } else {
            $this->post->update($data);
        }

        Flux::toast(variant: 'success', text: 'Post saved.');

        $this->redirectRoute('app.blog.index', navigate: true);
    }
}; ?>

<div class="w-full space-y-6">
    <flux:heading size="xl">{{ $post ? 'Edit post' : 'Create post' }}</flux:heading>

    <flux:card class="w-full space-y-6">
        <form wire:submit="save" class="space-y-6">
            <flux:input wire:model="title" label="Title" />

            <flux:input wire:model="slug" label="Slug" description="This is the post's public URL: /blog/{{ $slug ?: '...' }}" />

            <flux:textarea wire:model="excerpt" label="Excerpt" rows="3" />

            <flux:textarea wire:model="body" label="Body" rows="12" />

            <div class="space-y-3">
                <flux:heading size="sm">Featured image</flux:heading>
                @if ($post?->featured_image)
                    <div class="flex items-center gap-4">
                        <img src="{{ Storage::disk('public')->url($post->featured_image) }}" class="h-20 w-32 rounded-lg object-cover" alt="">
                        <flux:button type="button" variant="danger" size="sm" wire:click="removeFeaturedImage">Remove</flux:button>
                    </div>
                @endif
                <flux:input type="file" wire:model="featuredImageUpload" label="{{ $post?->featured_image ? 'Replace image' : 'Upload image' }}" accept="image/*" />
                @if ($featuredImageUpload)
                    <img src="{{ $featuredImageUpload->temporaryUrl() }}" class="h-20 w-32 rounded-lg object-cover" alt="">
                @endif
            </div>

            <flux:switch wire:model="isPublished" label="Published" />

            <div class="flex justify-end gap-2">
                <flux:button variant="filled" :href="route('app.blog.index')" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:card>
</div>
