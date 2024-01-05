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
