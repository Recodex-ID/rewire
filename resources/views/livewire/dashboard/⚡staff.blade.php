<?php

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public int $myPublishedPosts = 0;

    public int $myTotalPosts = 0;

    public int $totalPublishedPosts = 0;

    /** @var array<int, array{icon: string, title: string, subtitle: string, at: string}> */
    public array $activity = [];

    public function mount(): void
    {
        $this->myTotalPosts = Post::query()->where('author_id', Auth::id())->count();
        $this->myPublishedPosts = Post::query()->where('author_id', Auth::id())->published()->count();
        $this->totalPublishedPosts = Post::query()->published()->count();

        $this->activity = Post::query()
            ->latest('updated_at')
            ->take(6)
            ->get()
            ->map(fn (Post $post) => [
                'icon' => 'newspaper',
                'title' => 'Blog post updated',
                'subtitle' => $post->title,
                'at' => $post->updated_at->diffForHumans(),
            ])
            ->all();
    }
};
?>

<div class="space-y-6">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <flux:card class="space-y-4">
            <div class="flex size-11 items-center justify-center rounded-xl bg-violet-500/10">
                <flux:icon icon="pencil-square" class="text-violet-600" />
            </div>
            <div>
                <div class="font-display text-3xl font-bold tracking-tight">{{ $myPublishedPosts }}<span class="text-lg text-zinc-400">/{{ $myTotalPosts }}</span></div>
                <div class="mt-1 text-sm text-zinc-500">Your posts published</div>
            </div>
        </flux:card>

        <flux:card class="space-y-4">
            <div class="flex size-11 items-center justify-center rounded-xl bg-emerald-500/10">
                <flux:icon icon="newspaper" class="text-emerald-600" />
            </div>
            <div>
                <div class="font-display text-3xl font-bold tracking-tight">{{ $totalPublishedPosts }}</div>
                <div class="mt-1 text-sm text-zinc-500">Blog posts published (all authors)</div>
            </div>
        </flux:card>
    </div>

    <flux:card class="space-y-4">
        <flux:heading size="lg" class="font-display!">Quick links</flux:heading>

        <div class="space-y-2">
            <flux:button as="a" :href="route('content-management.blogs')" wire:navigate variant="outline" icon="newspaper" class="w-full justify-start">
                Manage blog
            </flux:button>
            <flux:button as="a" :href="route('other.docs')" wire:navigate variant="outline" icon="book-open-text" class="w-full justify-start">
                Documentation
            </flux:button>
            <flux:button as="a" :href="route('profile.edit')" wire:navigate variant="outline" icon="cog" class="w-full justify-start">
                Account settings
            </flux:button>
        </div>
    </flux:card>

    <flux:card>
        <div class="flex items-start justify-between gap-4">
            <div>
                <flux:heading size="lg" class="font-display!">Recent blog activity</flux:heading>
                <flux:subheading>Latest posts created or updated.</flux:subheading>
            </div>
        </div>

        <div class="mt-6 space-y-5">
            @forelse ($activity as $item)
                <div class="flex items-start gap-4">
                    <div class="flex size-8 shrink-0 items-center justify-center rounded-full bg-brand-navy/5">
                        <flux:icon :icon="$item['icon']" variant="micro" class="text-brand-navy" />
                    </div>
                    <div class="flex-1">
                        <div class="text-sm font-medium">{{ $item['title'] }}</div>
                        <div class="text-sm text-zinc-500">{{ $item['subtitle'] }}</div>
                    </div>
                    <div class="font-mono text-xs text-zinc-400">{{ $item['at'] }}</div>
                </div>
            @empty
                <div class="flex flex-col items-center gap-3 py-8 text-center">
                    <div class="flex size-12 items-center justify-center rounded-full bg-zinc-100 text-zinc-400">
                        <flux:icon icon="inbox" variant="micro" />
                    </div>
                    <flux:text>No recent activity yet.</flux:text>
                </div>
            @endforelse
        </div>
    </flux:card>
</div>
