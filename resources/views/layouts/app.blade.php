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
                <a href="{{ route('dashboard') }}" wire:navigate class="flex h-10 min-w-0 flex-1 items-center gap-2 px-2">
                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="{{ config('app.name') }}"
                        class="size-6 shrink-0 rounded-sm border border-brand-navy bg-brand-snow object-contain p-0.5"
                    >
                    <span class="min-w-0 truncate text-sm font-medium text-white">{{ config('app.name') }}</span>
                </a>
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    Dashboard
                </flux:sidebar.item>

                <flux:sidebar.group heading="Content Management" class="grid">
                    <flux:sidebar.item icon="newspaper" :href="route('content-management.blogs')" :current="request()->routeIs('content-management.blogs')" wire:navigate>
                        Blogs
                    </flux:sidebar.item>
                </flux:sidebar.group>

                @role('admin')
                    <flux:sidebar.group heading="Admin" class="grid">
                        <flux:sidebar.item icon="users" :href="route('admin.users')" :current="request()->routeIs('admin.users')" wire:navigate>
                            Users
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="clock" :href="route('admin.activity')" :current="request()->routeIs('admin.activity')" wire:navigate>
                            Activity log
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="map" :href="route('admin.sitemap')" :current="request()->routeIs('admin.sitemap')" wire:navigate>
                            Sitemap
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="cog-6-tooth" :href="route('admin.settings')" :current="request()->routeIs('admin.settings')" wire:navigate>
                            Settings
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @endrole
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="folder-git-2" href="https://github.com/Recodex-ID/rewire" target="_blank">
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
        @php
            $breadcrumbGroup = match (true) {
                str_starts_with(request()->route()?->getName() ?? '', 'admin.') => 'Admin',
                str_starts_with(request()->route()?->getName() ?? '', 'content-management.') => 'Content Management',
                default => null,
            };
        @endphp
        <flux:header sticky class="hidden border-b border-zinc-200 bg-white lg:flex">
            <div>
                <flux:breadcrumbs>
                    @unless (request()->routeIs('dashboard'))
                        <flux:breadcrumbs.item icon="home" :href="route('dashboard')" wire:navigate />
                    @endunless
                    @if ($breadcrumbGroup)
                        <flux:breadcrumbs.item>{{ $breadcrumbGroup }}</flux:breadcrumbs.item>
                    @endif
                    <flux:breadcrumbs.item>{{ $title ?? 'Dashboard' }}</flux:breadcrumbs.item>
                </flux:breadcrumbs>
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
