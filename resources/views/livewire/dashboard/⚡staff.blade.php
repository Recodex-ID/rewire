<?php

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public int $myPublishedPosts = 0;

    public int $myTotalPosts = 0;

    public function mount(): void
    {
        $this->myTotalPosts = Post::query()->where('author_id', Auth::id())->count();
        $this->myPublishedPosts = Post::query()->where('author_id', Auth::id())->published()->count();
    }
};
?>

<flux:card class="space-y-4">
    <div class="flex size-11 items-center justify-center rounded-xl bg-violet-500/10">
        <flux:icon icon="pencil-square" class="text-violet-600" />
    </div>
    <div>
        <div class="font-display text-3xl font-bold tracking-tight">{{ $myPublishedPosts }}<span class="text-lg text-zinc-400">/{{ $myTotalPosts }}</span></div>
        <div class="mt-1 text-sm text-zinc-500">Your posts published</div>
    </div>
</flux:card>
