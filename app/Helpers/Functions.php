<?php

use App\Models\User;

/**
* @return User|null
 */
function user(): ?User
{
    if (auth()->check()) {
        /** @var User $user */
        $user = auth()->user();

        return $user;
    }

    return null;
}

/**
 * Create a new user with the User factory and casts
 * its return to App\Models\User (factory creates users as Authenticatable)
 * @return User
 */
function factoryNewUser(): User
{
    /** @var User $user */
    $user = User::factory()->create();

    return $user;
}
