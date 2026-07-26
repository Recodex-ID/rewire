@props(['active'])

<div class="mb-10 flex rounded-full border border-brand-navy/5 bg-brand-navy/5 p-1 dark:border-brand-snow/10 dark:bg-brand-snow/5">
    <a
        href="{{ route('login') }}"
        wire:navigate
        @class([
            'flex-1 rounded-full py-2.5 text-center text-sm font-medium transition-all',
            'bg-brand-navy text-brand-snow shadow-sm dark:bg-brand-accent dark:text-brand-navy' => $active === 'login',
            'text-brand-navy/60 hover:text-brand-navy dark:text-brand-silver dark:hover:text-brand-snow' => $active !== 'login',
        ])
    >
        Sign in
    </a>
    <a
        href="{{ route('register') }}"
        wire:navigate
        @class([
            'flex-1 rounded-full py-2.5 text-center text-sm font-medium transition-all',
            'bg-brand-navy text-brand-snow shadow-sm dark:bg-brand-accent dark:text-brand-navy' => $active === 'register',
            'text-brand-navy/60 hover:text-brand-navy dark:text-brand-silver dark:hover:text-brand-snow' => $active !== 'register',
        ])
    >
        Create account
    </a>
</div>
