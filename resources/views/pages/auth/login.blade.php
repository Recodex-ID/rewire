<x-layouts::auth title="Log in">
    <div class="flex flex-col gap-8">
        <x-auth-tabs active="login" />

        <x-auth-header
            eyebrow="Welcome back"
            title="Access your dashboard"
            description="Enter your credentials to continue where you left off."
        />

        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                icon="envelope"
                label="Email address"
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
                    label="Password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="Password"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 end-0 text-xs text-brand-accent-dark" :href="route('password.request')" wire:navigate>
                        Forgot your password?
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" label="Keep me signed in for 30 days" :checked="old('remember')" />

            <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                Sign in securely
            </flux:button>

            <flux:text class="text-center text-xs text-zinc-400">
                Protected by industry-standard encryption. Your data is transmitted securely.
            </flux:text>
        </form>
    </div>
</x-layouts::auth>
