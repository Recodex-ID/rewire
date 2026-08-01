<?php

use App\Models\User;

test('new users are automatically assigned the staff role', function () {
    $user = User::factory()->create();

    expect($user->hasRole('staff'))->toBeTrue();
});
