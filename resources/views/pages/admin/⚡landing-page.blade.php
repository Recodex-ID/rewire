<?php

use App\Models\LandingPageSection;
use Flux\Flux;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Landing page')] class extends Component
{
    public array $navbar = ['logo_text' => '', 'logo_subtext' => '', 'nav_items' => [], 'cta_text' => '', 'cta_url' => '', 'is_visible' => true];

    public array $hero = ['badge_text' => '', 'badge_secondary' => '', 'heading_line1' => '', 'heading_highlight' => '', 'heading_line2' => '', 'subheading' => '', 'primary_cta_text' => '', 'primary_cta_url' => '', 'secondary_cta_text' => '', 'secondary_cta_url' => '', 'stats' => [], 'is_visible' => true];

    public array $trustedBy = ['heading' => '', 'logos' => [], 'is_visible' => true];

    public array $services = ['eyebrow' => '', 'heading' => '', 'subheading' => '', 'items' => [], 'is_visible' => true];

    public array $infrastructure = ['eyebrow' => '', 'heading_line1' => '', 'heading_highlight' => '', 'subheading' => '', 'status_label' => '', 'latency_value' => '', 'data_centers_value' => '', 'regions' => [], 'is_visible' => true];

    public array $stats = ['eyebrow' => '', 'heading_line1' => '', 'heading_highlight' => '', 'items' => [], 'is_visible' => true];

    public array $caseStudies = ['eyebrow' => '', 'heading' => '', 'items' => [], 'is_visible' => true];

    public array $process = ['eyebrow' => '', 'heading' => '', 'subheading' => '', 'stats' => [], 'steps' => [], 'is_visible' => true];

    public array $testimonials = ['eyebrow' => '', 'heading' => '', 'items' => [], 'is_visible' => true];

    public array $cta = ['eyebrow' => '', 'heading_line1' => '', 'heading_line2' => '', 'subheading' => '', 'primary_text' => '', 'primary_url' => '', 'secondary_text' => '', 'secondary_url' => '', 'contact_label' => '', 'address_label' => '', 'address' => '', 'email' => '', 'phone' => '', 'is_visible' => true];

    public array $footer = ['tagline' => '', 'columns' => [], 'social' => [], 'copyright_text' => '', 'is_visible' => true];

    /** @var array<string, string> */
    private const SECTION_PROPERTY = [
        'navbar' => 'navbar',
        'hero' => 'hero',
        'trusted_by' => 'trustedBy',
        'services' => 'services',
        'infrastructure' => 'infrastructure',
        'stats' => 'stats',
        'case_studies' => 'caseStudies',
        'process' => 'process',
        'testimonials' => 'testimonials',
        'cta' => 'cta',
        'footer' => 'footer',
    ];

    public function mount(): void
    {
        foreach (self::SECTION_PROPERTY as $key => $property) {
            $section = LandingPageSection::query()->where('key', $key)->first();

            if (! $section) {
                continue;
            }

            $content = match ($key) {
                'services' => $this->encodeNested($section->content, 'items', 'tags', fn (array $tags) => implode(', ', $tags)),
                'case_studies' => $this->encodeNested($section->content, 'items', 'metrics', fn (array $metrics) => implode(', ', array_map(
                    fn (array $m) => ($m['value'] ?? '').':'.($m['label'] ?? ''),
                    $metrics
                ))),
                'footer' => $this->encodeNested($section->content, 'columns', 'links', fn (array $links) => implode("\n", array_map(
                    fn (array $l) => ($l['label'] ?? '').'|'.($l['url'] ?? ''),
                    $links
                ))),
                default => $section->content,
            };

            $this->{$property} = [...$this->{$property}, ...$content, 'is_visible' => $section->is_visible];
        }
    }

    public function addNavItem(): void
    {
        $this->addItem('navbar', 'nav_items', ['label' => '', 'url' => '']);
    }

    public function removeNavItem(int $index): void
    {
        $this->removeItem('navbar', 'nav_items', $index);
    }

    public function addHeroStat(): void
    {
        $this->addItem('hero', 'stats', ['value' => '', 'suffix' => '', 'label' => '']);
    }

    public function removeHeroStat(int $index): void
    {
        $this->removeItem('hero', 'stats', $index);
    }

    public function addLogo(): void
    {
        $this->addItem('trustedBy', 'logos', ['name' => '']);
    }

    public function removeLogo(int $index): void
    {
        $this->removeItem('trustedBy', 'logos', $index);
    }

    public function addServiceItem(): void
    {
        $this->addItem('services', 'items', ['number' => '', 'category' => '', 'icon' => 'cloud', 'title' => '', 'description' => '', 'tags' => '']);
    }

    public function removeServiceItem(int $index): void
    {
        $this->removeItem('services', 'items', $index);
    }

    public function addRegion(): void
    {
        $this->addItem('infrastructure', 'regions', ['name' => '', 'cities' => '']);
    }

    public function removeRegion(int $index): void
    {
        $this->removeItem('infrastructure', 'regions', $index);
    }

    public function addStatItem(): void
    {
        $this->addItem('stats', 'items', ['value' => '', 'suffix' => '', 'label' => '', 'sublabel' => '']);
    }

    public function removeStatItem(int $index): void
    {
        $this->removeItem('stats', 'items', $index);
    }

    public function addCaseStudy(): void
    {
        $this->addItem('caseStudies', 'items', ['category' => '', 'year' => '', 'title' => '', 'description' => '', 'metrics' => '']);
    }

    public function removeCaseStudy(int $index): void
    {
        $this->removeItem('caseStudies', 'items', $index);
    }

    public function addProcessStat(): void
    {
        $this->addItem('process', 'stats', ['value' => '', 'label' => '']);
    }

    public function removeProcessStat(int $index): void
    {
        $this->removeItem('process', 'stats', $index);
    }

    public function addProcessStep(): void
    {
        $this->addItem('process', 'steps', ['number' => '', 'title' => '', 'description' => '', 'duration' => '']);
    }

    public function removeProcessStep(int $index): void
    {
        $this->removeItem('process', 'steps', $index);
    }

    public function addTestimonial(): void
    {
        $this->addItem('testimonials', 'items', ['quote' => '', 'name' => '', 'role' => '', 'rating' => 5]);
    }

    public function removeTestimonial(int $index): void
    {
        $this->removeItem('testimonials', 'items', $index);
    }

    public function addFooterColumn(): void
    {
        $this->addItem('footer', 'columns', ['heading' => '', 'links' => '']);
    }

    public function removeFooterColumn(int $index): void
    {
        $this->removeItem('footer', 'columns', $index);
    }

    public function addSocialLink(): void
    {
        $this->addItem('footer', 'social', ['platform' => 'linkedin', 'url' => '']);
    }

    public function removeSocialLink(int $index): void
    {
        $this->removeItem('footer', 'social', $index);
    }

    public function save(string $key): void
    {
        $property = self::SECTION_PROPERTY[$key] ?? null;

        abort_unless($property, 404);

        $data = $this->{$property};
        $isVisible = (bool) ($data['is_visible'] ?? true);
        unset($data['is_visible']);

        $data = match ($key) {
            'services' => $this->decodeNested($data, 'items', 'tags', fn (string $v) => $this->decodeList($v)),
            'case_studies' => $this->decodeNested($data, 'items', 'metrics', fn (string $v) => $this->decodePairs($v)),
            'footer' => $this->decodeNested($data, 'columns', 'links', fn (string $v) => $this->decodeLines($v)),
            default => $data,
        };

        LandingPageSection::query()->where('key', $key)->update([
            'content' => $data,
            'is_visible' => $isVisible,
        ]);

        Flux::toast(variant: 'success', text: __('Section updated.'));
    }

    private function addItem(string $property, string $listKey, array $template): void
    {
        $data = $this->{$property};
        $data[$listKey][] = $template;
        $this->{$property} = $data;
    }

    private function removeItem(string $property, string $listKey, int $index): void
    {
        $data = $this->{$property};
        unset($data[$listKey][$index]);
        $data[$listKey] = array_values($data[$listKey]);
        $this->{$property} = $data;
    }

    /**
     * Encode a nested list field (e.g. tags/metrics/links) into a single editable string,
     * for content read from storage into the form.
     */
    private function encodeNested(array $content, string $listKey, string $fieldKey, callable $encoder): array
    {
        $content[$listKey] = array_map(
            fn (array $item) => [...$item, $fieldKey => $encoder($item[$fieldKey] ?? [])],
            $content[$listKey] ?? []
        );

        return $content;
    }

    /**
     * Decode a nested list field back from its editable string into an array,
     * before persisting to storage.
     */
    private function decodeNested(array $data, string $listKey, string $fieldKey, callable $decoder): array
    {
        $data[$listKey] = array_map(
            fn (array $item) => [...$item, $fieldKey => $decoder($item[$fieldKey] ?? '')],
            $data[$listKey] ?? []
        );

        return $data;
    }

    /**
     * @return array<int, string>
     */
    private function decodeList(string $value): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $value))));
    }

    /**
     * @return array<int, array{value: string, label: string}>
     */
    private function decodePairs(string $value): array
    {
        return array_values(array_filter(array_map(function (string $pair) {
            [$pairValue, $label] = array_pad(explode(':', trim($pair), 2), 2, '');

            return $pairValue === '' && $label === '' ? null : ['value' => trim($pairValue), 'label' => trim($label)];
        }, explode(',', $value))));
    }

    /**
     * @return array<int, array{label: string, url: string}>
     */
    private function decodeLines(string $value): array
    {
        return array_values(array_filter(array_map(function (string $line) {
            [$label, $url] = array_pad(explode('|', trim($line), 2), 2, '');

            return $label === '' && $url === '' ? null : ['label' => trim($label), 'url' => trim($url)];
        }, explode("\n", $value))));
    }
};
?>

<div class="w-full max-w-3xl space-y-12">
    <flux:heading size="xl">{{ __('Landing page content') }}</flux:heading>
    <flux:subheading>{{ __('Everything below is rendered on the public landing page.') }}</flux:subheading>

    {{-- Navbar --}}
    <form wire:submit="save('navbar')" class="space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="lg">{{ __('Navbar') }}</flux:heading>
            <flux:switch wire:model="navbar.is_visible" :label="__('Visible')" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="navbar.logo_text" :label="__('Logo text')" />
            <flux:input wire:model="navbar.logo_subtext" :label="__('Logo subtext')" />
        </div>

        <div class="space-y-4">
            <flux:heading size="sm">{{ __('Nav links') }}</flux:heading>
            @foreach ($navbar['nav_items'] as $index => $item)
                <div wire:key="nav-item-{{ $index }}" class="flex items-end gap-3">
                    <flux:input wire:model="navbar.nav_items.{{ $index }}.label" :label="__('Label')" class="flex-1" />
                    <flux:input wire:model="navbar.nav_items.{{ $index }}.url" :label="__('URL')" class="flex-1" />
                    <flux:button type="button" variant="ghost" size="sm" icon="trash" wire:click="removeNavItem({{ $index }})" />
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addNavItem">{{ __('Add link') }}</flux:button>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="navbar.cta_text" :label="__('CTA text')" />
            <flux:input wire:model="navbar.cta_url" :label="__('CTA URL')" />
        </div>

        <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
    </form>

    <flux:separator />

    {{-- Hero --}}
    <form wire:submit="save('hero')" class="space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="lg">{{ __('Hero') }}</flux:heading>
            <flux:switch wire:model="hero.is_visible" :label="__('Visible')" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="hero.badge_text" :label="__('Badge text')" />
            <flux:input wire:model="hero.badge_secondary" :label="__('Badge secondary text')" />
        </div>
        <div class="grid grid-cols-3 gap-4">
            <flux:input wire:model="hero.heading_line1" :label="__('Heading line 1')" />
            <flux:input wire:model="hero.heading_highlight" :label="__('Heading highlight')" />
            <flux:input wire:model="hero.heading_line2" :label="__('Heading line 2')" />
        </div>
        <flux:textarea wire:model="hero.subheading" :label="__('Subheading')" rows="2" />
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="hero.primary_cta_text" :label="__('Primary button text')" />
            <flux:input wire:model="hero.primary_cta_url" :label="__('Primary button URL')" />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="hero.secondary_cta_text" :label="__('Secondary button text')" />
            <flux:input wire:model="hero.secondary_cta_url" :label="__('Secondary button URL')" />
        </div>

        <div class="space-y-4">
            <flux:heading size="sm">{{ __('Stats') }}</flux:heading>
            @foreach ($hero['stats'] as $index => $stat)
                <div wire:key="hero-stat-{{ $index }}" class="flex items-end gap-3">
                    <flux:input wire:model="hero.stats.{{ $index }}.value" :label="__('Value')" class="w-24" />
                    <flux:input wire:model="hero.stats.{{ $index }}.suffix" :label="__('Suffix')" class="w-20" />
                    <flux:input wire:model="hero.stats.{{ $index }}.label" :label="__('Label')" class="flex-1" />
                    <flux:button type="button" variant="ghost" size="sm" icon="trash" wire:click="removeHeroStat({{ $index }})" />
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addHeroStat">{{ __('Add stat') }}</flux:button>
        </div>

        <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
    </form>

    <flux:separator />

    {{-- Trusted by --}}
    <form wire:submit="save('trusted_by')" class="space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="lg">{{ __('Trusted by') }}</flux:heading>
            <flux:switch wire:model="trustedBy.is_visible" :label="__('Visible')" />
        </div>

        <flux:input wire:model="trustedBy.heading" :label="__('Heading')" />

        <div class="space-y-4">
            <flux:heading size="sm">{{ __('Logos') }}</flux:heading>
            <div class="grid grid-cols-2 gap-3">
                @foreach ($trustedBy['logos'] as $index => $logo)
                    <div wire:key="logo-{{ $index }}" class="flex items-end gap-3">
                        <flux:input wire:model="trustedBy.logos.{{ $index }}.name" :label="__('Name')" class="flex-1" />
                        <flux:button type="button" variant="ghost" size="sm" icon="trash" wire:click="removeLogo({{ $index }})" />
                    </div>
                @endforeach
            </div>
            <flux:button type="button" variant="outline" icon="plus" wire:click="addLogo">{{ __('Add logo') }}</flux:button>
        </div>

        <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
    </form>

    <flux:separator />

    {{-- Services --}}
    <form wire:submit="save('services')" class="space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="lg">{{ __('Services') }}</flux:heading>
            <flux:switch wire:model="services.is_visible" :label="__('Visible')" />
        </div>

        <flux:input wire:model="services.eyebrow" :label="__('Eyebrow')" />
        <flux:input wire:model="services.heading" :label="__('Heading')" />
        <flux:textarea wire:model="services.subheading" :label="__('Subheading')" rows="2" />

        <div class="space-y-4">
            @foreach ($services['items'] as $index => $item)
                <div wire:key="service-{{ $index }}" class="space-y-3 rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                    <div class="flex items-start gap-3">
                        <div class="flex-1 space-y-3">
                            <div class="grid grid-cols-3 gap-3">
                                <flux:input wire:model="services.items.{{ $index }}.number" :label="__('Number')" />
                                <flux:input wire:model="services.items.{{ $index }}.category" :label="__('Category')" />
                                <flux:select wire:model="services.items.{{ $index }}.icon" :label="__('Icon')">
                                    <flux:select.option value="cloud">cloud</flux:select.option>
                                    <flux:select.option value="shield">shield</flux:select.option>
                                    <flux:select.option value="brain">brain</flux:select.option>
                                    <flux:select.option value="code">code</flux:select.option>
                                    <flux:select.option value="cog">cog</flux:select.option>
                                    <flux:select.option value="compass">compass</flux:select.option>
                                </flux:select>
                            </div>
                            <flux:input wire:model="services.items.{{ $index }}.title" :label="__('Title')" />
                            <flux:textarea wire:model="services.items.{{ $index }}.description" :label="__('Description')" rows="2" />
                            <flux:input wire:model="services.items.{{ $index }}.tags" :label="__('Tags')" :description="__('Comma-separated, e.g. Fortify, Sessions')" />
                        </div>
                        <flux:button type="button" variant="ghost" size="sm" icon="trash" wire:click="removeServiceItem({{ $index }})" />
                    </div>
                </div>
            @endforeach
        </div>
        <flux:button type="button" variant="outline" icon="plus" wire:click="addServiceItem">{{ __('Add service') }}</flux:button>

        <div>
            <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
        </div>
    </form>

    <flux:separator />

    {{-- Infrastructure --}}
    <form wire:submit="save('infrastructure')" class="space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="lg">{{ __('Infrastructure') }}</flux:heading>
            <flux:switch wire:model="infrastructure.is_visible" :label="__('Visible')" />
        </div>

        <flux:input wire:model="infrastructure.eyebrow" :label="__('Eyebrow')" />
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="infrastructure.heading_line1" :label="__('Heading line 1')" />
            <flux:input wire:model="infrastructure.heading_highlight" :label="__('Heading highlight')" />
        </div>
        <flux:textarea wire:model="infrastructure.subheading" :label="__('Subheading')" rows="2" />
        <div class="grid grid-cols-3 gap-4">
            <flux:input wire:model="infrastructure.status_label" :label="__('Status label')" />
            <flux:input wire:model="infrastructure.latency_value" :label="__('Latency (ms)')" />
            <flux:input wire:model="infrastructure.data_centers_value" :label="__('Data centers')" />
        </div>

        <div class="space-y-4">
            <flux:heading size="sm">{{ __('Regions') }}</flux:heading>
            @foreach ($infrastructure['regions'] as $index => $region)
                <div wire:key="region-{{ $index }}" class="flex items-end gap-3">
                    <flux:input wire:model="infrastructure.regions.{{ $index }}.name" :label="__('Name')" class="w-40" />
                    <flux:input wire:model="infrastructure.regions.{{ $index }}.cities" :label="__('Detail')" class="flex-1" />
                    <flux:button type="button" variant="ghost" size="sm" icon="trash" wire:click="removeRegion({{ $index }})" />
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addRegion">{{ __('Add region') }}</flux:button>
        </div>

        <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
    </form>

    <flux:separator />

    {{-- Stats --}}
    <form wire:submit="save('stats')" class="space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="lg">{{ __('Stats') }}</flux:heading>
            <flux:switch wire:model="stats.is_visible" :label="__('Visible')" />
        </div>

        <flux:input wire:model="stats.eyebrow" :label="__('Eyebrow')" />
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="stats.heading_line1" :label="__('Heading line 1')" />
            <flux:input wire:model="stats.heading_highlight" :label="__('Heading highlight')" />
        </div>

        <div class="space-y-4">
            @foreach ($stats['items'] as $index => $item)
                <div wire:key="stat-item-{{ $index }}" class="flex items-end gap-3">
                    <flux:input wire:model="stats.items.{{ $index }}.value" :label="__('Value')" class="w-24" />
                    <flux:input wire:model="stats.items.{{ $index }}.suffix" :label="__('Suffix')" class="w-20" />
                    <flux:input wire:model="stats.items.{{ $index }}.label" :label="__('Label')" class="flex-1" />
                    <flux:input wire:model="stats.items.{{ $index }}.sublabel" :label="__('Sublabel')" class="flex-1" />
                    <flux:button type="button" variant="ghost" size="sm" icon="trash" wire:click="removeStatItem({{ $index }})" />
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addStatItem">{{ __('Add stat') }}</flux:button>
        </div>

        <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
    </form>

    <flux:separator />

    {{-- Case studies --}}
    <form wire:submit="save('case_studies')" class="space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="lg">{{ __('Case studies') }}</flux:heading>
            <flux:switch wire:model="caseStudies.is_visible" :label="__('Visible')" />
        </div>

        <flux:input wire:model="caseStudies.eyebrow" :label="__('Eyebrow')" />
        <flux:input wire:model="caseStudies.heading" :label="__('Heading')" />

        <div class="space-y-4">
            @foreach ($caseStudies['items'] as $index => $item)
                <div wire:key="case-study-{{ $index }}" class="space-y-3 rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                    <div class="flex items-start gap-3">
                        <div class="flex-1 space-y-3">
                            <div class="grid grid-cols-2 gap-3">
                                <flux:input wire:model="caseStudies.items.{{ $index }}.category" :label="__('Category')" />
                                <flux:input wire:model="caseStudies.items.{{ $index }}.year" :label="__('Year')" />
                            </div>
                            <flux:input wire:model="caseStudies.items.{{ $index }}.title" :label="__('Title')" />
                            <flux:textarea wire:model="caseStudies.items.{{ $index }}.description" :label="__('Description')" rows="2" />
                            <flux:input wire:model="caseStudies.items.{{ $index }}.metrics" :label="__('Metrics')" :description="__('Format: value:label, value:label — e.g. 73%:Latency Cut, 8M:Active Users')" />
                        </div>
                        <flux:button type="button" variant="ghost" size="sm" icon="trash" wire:click="removeCaseStudy({{ $index }})" />
                    </div>
                </div>
            @endforeach
        </div>
        <flux:button type="button" variant="outline" icon="plus" wire:click="addCaseStudy">{{ __('Add case study') }}</flux:button>

        <div>
            <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
        </div>
    </form>

    <flux:separator />

    {{-- Process --}}
    <form wire:submit="save('process')" class="space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="lg">{{ __('Process') }}</flux:heading>
            <flux:switch wire:model="process.is_visible" :label="__('Visible')" />
        </div>

        <flux:input wire:model="process.eyebrow" :label="__('Eyebrow')" />
        <flux:input wire:model="process.heading" :label="__('Heading')" />
        <flux:textarea wire:model="process.subheading" :label="__('Subheading')" rows="2" />

        <div class="space-y-4">
            <flux:heading size="sm">{{ __('Supporting stats') }}</flux:heading>
            @foreach ($process['stats'] as $index => $stat)
                <div wire:key="process-stat-{{ $index }}" class="flex items-end gap-3">
                    <flux:input wire:model="process.stats.{{ $index }}.value" :label="__('Value')" class="w-24" />
                    <flux:input wire:model="process.stats.{{ $index }}.label" :label="__('Label')" class="flex-1" />
                    <flux:button type="button" variant="ghost" size="sm" icon="trash" wire:click="removeProcessStat({{ $index }})" />
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addProcessStat">{{ __('Add stat') }}</flux:button>
        </div>

        <div class="space-y-4">
            <flux:heading size="sm">{{ __('Steps') }}</flux:heading>
            @foreach ($process['steps'] as $index => $step)
                <div wire:key="process-step-{{ $index }}" class="space-y-3 rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                    <div class="flex items-start gap-3">
                        <div class="flex-1 space-y-3">
                            <div class="grid grid-cols-3 gap-3">
                                <flux:input wire:model="process.steps.{{ $index }}.number" :label="__('Number')" />
                                <flux:input wire:model="process.steps.{{ $index }}.title" :label="__('Title')" class="col-span-2" />
                            </div>
                            <flux:textarea wire:model="process.steps.{{ $index }}.description" :label="__('Description')" rows="2" />
                            <flux:input wire:model="process.steps.{{ $index }}.duration" :label="__('Duration')" />
                        </div>
                        <flux:button type="button" variant="ghost" size="sm" icon="trash" wire:click="removeProcessStep({{ $index }})" />
                    </div>
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addProcessStep">{{ __('Add step') }}</flux:button>
        </div>

        <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
    </form>

    <flux:separator />

    {{-- Testimonials --}}
    <form wire:submit="save('testimonials')" class="space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="lg">{{ __('Testimonials') }}</flux:heading>
            <flux:switch wire:model="testimonials.is_visible" :label="__('Visible')" />
        </div>

        <flux:input wire:model="testimonials.eyebrow" :label="__('Eyebrow')" />
        <flux:input wire:model="testimonials.heading" :label="__('Heading')" />

        <div class="space-y-4">
            @foreach ($testimonials['items'] as $index => $item)
                <div wire:key="testimonial-{{ $index }}" class="flex items-start gap-3 rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                    <div class="flex-1 space-y-3">
                        <div class="grid grid-cols-3 gap-3">
                            <flux:input wire:model="testimonials.items.{{ $index }}.name" :label="__('Name')" />
                            <flux:input wire:model="testimonials.items.{{ $index }}.role" :label="__('Role')" />
                            <flux:input wire:model="testimonials.items.{{ $index }}.rating" :label="__('Rating (1-5)')" type="number" min="1" max="5" />
                        </div>
                        <flux:textarea wire:model="testimonials.items.{{ $index }}.quote" :label="__('Quote')" rows="2" />
                    </div>
                    <flux:button type="button" variant="ghost" size="sm" icon="trash" wire:click="removeTestimonial({{ $index }})" />
                </div>
            @endforeach
        </div>
        <flux:button type="button" variant="outline" icon="plus" wire:click="addTestimonial">{{ __('Add testimonial') }}</flux:button>

        <div>
            <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
        </div>
    </form>

    <flux:separator />

    {{-- CTA --}}
    <form wire:submit="save('cta')" class="space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="lg">{{ __('Call to action') }}</flux:heading>
            <flux:switch wire:model="cta.is_visible" :label="__('Visible')" />
        </div>

        <flux:input wire:model="cta.eyebrow" :label="__('Eyebrow')" />
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="cta.heading_line1" :label="__('Heading line 1')" />
            <flux:input wire:model="cta.heading_line2" :label="__('Heading line 2')" />
        </div>
        <flux:textarea wire:model="cta.subheading" :label="__('Subheading')" rows="2" />
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="cta.primary_text" :label="__('Primary button text')" />
            <flux:input wire:model="cta.primary_url" :label="__('Primary button URL')" />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="cta.secondary_text" :label="__('Secondary button text')" />
            <flux:input wire:model="cta.secondary_url" :label="__('Secondary button URL')" />
        </div>
        <flux:input wire:model="cta.contact_label" :label="__('Contact label')" />
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="cta.address_label" :label="__('Address label')" />
            <flux:input wire:model="cta.address" :label="__('Address')" />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="cta.email" :label="__('Email')" />
            <flux:input wire:model="cta.phone" :label="__('Phone')" />
        </div>

        <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
    </form>

    <flux:separator />

    {{-- Footer --}}
    <form wire:submit="save('footer')" class="space-y-6">
        <div class="flex items-center justify-between">
            <flux:heading size="lg">{{ __('Footer') }}</flux:heading>
            <flux:switch wire:model="footer.is_visible" :label="__('Visible')" />
        </div>

        <flux:textarea wire:model="footer.tagline" :label="__('Tagline')" rows="2" />

        <div class="space-y-4">
            <flux:heading size="sm">{{ __('Columns') }}</flux:heading>
            @foreach ($footer['columns'] as $index => $column)
                <div wire:key="footer-column-{{ $index }}" class="flex items-start gap-3 rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                    <div class="flex-1 space-y-3">
                        <flux:input wire:model="footer.columns.{{ $index }}.heading" :label="__('Column heading')" />
                        <flux:textarea wire:model="footer.columns.{{ $index }}.links" :label="__('Links')" rows="3" :description="__('One per line, format: Label|URL')" />
                    </div>
                    <flux:button type="button" variant="ghost" size="sm" icon="trash" wire:click="removeFooterColumn({{ $index }})" />
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addFooterColumn">{{ __('Add column') }}</flux:button>
        </div>

        <div class="space-y-4">
            <flux:heading size="sm">{{ __('Social links') }}</flux:heading>
            @foreach ($footer['social'] as $index => $social)
                <div wire:key="social-{{ $index }}" class="flex items-end gap-3">
                    <flux:select wire:model="footer.social.{{ $index }}.platform" :label="__('Platform')" class="w-40">
                        <flux:select.option value="linkedin">LinkedIn</flux:select.option>
                        <flux:select.option value="twitter">X / Twitter</flux:select.option>
                        <flux:select.option value="github">GitHub</flux:select.option>
                    </flux:select>
                    <flux:input wire:model="footer.social.{{ $index }}.url" :label="__('URL')" class="flex-1" />
                    <flux:button type="button" variant="ghost" size="sm" icon="trash" wire:click="removeSocialLink({{ $index }})" />
                </div>
            @endforeach
            <flux:button type="button" variant="outline" icon="plus" wire:click="addSocialLink">{{ __('Add social link') }}</flux:button>
        </div>

        <flux:input wire:model="footer.copyright_text" :label="__('Copyright text')" />

        <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
    </form>
</div>
