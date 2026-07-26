<x-layouts::auth :title="__('Forgot password')">
    <div class="flex flex-col gap-8">
        <x-auth-header
            :eyebrow="__('Account recovery')"
            :title="__('Forgot password')"
            :description="__('Enter your email to receive a password reset link.')"
        />

        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                icon="envelope"
                :label="__('Email address')"
                type="email"
                required
                autofocus
                placeholder="email@example.com"
            />

            <flux:button variant="primary" type="submit" class="w-full" data-test="email-password-reset-link-button">
                {{ __('Email password reset link') }}
            </flux:button>
        </form>

        <div class="space-x-1 text-center text-sm text-zinc-400 rtl:space-x-reverse">
            <span>{{ __('Or, return to') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('log in') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
