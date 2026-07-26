<x-layouts::auth title="Confirm password">
    <div class="flex flex-col gap-8">
        <x-auth-header
            eyebrow="Secure area"
            title="Confirm password"
            description="This is a secure area of the application. Please confirm your password before continuing."
        />

        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-5">
            @csrf

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

            <flux:button variant="primary" type="submit" class="w-full" data-test="confirm-password-button">
                Confirm
            </flux:button>
        </form>
    </div>
</x-layouts::auth>
