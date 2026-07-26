<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Landing page')] class extends Component
{
    public string $activeTab = 'hero';

    /** @var array<string, string> */
    private const SECTION_LABELS = [
        'hero' => 'Hero',
        'trusted-by' => 'Trusted by',
        'services' => 'Services',
        'infrastructure' => 'Infrastructure',
        'stats' => 'Stats',
        'case-studies' => 'Case studies',
        'process' => 'Process',
        'testimonials' => 'Testimonials',
        'cta' => 'Call to action',
    ];

    /**
     * @return array<string, string>
     */
    public function sectionLabels(): array
    {
        return self::SECTION_LABELS;
    }
};
?>

<div class="w-full space-y-6">
    <div>
        <flux:heading size="xl">Landing page content</flux:heading>
        <flux:subheading>Everything below is rendered on the public landing page.</flux:subheading>
    </div>

    <div class="flex flex-nowrap gap-2 overflow-x-auto pb-2">
        @foreach ($this->sectionLabels() as $key => $label)
            <flux:button
                size="sm"
                variant="{{ $activeTab === $key ? 'primary' : 'outline' }}"
                class="shrink-0"
                wire:click="$set('activeTab', '{{ $key }}')"
            >
                {{ $label }}
            </flux:button>
        @endforeach
    </div>

    @if ($activeTab === 'hero')
        <livewire:pages::app.landing-page.hero key="landing-panel-hero" />
    @elseif ($activeTab === 'trusted-by')
        <livewire:pages::app.landing-page.trusted-by key="landing-panel-trusted-by" />
    @elseif ($activeTab === 'services')
        <livewire:pages::app.landing-page.services key="landing-panel-services" />
    @elseif ($activeTab === 'infrastructure')
        <livewire:pages::app.landing-page.infrastructure key="landing-panel-infrastructure" />
    @elseif ($activeTab === 'stats')
        <livewire:pages::app.landing-page.stats key="landing-panel-stats" />
    @elseif ($activeTab === 'case-studies')
        <livewire:pages::app.landing-page.case-studies key="landing-panel-case-studies" />
    @elseif ($activeTab === 'process')
        <livewire:pages::app.landing-page.process key="landing-panel-process" />
    @elseif ($activeTab === 'testimonials')
        <livewire:pages::app.landing-page.testimonials key="landing-panel-testimonials" />
    @elseif ($activeTab === 'cta')
        <livewire:pages::app.landing-page.cta key="landing-panel-cta" />
    @endif
</div>
