@php
    /*
     * Optional inputs (all set by the layouts, never by user input):
     *   $title            page title, appended with the site name
     *   $metaDescription  page description, falls back to the SEO setting, then a default
     *   $metaImage        absolute or root-relative URL of the social preview image
     *   $metaType         Open Graph type, "website" or "article"
     *   $publishedAt      ISO 8601 date, only for articles
     *   $noindex          true for signed-in and auth screens that must stay out of search
     */
    $siteName = config('app.name');
    $pageTitle = filled($title ?? null) ? $title.' - '.$siteName : $siteName;
    $isIndexable = ! ($noindex ?? false);

    $description = filled($metaDescription ?? null)
        ? $metaDescription
        : (\App\Models\Setting::get('seo_description') ?: 'A reusable Laravel starter kit with authentication, roles, and a blog, ready on day one.');

    $page = (int) request()->query('page', 1);
    $canonicalUrl = url()->current().($page > 1 ? '?page='.$page : '');

    $hasCustomImage = filled($metaImage ?? null);
    $imageUrl = $hasCustomImage ? url($metaImage) : asset('images/og-default.png');
@endphp

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $pageTitle }}</title>

@if ($isIndexable)
    <meta name="description" content="{{ $description }}" />
    <link rel="canonical" href="{{ $canonicalUrl }}" />

    <meta property="og:site_name" content="{{ $siteName }}" />
    <meta property="og:type" content="{{ $metaType ?? 'website' }}" />
    <meta property="og:title" content="{{ $pageTitle }}" />
    <meta property="og:description" content="{{ $description }}" />
    <meta property="og:url" content="{{ $canonicalUrl }}" />
    <meta property="og:image" content="{{ $imageUrl }}" />
    @unless ($hasCustomImage)
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
    @endunless
    <meta property="og:image:alt" content="{{ $hasCustomImage ? ($title ?? $siteName) : $siteName }}" />
    @if (filled($publishedAt ?? null))
        <meta property="article:published_time" content="{{ $publishedAt }}" />
    @endif

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $pageTitle }}" />
    <meta name="twitter:description" content="{{ $description }}" />
    <meta name="twitter:image" content="{{ $imageUrl }}" />
@else
    <meta name="robots" content="noindex, nofollow" />
@endif

<link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />
<meta name="apple-mobile-web-app-title" content="{{ $siteName }}" />
<link rel="manifest" href="{{ asset('site.webmanifest') }}" />

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])
