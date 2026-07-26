<x-layouts::auth title="Email verification">
    <div class="flex flex-col gap-8">
        <x-auth-header
            eyebrow="One more step"
            title="Verify your email"
            description="Please verify your email address by clicking on the link we just emailed to you."
        />

        @if (session('status') == 'verification-link-sent')
            <flux:text class="font-medium text-green-600">
                A new verification link has been sent to the email address you provided during registration.
            </flux:text>
        @endif

        <div class="flex flex-col gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <flux:button type="submit" variant="primary" class="w-full">
                    Resend verification email
                </flux:button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <flux:button variant="outline" type="submit" class="w-full cursor-pointer text-sm" data-test="logout-button">
                    Log out
                </flux:button>
            </form>
        </div>
    </div>
</x-layouts::auth>
