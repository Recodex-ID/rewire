@props([
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
        <x-landing.navbar />

        {{ $slot }}

        <x-landing.footer />

        @fluxScripts
    </body>
</html>
