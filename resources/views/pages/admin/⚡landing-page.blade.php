<?php

use App\Models\LandingPageSection;
use Flux\Flux;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Landing page')] class extends Component
{
    public array $hero = ['heading' => '', 'subheading' => '', 'cta_text' => '', 'cta_url' => '', 'is_visible' => true];

    public array $features = ['heading' => '', 'items' => [], 'is_visible' => true];

    public array $testimonials = ['heading' => '', 'items' => [], 'is_visible' => true];

    public array $cta = ['heading' => '', 'button_text' => '', 'button_url' => '', 'is_visible' => true];

    public function mount(): void
    {
        foreach (['hero', 'features', 'testimonials', 'cta'] as $key) {
            $section = LandingPageSection::query()->where('key', $key)->first();

            if ($section) {
                $this->{$key} = [...$section->content, 'is_visible' => $section->is_visible];
            }
        }
    }

    public function addFeature(): void
    {
        $this->features['items'][] = ['title' => '', 'description' => ''];
    }

    public function removeFeature(int $index): void
    {
        unset($this->features['items'][$index]);
        $this->features['items'] = array_values($this->features['items']);
    }

    public function addTestimonial(): void
    {
        $this->testimonials['items'][] = ['name' => '', 'role' => '', 'quote' => ''];
    }

    public function removeTestimonial(int $index): void
    {
        unset($this->testimonials['items'][$index]);
        $this->testimonials['items'] = array_values($this->testimonials['items']);
    }

    public function saveHero(): void
    {
        $validated = $this->validate([
            'hero.heading' => ['required', 'string', 'max:255'],
            'hero.subheading' => ['required', 'string', 'max:500'],
            'hero.cta_text' => ['required', 'string', 'max:100'],
            'hero.cta_url' => ['required', 'string', 'max:255'],
            'hero.is_visible' => ['boolean'],
        ])['hero'];

        $this->persist('hero', $validated);
    }

    public function saveFeatures(): void
    {
        $validated = $this->validate([
            'features.heading' => ['required', 'string', 'max:255'],
            'features.items' => ['array'],
            'features.items.*.title' => ['required', 'string', 'max:255'],
            'features.items.*.description' => ['required', 'string', 'max:500'],
            'features.is_visible' => ['boolean'],
        ])['features'];

        $this->persist('features', $validated);
    }

    public function saveTestimonials(): void
    {
        $validated = $this->validate([
            'testimonials.heading' => ['required', 'string', 'max:255'],
            'testimonials.items' => ['array'],
            'testimonials.items.*.name' => ['required', 'string', 'max:255'],
            'testimonials.items.*.role' => ['nullable', 'string', 'max:255'],
            'testimonials.items.*.quote' => ['required', 'string', 'max:500'],
            'testimonials.is_visible' => ['boolean'],
        ])['testimonials'];

        $this->persist('testimonials', $validated);
    }

    public function saveCta(): void
    {
        $validated = $this->validate([
            'cta.heading' => ['required', 'string', 'max:255'],
            'cta.button_text' => ['required', 'string', 'max:100'],
            'cta.button_url' => ['required', 'string', 'max:255'],
            'cta.is_visible' => ['boolean'],
        ])['cta'];

        $this->persist('cta', $validated);
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    private function persist(string $key, array $validated): void
    {
        $isVisible = $validated['is_visible'] ?? true;
        unset($validated['is_visible']);

        LandingPageSection::query()->where('key', $key)->update([
            'content' => $validated,
            'is_visible' => $isVisible,
        ]);

        Flux::toast(variant: 'success', text: __('Section updated.'));
    }
};
?>

<div class="w-full max-w-3xl space-y-12">
        <flux:heading size="xl">{{ __('Landing page content') }}</flux:heading>
        <flux:subheading>{{ __('Everything below is rendered on the public landing page.') }}</flux:subheading>

        {{-- Hero --}}
        <form wire:submit="saveHero" class="space-y-6">
            <div class="flex items-center justify-between">
                <flux:heading size="lg">{{ __('Hero') }}</flux:heading>
                <flux:switch wire:model="hero.is_visible" :label="__('Visible')" />
            </div>

            <flux:input wire:model="hero.heading" :label="__('Heading')" />
            <flux:textarea wire:model="hero.subheading" :label="__('Subheading')" rows="2" />
            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="hero.cta_text" :label="__('Button text')" />
                <flux:input wire:model="hero.cta_url" :label="__('Button URL')" />
            </div>

            <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
        </form>

        <flux:separator />

        {{-- Features --}}
        <form wire:submit="saveFeatures" class="space-y-6">
            <div class="flex items-center justify-between">
                <flux:heading size="lg">{{ __('Features') }}</flux:heading>
                <flux:switch wire:model="features.is_visible" :label="__('Visible')" />
            </div>

            <flux:input wire:model="features.heading" :label="__('Heading')" />

            <div class="space-y-4">
                @foreach ($features['items'] as $index => $item)
                    <div wire:key="feature-{{ $index }}" class="flex items-start gap-3 rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                        <div class="flex-1 space-y-3">
                            <flux:input wire:model="features.items.{{ $index }}.title" :label="__('Title')" />
                            <flux:textarea wire:model="features.items.{{ $index }}.description" :label="__('Description')" rows="2" />
                        </div>
                        <flux:button type="button" variant="ghost" size="sm" icon="trash" wire:click="removeFeature({{ $index }})" />
                    </div>
                @endforeach
            </div>

            <flux:button type="button" variant="outline" icon="plus" wire:click="addFeature">{{ __('Add feature') }}</flux:button>

            <div>
                <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
            </div>
        </form>

        <flux:separator />

        {{-- Testimonials --}}
        <form wire:submit="saveTestimonials" class="space-y-6">
            <div class="flex items-center justify-between">
                <flux:heading size="lg">{{ __('Testimonials') }}</flux:heading>
                <flux:switch wire:model="testimonials.is_visible" :label="__('Visible')" />
            </div>

            <flux:input wire:model="testimonials.heading" :label="__('Heading')" />

            <div class="space-y-4">
                @foreach ($testimonials['items'] as $index => $item)
                    <div wire:key="testimonial-{{ $index }}" class="flex items-start gap-3 rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                        <div class="flex-1 space-y-3">
                            <div class="grid grid-cols-2 gap-3">
                                <flux:input wire:model="testimonials.items.{{ $index }}.name" :label="__('Name')" />
                                <flux:input wire:model="testimonials.items.{{ $index }}.role" :label="__('Role')" />
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
        <form wire:submit="saveCta" class="space-y-6">
            <div class="flex items-center justify-between">
                <flux:heading size="lg">{{ __('Call to action') }}</flux:heading>
                <flux:switch wire:model="cta.is_visible" :label="__('Visible')" />
            </div>

            <flux:input wire:model="cta.heading" :label="__('Heading')" />
            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="cta.button_text" :label="__('Button text')" />
                <flux:input wire:model="cta.button_url" :label="__('Button URL')" />
            </div>

            <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
        </form>
    </div>
