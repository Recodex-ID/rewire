<?php

use App\Models\User;
use Livewire\Component;

new class extends Component
{
    public int $totalAdmins = 0;

    public function mount(): void
    {
        $this->totalAdmins = User::query()->whereHas('roles', fn ($query) => $query->where('name', 'admin'))->count();
    }
};
?>

<flux:card class="space-y-4">
    <div class="flex size-11 items-center justify-center rounded-xl bg-amber-500/10">
        <flux:icon icon="shield-check" class="text-amber-600" />
    </div>
    <div>
        <div class="font-display text-3xl font-bold tracking-tight">{{ $totalAdmins }}</div>
        <div class="mt-1 text-sm text-zinc-500">Admins</div>
    </div>
</flux:card>
