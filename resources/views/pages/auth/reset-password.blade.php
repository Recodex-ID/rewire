<x-layouts::auth title="Reset password">
    <div class="flex flex-col gap-8">
        <x-auth-header
            eyebrow="Account recovery"
            title="Reset password"
            description="Please enter your new password below."
        />

        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-5">
            @csrf
            <!-- Token -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email Address -->
            <flux:input
                name="email"
                icon="envelope"
                value="{{ request('email') }}"
                label="Email"
                type="email"
                required
                autocomplete="email"
            />

            <!-- Password -->
            <flux:input
                name="password"
                icon="lock-closed"
                label="Password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Password"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                icon="lock-closed"
                label="Confirm password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Confirm password"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <flux:button type="submit" variant="primary" class="w-full" data-test="reset-password-button">
                Reset password
            </flux:button>
        </form>
    </div>
</x-layouts::auth>
