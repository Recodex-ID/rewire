<x-layouts::auth :title="__('Email verification')">
    <div class="flex flex-col gap-8">
        <x-auth-header
            :eyebrow="__('One more step')"
            :title="__('Verify your email')"
            :description="__('Please verify your email address by clicking on the link we just emailed to you.')"
        />

        @if (session('status') == 'verification-link-sent')
            <flux:text class="font-medium text-green-600 dark:text-green-400">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </flux:text>
        @endif

        <div class="flex flex-col gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Resend verification email') }}
                </flux:button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <flux:button variant="ghost" type="submit" class="w-full cursor-pointer text-sm" data-test="logout-button">
                    {{ __('Log out') }}
                </flux:button>
            </form>
        </div>
    </div>
</x-layouts::auth>
