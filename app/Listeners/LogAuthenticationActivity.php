<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Events\Dispatcher;

class LogAuthenticationActivity
{
    /**
     * Register the listeners for the subscriber.
     *
     * @return array<class-string, string>
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            Registered::class => 'handleRegistered',
            Login::class => 'handleLogin',
            Logout::class => 'handleLogout',
            Failed::class => 'handleFailed',
            PasswordReset::class => 'handlePasswordReset',
            Verified::class => 'handleVerified',
        ];
    }

    public function handleRegistered(Registered $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }

        $user = $event->user;

        activity('auth')
            ->performedOn($user)
            ->causedBy($user)
            ->log("{$user->name} registered");
    }

    public function handleLogin(Login $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }

        $user = $event->user;

        activity('auth')
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties(['guard' => $event->guard])
            ->log("{$user->name} logged in");
    }

    public function handleLogout(Logout $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }

        $user = $event->user;

        activity('auth')
            ->performedOn($user)
            ->causedBy($user)
            ->log("{$user->name} logged out");
    }

    public function handleFailed(Failed $event): void
    {
        $email = $this->identifyingField($event->credentials);

        $activity = activity('auth')->withProperties(['email' => $email]);

        if ($event->user instanceof User) {
            $activity->performedOn($event->user);
        }

        $activity->log($email !== null
            ? "Failed login attempt for {$email}"
            : 'Failed login attempt for an unknown account');
    }

    public function handlePasswordReset(PasswordReset $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }

        $user = $event->user;

        activity('auth')
            ->performedOn($user)
            ->causedBy($user)
            ->log("{$user->name} reset their password");
    }

    public function handleVerified(Verified $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }

        $user = $event->user;

        activity('auth')
            ->performedOn($user)
            ->causedBy($user)
            ->log("{$user->name} verified their email address");
    }

    /**
     * Pull the identifying (non-password) field out of failed login credentials,
     * e.g. "email". Never returns the password itself.
     *
     * @param  array<string, mixed>  $credentials
     */
    private function identifyingField(array $credentials): ?string
    {
        $value = $credentials['email'] ?? collect($credentials)->except('password')->first();

        return is_string($value) ? $value : null;
    }
}
