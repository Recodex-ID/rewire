<?php

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

new class extends Component
{
    public int $totalActivityEntries = 0;

    /** @var array<int, array{icon: string, title: string, subtitle: string, at: string}> */
    public array $activity = [];

    public function mount(): void
    {
        $this->totalActivityEntries = Activity::query()->count();

        $this->activity = Activity::query()
            ->with('causer')
            ->latest()
            ->take(6)
            ->get()
            ->map(fn (Activity $log) => [
                'icon' => 'shield-check',
                'title' => $log->description,
                'subtitle' => 'by '.($log->causer?->name ?? 'System'),
                'at' => $log->created_at->diffForHumans(),
            ])
            ->all();
    }
};
?>

<div class="space-y-6">
    <flux:card class="space-y-4">
        <div class="flex size-11 items-center justify-center rounded-xl bg-sky-500/10">
            <flux:icon icon="clipboard-document-list" class="text-sky-600" />
        </div>
        <div>
            <div class="font-display text-3xl font-bold tracking-tight">{{ $totalActivityEntries }}</div>
            <div class="mt-1 text-sm text-zinc-500">Audit log entries</div>
        </div>
    </flux:card>

    <flux:card>
        <div class="flex items-start justify-between gap-4">
            <div>
                <flux:heading size="lg" class="font-display!">Recent activity</flux:heading>
                <flux:subheading>Latest actions from the admin audit log.</flux:subheading>
            </div>

            <flux:button as="a" :href="route('super-admin.activity')" wire:navigate variant="ghost" size="sm">
                View all
            </flux:button>
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
