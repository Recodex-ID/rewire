<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <script>
            (function () {
                const stored = localStorage.getItem('landing-theme');
                const isDark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList.toggle('dark', isDark);
            })();
        </script>

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-brand-snow dark:bg-zinc-900">
        <x-landing.navbar :section="$sections['navbar'] ?? null" />
        <x-landing.hero :section="$sections['hero'] ?? null" />
        <x-landing.trusted-by :section="$sections['trusted_by'] ?? null" />
        <x-landing.services :section="$sections['services'] ?? null" />
        <x-landing.infrastructure :section="$sections['infrastructure'] ?? null" />
        <x-landing.stats :section="$sections['stats'] ?? null" />
        <x-landing.case-studies :section="$sections['case_studies'] ?? null" />
        <x-landing.process :section="$sections['process'] ?? null" />
        <x-landing.testimonials :section="$sections['testimonials'] ?? null" />
        <x-landing.cta :section="$sections['cta'] ?? null" />
        <x-landing.footer :section="$sections['footer'] ?? null" />

        @fluxScripts
    </body>
</html>
