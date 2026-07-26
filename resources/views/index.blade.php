<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-900">
        <x-landing.hero :section="$sections['hero'] ?? null" />
        <x-landing.features :section="$sections['features'] ?? null" />
        <x-landing.testimonials :section="$sections['testimonials'] ?? null" />
        <x-landing.cta :section="$sections['cta'] ?? null" />

        @fluxScripts
    </body>
</html>
