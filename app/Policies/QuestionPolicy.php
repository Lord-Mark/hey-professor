<?php

namespace App\Policies;

use App\Models\{Question, User};

class QuestionPolicy
{
    /**
     * Determine whether the user can modify the model.
     */
    public function see(User $user, Question $question): bool
    {
        return $question->user()->is($user);
    }

    public function update(User $user, Question $question): bool
    {
        return $question->draft;
    }
}
