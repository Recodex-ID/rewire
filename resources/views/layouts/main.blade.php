@props([
    'sections' => [],
    'title' => null,
    'seoDescription' => null,
    'analyticsId' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')

        @if ($seoDescription)
            <meta name="description" content="{{ $seoDescription }}">
            <meta property="og:description" content="{{ $seoDescription }}">
        @endif

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

        {{ $slot }}

        <x-landing.footer :section="$sections['footer'] ?? null" />

        @fluxScripts
    </body>
</html>
