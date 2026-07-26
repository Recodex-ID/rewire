<?php

use App\Models\User;

test('new users are automatically assigned the member role', function () {
    $user = User::factory()->create();

    expect($user->hasRole('member'))->toBeTrue();
});
