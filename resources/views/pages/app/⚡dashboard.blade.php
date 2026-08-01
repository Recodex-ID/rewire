<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Dashboard')] class extends Component
{
};
?>

<div class="w-full space-y-6">
    <div>
        <flux:heading size="xl">Welcome back, {{ Auth::user()->name }}</flux:heading>
        <flux:subheading>{{ now()->translatedFormat('l, j F Y') }} — here's what's happening with Rewire today.</flux:subheading>
    </div>

    @role('super-admin')
        <livewire:dashboard.super-admin />
    @elserole('admin')
        <livewire:dashboard.admin />
    @else
        <livewire:dashboard.staff />
    @endrole
</div>
