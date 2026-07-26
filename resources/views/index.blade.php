<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        @if ($seoDescription)
            <meta name="description" content="{{ $seoDescription }}">
            <meta property="og:description" content="{{ $seoDescription }}">
        @endif

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @if ($analyticsId)
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ $analyticsId }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag() { dataLayer.push(arguments); }
                gtag('js', new Date());
                gtag('config', '{{ $analyticsId }}');
            </script>
        @endif
    </head>
    <body class="min-h-screen bg-brand-snow">
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
