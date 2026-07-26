<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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

        <script>
            const revealEls = document.querySelectorAll('.landing-reveal');
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('landing-visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
            revealEls.forEach((el) => revealObserver.observe(el));

            const counters = document.querySelectorAll('.landing-counter');
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    const el = entry.target;
                    const target = parseFloat(el.dataset.target);
                    const decimals = parseInt(el.dataset.decimals || '0', 10);
                    const duration = 2000;
                    const start = performance.now();

                    function animate(now) {
                        const progress = Math.min((now - start) / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);
                        el.textContent = (target * eased).toFixed(decimals);
                        if (progress < 1) {
                            requestAnimationFrame(animate);
                        } else {
                            el.textContent = target.toFixed(decimals);
                        }
                    }
                    requestAnimationFrame(animate);
                    counterObserver.unobserve(el);
                });
            }, { threshold: 0.5 });
            counters.forEach((c) => counterObserver.observe(c));
        </script>
    </body>
</html>
