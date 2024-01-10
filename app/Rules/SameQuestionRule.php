<?php

namespace App\Rules;

use App\Models\Question;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class SameQuestionRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->validationRule($value)) {
            $fail("This question already exists!");
        }
    }

    private function validationRule($value): bool
    {
        // Essa forma também funciona, mas phpstan talvez não goste muito
        // return Question::query()->whereQuestion($value)->exists();

        return Question::query()->where('question', '=', $value)->where('draft', '=', false)->exists();
    }
}
