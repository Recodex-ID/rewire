@props(['active'])

<div class="mb-10 flex rounded-full border border-brand-navy/5 bg-brand-navy/5 p-1">
    <a
        href="{{ route('login') }}"
        wire:navigate
        @class([
            'flex-1 rounded-full py-2.5 text-center text-sm font-medium transition-all',
            'bg-brand-navy text-brand-snow shadow-sm' => $active === 'login',
            'text-brand-navy/60 hover:text-brand-navy' => $active !== 'login',
        ])
    >
        Sign in
    </a>
    <a
        href="{{ route('register') }}"
        wire:navigate
        @class([
            'flex-1 rounded-full py-2.5 text-center text-sm font-medium transition-all',
            'bg-brand-navy text-brand-snow shadow-sm' => $active === 'register',
            'text-brand-navy/60 hover:text-brand-navy' => $active !== 'register',
        ])
    >
        Create account
    </a>
</div>
