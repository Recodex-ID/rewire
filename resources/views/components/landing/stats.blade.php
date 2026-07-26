@php
    $items = [
        ['value' => '90', 'suffix' => '%', 'label' => 'Less boilerplate', 'sublabel' => 'per new project'],
        ['value' => '2', 'suffix' => '', 'label' => 'Roles ready', 'sublabel' => 'admin & member'],
        ['value' => '100', 'suffix' => '%', 'label' => 'Test coverage', 'sublabel' => 'on core features'],
        ['value' => '1', 'suffix' => ' day', 'label' => 'To first deploy', 'sublabel' => 'from clone to live'],
    ];
@endphp

<section class="relative overflow-hidden bg-brand-snow py-24">
    <div class="landing-dot-pattern absolute inset-0 opacity-50"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <div class="landing-reveal mb-16 grid gap-8 lg:grid-cols-12">
            <div class="lg:col-span-6">
                <div class="flex items-center gap-3">
                    <span class="h-px w-8 bg-brand-accent"></span>
                    <span class="font-mono text-xs uppercase tracking-widest text-brand-accent">
                        Impact
                    </span>
                </div>
                <h2 class="mt-4 font-display text-4xl font-bold tracking-tight text-brand-navy sm:text-5xl">
                    Less setup.
                    <br>
                    <span class="italic font-light text-brand-navy/50">More building.</span>
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 lg:grid-cols-4 lg:gap-8">
            @foreach ($items as $item)
                @php
                    $value = (string) $item['value'];
                    $decimals = str_contains($value, '.') ? strlen(substr(strrchr($value, '.'), 1)) : 0;
                @endphp
                <div @class([
                    'landing-reveal',
                    'landing-reveal-delay-1' => $loop->iteration === 2,
                    'landing-reveal-delay-2' => $loop->iteration === 3,
                    'landing-reveal-delay-3' => $loop->iteration === 4,
                ])>
                    <div class="font-display text-5xl font-bold tracking-tight text-brand-navy lg:text-7xl">
                        <span class="landing-counter" data-target="{{ $value }}" data-decimals="{{ $decimals }}">0</span><span class="text-brand-accent-dark">{{ $item['suffix'] }}</span>
                    </div>
                    <div class="mt-4 border-t border-brand-navy/10 pt-4">
                        <p class="font-medium text-brand-navy">{{ $item['label'] }}</p>
                        <p class="mt-1 text-sm text-brand-navy/50">{{ $item['sublabel'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
