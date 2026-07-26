<x-layouts::auth title="Register">
    <div class="flex flex-col gap-8">
        <x-auth-tabs active="register" />

        <x-auth-header
            eyebrow="Get started"
            title="Create your account"
            description="Start building on a foundation that is already wired up."
        />

        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-5">
            @csrf
            <!-- Name -->
            <flux:input
                name="name"
                icon="user"
                label="Name"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                placeholder="Full name"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                icon="envelope"
                label="Email address"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <div x-data>
                <flux:input
                    id="password"
                    name="password"
                    icon="lock-closed"
                    label="Password"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Min. 8 characters"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    viewable
                    x-on:input="
                        const v = $event.target.value;
                        let s = 0;
                        if (v.length > 3) s = 1;
                        if (v.length > 6) s = 2;
                        if (v.length > 8 && /[A-Z]/.test(v) && /[0-9]/.test(v)) s = 3;
                        if (v.length > 10 && /[^A-Za-z0-9]/.test(v)) s = 4;
                        $refs.strength.querySelectorAll('span').forEach((bar, i) => {
                            bar.className = 'h-1 flex-1 rounded-full ' + (i >= s ? 'bg-brand-navy/10' : s === 1 ? 'bg-red-400' : s === 2 ? 'bg-yellow-400' : s === 3 ? 'bg-brand-accent' : 'bg-green-500');
                        });
                    "
                />
                <div x-ref="strength" class="mt-2 flex gap-1.5">
                    <span class="h-1 flex-1 rounded-full bg-brand-navy/10"></span>
                    <span class="h-1 flex-1 rounded-full bg-brand-navy/10"></span>
                    <span class="h-1 flex-1 rounded-full bg-brand-navy/10"></span>
                    <span class="h-1 flex-1 rounded-full bg-brand-navy/10"></span>
                </div>
            </div>

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

            <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                Create account
            </flux:button>
        </form>
    </div>
</x-layouts::auth>
