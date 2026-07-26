<?php

use App\Models\LandingPageSection;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Dashboard')] class extends Component
{
    public int $totalUsers = 0;

    public int $totalAdmins = 0;

    public int $visibleSections = 0;

    public int $totalSections = 0;

    public int $newUsersThisWeek = 0;

    /** @var array<int, array{label: string, count: int}> */
    public array $registrationsPerDay = [];

    /** @var array<int, array{type: string, icon: string, title: string, subtitle: string, at: string}> */
    public array $activity = [];

    public function mount(): void
    {
        $this->totalUsers = User::query()->count();
        $this->totalAdmins = User::query()->whereHas('roles', fn ($query) => $query->where('name', 'admin'))->count();
        $this->visibleSections = LandingPageSection::query()->where('is_visible', true)->count();
        $this->totalSections = LandingPageSection::query()->count();
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

        $recentSections = LandingPageSection::query()->latest('updated_at')->take(5)->get()->map(fn (LandingPageSection $section) => [
            'type' => 'section',
            'icon' => 'pencil-square',
            'title' => 'Landing page section updated',
            'subtitle' => Str::headline($section->key),
            'at' => $section->updated_at,
        ]);

        $this->activity = $recentUsers->concat($recentSections)
            ->sortByDesc('at')
            ->take(6)
            ->map(fn (array $item) => [...$item, 'at' => $item['at']->diffForHumans()])
            ->values()
            ->all();
    }
};
?>

<div class="w-full space-y-6">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
        <flux:card class="space-y-4">
            <div class="flex items-start justify-between">
                <div class="flex size-11 items-center justify-center rounded-xl bg-brand-navy/5">
                    <flux:icon icon="users" class="text-brand-navy" />
                </div>
            </div>
            <div>
                <div class="font-display text-3xl font-bold tracking-tight">{{ $totalUsers }}</div>
                <div class="mt-1 text-sm text-zinc-500">Total users</div>
            </div>
        </flux:card>

        <flux:card class="space-y-4">
            <div class="flex items-start justify-between">
                <div class="flex size-11 items-center justify-center rounded-xl bg-brand-navy/5">
                    <flux:icon icon="shield-check" class="text-brand-navy" />
                </div>
            </div>
            <div>
                <div class="font-display text-3xl font-bold tracking-tight">{{ $totalAdmins }}</div>
                <div class="mt-1 text-sm text-zinc-500">Admins</div>
            </div>
        </flux:card>

        <flux:card class="space-y-4">
            <div class="flex items-start justify-between">
                <div class="flex size-11 items-center justify-center rounded-xl bg-brand-navy/5">
                    <flux:icon icon="rectangle-stack" class="text-brand-navy" />
                </div>
            </div>
            <div>
                <div class="font-display text-3xl font-bold tracking-tight">{{ $visibleSections }}<span class="text-lg text-zinc-400">/{{ $totalSections }}</span></div>
                <div class="mt-1 text-sm text-zinc-500">Landing sections visible</div>
            </div>
        </flux:card>

        <flux:card class="space-y-4">
            <div class="flex items-start justify-between">
                <div class="flex size-11 items-center justify-center rounded-xl bg-brand-navy/5">
                    <flux:icon icon="arrow-trending-up" class="text-brand-navy" />
                </div>
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
                <flux:button as="a" :href="route('docs')" wire:navigate variant="outline" icon="book-open-text" class="w-full justify-start">
                    Documentation
                </flux:button>
                @role('admin')
                    <flux:button as="a" :href="route('admin.landing-page.edit')" wire:navigate variant="outline" icon="pencil-square" class="w-full justify-start">
                        Edit landing page
                    </flux:button>
                @endrole
                <flux:button as="a" :href="route('profile.edit')" wire:navigate variant="outline" icon="cog" class="w-full justify-start">
                    Account settings
                </flux:button>
            </div>
        </flux:card>
    </div>

    <flux:card>
        <div class="flex items-center justify-between">
            <flux:heading size="lg" class="font-display!">Recent activity</flux:heading>
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
                <flux:text>No recent activity yet.</flux:text>
            @endforelse
        </div>
    </flux:card>
</div>
