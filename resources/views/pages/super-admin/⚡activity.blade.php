<?php

use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

new #[Title('Activity log')] class extends Component
{
    use WithPagination;

    #[Computed]
    public function activities()
    {
        return Activity::query()->with('causer')->latest()->paginate(20);
    }
}; ?>

<div class="w-full space-y-6">
    <div>
        <flux:heading size="xl">Activity log</flux:heading>
        <flux:subheading>Audit trail of admin actions across the app.</flux:subheading>
    </div>

    <flux:card class="w-full">
        <flux:table :paginate="$this->activities">
            <flux:table.columns>
                <flux:table.column>Description</flux:table.column>
                <flux:table.column>By</flux:table.column>
                <flux:table.column>When</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->activities as $item)
                    <flux:table.row :key="$item->id">
                        <flux:table.cell variant="strong">{{ $item->description }}</flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">{{ $item->causer?->name ?? 'System' }}</flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">{{ $item->created_at->diffForHumans() }}</flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
