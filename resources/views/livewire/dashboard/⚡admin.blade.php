<?php

use App\Models\Post;
use App\Models\User;
use Livewire\Component;

new class extends Component
{
    public int $totalUsers = 0;

    public int $totalAdmins = 0;

    public int $publishedPosts = 0;

    public int $totalPosts = 0;

    public int $newUsersThisWeek = 0;

    /** @var array<int, array{label: string, count: int}> */
    public array $registrationsPerDay = [];

    /** @var array<int, array{type: string, icon: string, title: string, subtitle: string, at: string}> */
    public array $activity = [];

    public function mount(): void
    {
        $this->totalUsers = User::query()->count();
        $this->totalAdmins = User::query()->whereHas('roles', fn ($query) => $query->where('name', 'admin'))->count();
        $this->publishedPosts = Post::query()->where('is_published', true)->count();
        $this->totalPosts = Post::query()->count();
        $this->newUsersThisWeek = User::query()->where('created_at', '>=', now()->subDays(7))->count();

        $this->registrationsPerDay = collect(range(6, 0))
            ->map(function (int $daysAgo) {
                $date = now()->subDays($daysAgo);

                return [
                    'label' => $date->format('D'),
                    'count' => User::query()->whereDate('created_at', $date->toDateString())->count(),
                ];
            })
            ->all();

        $recentUsers = User::query()->latest()->take(5)->get()->map(fn (User $user) => [
            'type' => 'user',
            'icon' => 'user-plus',
            'title' => 'New user registered',
            'subtitle' => $user->name,
            'at' => $user->created_at,
        ]);

        $recentPosts = Post::query()->latest('updated_at')->take(5)->get()->map(fn (Post $post) => [
            'type' => 'post',
            'icon' => 'newspaper',
            'title' => 'Blog post updated',
            'subtitle' => $post->title,
            'at' => $post->updated_at,
        ]);

        $this->activity = $recentUsers->concat($recentPosts)
            ->sortByDesc('at')
            ->take(6)
            ->map(fn (array $item) => [...$item, 'at' => $item['at']->diffForHumans()])
            ->values()
            ->all();
    }
};
?>

<div class="space-y-6">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
        <flux:card class="space-y-4">
            <div class="flex size-11 items-center justify-center rounded-xl bg-indigo-500/10">
                <flux:icon icon="users" class="text-indigo-600" />
            </div>
            <div>
                <div class="font-display text-3xl font-bold tracking-tight">{{ $totalUsers }}</div>
                <div class="mt-1 text-sm text-zinc-500">Total users</div>
            </div>
        </flux:card>

        <flux:card class="space-y-4">
            <div class="flex size-11 items-center justify-center rounded-xl bg-amber-500/10">
                <flux:icon icon="shield-check" class="text-amber-600" />
            </div>
            <div>
                <div class="font-display text-3xl font-bold tracking-tight">{{ $totalAdmins }}</div>
                <div class="mt-1 text-sm text-zinc-500">Admins</div>
            </div>
        </flux:card>

        <flux:card class="space-y-4">
            <div class="flex size-11 items-center justify-center rounded-xl bg-emerald-500/10">
                <flux:icon icon="newspaper" class="text-emerald-600" />
            </div>
            <div>
                <div class="font-display text-3xl font-bold tracking-tight">{{ $publishedPosts }}<span class="text-lg text-zinc-400">/{{ $totalPosts }}</span></div>
                <div class="mt-1 text-sm text-zinc-500">Blog posts published</div>
            </div>
        </flux:card>

        <flux:card class="space-y-4">
            <div class="flex size-11 items-center justify-center rounded-xl bg-brand-accent/10">
                <flux:icon icon="arrow-trending-up" class="text-brand-accent-dark" />
            </div>
            <div>
                <div class="font-display text-3xl font-bold tracking-tight">{{ $newUsersThisWeek }}</div>
                <div class="mt-1 text-sm text-zinc-500">New users (7 days)</div>
            </div>
        </flux:card>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <flux:card class="lg:col-span-2">
            <flux:heading size="lg" class="font-display!">Registrations, last 7 days</flux:heading>
            <flux:subheading>New user sign-ups per day</flux:subheading>

            <div class="mt-8 flex h-40 items-end gap-3">
                @php $max = max(1, collect($registrationsPerDay)->max('count')); @endphp
                @foreach ($registrationsPerDay as $day)
                    <div class="flex flex-1 flex-col items-center gap-2">
                        <div class="flex h-32 w-full items-end">
                            <div
                                class="w-full rounded-t bg-brand-navy/20 {{ $day['count'] > 0 ? 'bg-brand-accent-dark!' : '' }}"
                                style="height: {{ max(4, ($day['count'] / $max) * 100) }}%"
                            ></div>
                        </div>
                        <div class="font-mono text-[10px] text-zinc-400 uppercase">{{ $day['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </flux:card>

        <flux:card class="space-y-4">
            <flux:heading size="lg" class="font-display!">Quick links</flux:heading>

            <div class="space-y-2">
                <flux:button as="a" :href="route('other.docs')" wire:navigate variant="outline" icon="book-open-text" class="w-full justify-start">
                    Documentation
                </flux:button>
                <flux:button as="a" :href="route('content-management.blogs')" wire:navigate variant="outline" icon="newspaper" class="w-full justify-start">
                    Manage blog
                </flux:button>
                <flux:button as="a" :href="route('system.sitemap')" wire:navigate variant="outline" icon="map" class="w-full justify-start">
                    View sitemap
                </flux:button>
                <flux:button as="a" :href="route('profile.edit')" wire:navigate variant="outline" icon="cog" class="w-full justify-start">
                    Account settings
                </flux:button>
            </div>
        </flux:card>
    </div>

    <flux:card>
        <div class="flex items-start justify-between gap-4">
            <div>
                <flux:heading size="lg" class="font-display!">Recent activity</flux:heading>
                <flux:subheading>Latest sign-ups and blog updates.</flux:subheading>
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
