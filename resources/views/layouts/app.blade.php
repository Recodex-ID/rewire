<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-50">
        {{-- The `dark` class here locks the sidebar to its dark styling regardless of the app-wide
             light/dark toggle -- it's always a navy surface, so its Flux components (item text,
             hover states, brand name, profile card) need to always use their dark-mode colors too,
             otherwise they render as if on a light background and become unreadable. --}}
        <flux:sidebar sticky collapsible="mobile" class="dark border-e border-brand-navy/50 bg-brand-navy">
            <flux:sidebar.header>
                <flux:sidebar.brand name="Rewire" :href="route('dashboard')" wire:navigate>
                    <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-lg bg-brand-snow">
                        <x-landing.icon name="check" class="size-4 text-brand-navy" />
                    </x-slot>
                </flux:sidebar.brand>
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    Dashboard
                </flux:sidebar.item>

                <flux:sidebar.group heading="Content Management" class="grid">
                    <flux:sidebar.item icon="newspaper" :href="route('app.blog.index')" :current="request()->routeIs('app.blog.*')" wire:navigate>
                        Blog
                    </flux:sidebar.item>
                </flux:sidebar.group>

                @role('admin')
                    <flux:sidebar.group heading="Admin" class="grid">
                        <flux:sidebar.item icon="users" :href="route('app.users.index')" :current="request()->routeIs('app.users.index')" wire:navigate>
                            Users
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="clock" :href="route('app.activity.index')" :current="request()->routeIs('app.activity.index')" wire:navigate>
                            Activity log
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="cog-6-tooth" :href="route('app.settings.edit')" :current="request()->routeIs('app.settings.edit')" wire:navigate>
                            Settings
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @endrole
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="folder-git-2" href="https://github.com/Recodex-ID/rewire.git" target="_blank">
                    Repository
                </flux:sidebar.item>

                <flux:sidebar.item icon="book-open-text" :href="route('docs')" :current="request()->routeIs('docs')" wire:navigate>
                    Documentation
                </flux:sidebar.item>
            </flux:sidebar.nav>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            Settings
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            Log out
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <!-- Desktop Topbar -->
        <flux:header sticky class="hidden border-b border-zinc-200 bg-white lg:flex">
            <div>
                <div class="font-mono text-[10px] tracking-wider text-zinc-400 uppercase">Rewire</div>
                <flux:heading size="lg" class="font-display!">{{ $title ?? 'Dashboard' }}</flux:heading>
            </div>

            <flux:spacer />

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 rounded-full border border-green-500/20 bg-green-500/10 px-3 py-1.5">
                    <span class="relative flex size-2">
                        <span class="landing-animate-pulse-soft absolute inline-flex size-full rounded-full bg-green-500"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-green-500"></span>
                    </span>
                    <span class="text-xs font-medium text-green-700">{{ app()->environment('production') ? 'Production' : ucfirst(app()->environment()) }}</span>
                </div>
            </div>
        </flux:header>

        <flux:main class="bg-zinc-50">
            {{ $slot }}
        </flux:main>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
