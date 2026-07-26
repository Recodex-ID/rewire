<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-brand-snow antialiased">
        <div class="flex min-h-screen flex-col lg:flex-row">
            {{-- Branding panel --}}
            <div class="relative hidden flex-col justify-between overflow-hidden bg-brand-navy p-12 lg:flex lg:w-1/2 xl:p-16">
                <div class="landing-grid-bg-dark absolute inset-0 opacity-50"></div>
                <div class="absolute top-0 right-0 size-96 rounded-full bg-brand-accent/10 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 size-96 rounded-full bg-brand-accent/5 blur-3xl"></div>

                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                    <div class="relative size-[420px]">
                        <div class="landing-animate-spin-slow absolute inset-0 rounded-full border border-brand-accent/15">
                            <div class="absolute top-0 left-1/2 size-3 -translate-x-1/2 -translate-y-1/2 rounded-full bg-brand-accent shadow-[0_0_60px_rgba(77,163,255,0.4)]"></div>
                        </div>
                        <div class="landing-animate-spin-reverse absolute inset-[50px] rounded-full border border-brand-snow/10">
                            <div class="absolute top-0 left-1/2 size-2.5 -translate-x-1/2 -translate-y-1/2 rounded-full bg-brand-snow"></div>
                            <div class="absolute bottom-0 left-1/2 size-2 -translate-x-1/2 translate-y-1/2 rounded-full bg-brand-accent/60"></div>
                        </div>
                        <div class="absolute inset-[100px] rounded-full border border-brand-snow/15"></div>

                        <div class="absolute top-1/2 left-1/2 flex size-28 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-3xl border border-brand-snow/10 bg-brand-navy-light shadow-2xl backdrop-blur-sm">
                            <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-brand-accent/20 to-transparent"></div>
                            <x-landing.icon name="check" class="relative size-9 text-brand-accent" />
                        </div>
                    </div>
                </div>

                <a href="{{ route('home') }}" class="relative z-10 flex items-center gap-3" wire:navigate>
                    <img src="{{ asset('images/logo.png') }}" alt="Rewire Starter Kit" class="size-11 rounded-xl border border-brand-navy bg-brand-snow p-2">
                    <span class="flex flex-col leading-none">
                        <span class="font-display text-lg font-bold text-brand-snow">Rewire</span>
                        <span class="mt-1 font-mono text-[10px] tracking-[0.25em] text-brand-silver/60 uppercase">Starter Kit</span>
                    </span>
                </a>

                <div class="relative z-10 max-w-md">
                    <div class="mb-8 inline-flex items-center gap-2.5 rounded-full border border-brand-snow/10 bg-brand-snow/5 px-4 py-2 backdrop-blur-sm">
                        <span class="relative flex size-2">
                            <span class="landing-animate-pulse-soft absolute inline-flex size-full rounded-full bg-brand-accent"></span>
                            <span class="relative inline-flex size-2 rounded-full bg-brand-accent"></span>
                        </span>
                        <span class="text-xs font-medium text-brand-snow">All systems operational</span>
                    </div>

                    <h1 class="mb-6 font-display text-4xl leading-[1.1] font-bold tracking-tight text-brand-snow xl:text-5xl">
                        Ship your next<br>
                        <span class="text-brand-accent">client project</span><br>
                        in days, not weeks.
                    </h1>

                    <p class="mb-8 leading-relaxed text-brand-silver/80">
                        Sign in to manage roles, content, and everything else this starter kit already wired up for you.
                    </p>

                    <div class="grid grid-cols-3 gap-6 border-t border-brand-snow/10 pt-8">
                        <div>
                            <div class="font-display text-2xl font-bold text-brand-snow">2</div>
                            <div class="mt-1 text-[10px] tracking-wider text-brand-silver/50 uppercase">Roles built in</div>
                        </div>
                        <div>
                            <div class="font-display text-2xl font-bold text-brand-snow">100%</div>
                            <div class="mt-1 text-[10px] tracking-wider text-brand-silver/50 uppercase">CMS editable</div>
                        </div>
                        <div>
                            <div class="font-display text-2xl font-bold text-brand-snow">1 day</div>
                            <div class="mt-1 text-[10px] tracking-wider text-brand-silver/50 uppercase">To first deploy</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form panel --}}
            <div class="relative flex flex-1 flex-col justify-center bg-brand-snow px-6 py-12 sm:px-12 lg:px-16 xl:px-24">
                <a href="{{ route('home') }}" class="absolute top-8 left-6 flex items-center gap-3 sm:left-12 lg:hidden" wire:navigate>
                    <img src="{{ asset('images/logo.png') }}" alt="Rewire Starter Kit" class="size-10 rounded-xl border border-brand-navy bg-brand-snow p-1.5">
                    <span class="flex flex-col leading-none">
                        <span class="font-display font-bold text-brand-navy">Rewire</span>
                        <span class="mt-1 font-mono text-[9px] tracking-[0.25em] text-brand-navy/60 uppercase">Starter Kit</span>
                    </span>
                </a>

                <div class="mx-auto mt-16 w-full max-w-md lg:mt-0">
                    {{ $slot }}
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
