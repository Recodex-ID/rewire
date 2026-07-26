<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;

test('mail notifications render with the brand color and app name', function () {
    $user = User::factory()->create();

    $html = (string) (new ResetPassword('fake-token'))->toMail($user)->render();

    expect($html)
        ->toContain('#1a2a4b')
        ->toContain('Rewire Starter Kit');
});
