<x-layouts::main :sections="$sections" :seo-description="$seoDescription" :analytics-id="$analyticsId">
    <x-landing.hero :section="$sections['hero'] ?? null" />
    <x-landing.trusted-by :section="$sections['trusted_by'] ?? null" />
    <x-landing.services :section="$sections['services'] ?? null" />
    <x-landing.infrastructure :section="$sections['infrastructure'] ?? null" />
    <x-landing.stats :section="$sections['stats'] ?? null" />
    <x-landing.case-studies :section="$sections['case_studies'] ?? null" />
    <x-landing.process :section="$sections['process'] ?? null" />
    <x-landing.testimonials :section="$sections['testimonials'] ?? null" />
    <x-landing.cta :section="$sections['cta'] ?? null" />
</x-layouts::main>
