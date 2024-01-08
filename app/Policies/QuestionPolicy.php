<?php

namespace App\Policies;

use App\Models\{Question, User};

class QuestionPolicy
{
    /**
     * Determine whether the user can modify the model.
     */
    public function modify(User $user, Question $question): bool
    {
        return $question->user()->is($user);
    }
}
