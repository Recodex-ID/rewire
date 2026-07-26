<x-layouts::auth :title="__('Log in')">
    <div class="flex flex-col gap-8">
        <x-auth-tabs active="login" />

        <x-auth-header
            :eyebrow="__('Welcome back')"
            :title="__('Access your dashboard')"
            :description="__('Enter your credentials to continue where you left off.')"
        />

        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                icon="envelope"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    icon="lock-closed"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 end-0 text-xs text-brand-accent-dark dark:text-brand-accent" :href="route('password.request')" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Keep me signed in for 30 days')" :checked="old('remember')" />

            <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                {{ __('Sign in securely') }}
            </flux:button>

            <flux:text class="text-center text-xs text-zinc-400">
                {{ __('Protected by industry-standard encryption. Your data is transmitted securely.') }}
            </flux:text>
        </form>
    </div>
</x-layouts::auth>
