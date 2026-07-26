<?php

use App\Models\User;

test('new users are automatically assigned the user role', function () {
    $user = User::factory()->create();

    expect($user->hasRole('user'))->toBeTrue();
});
