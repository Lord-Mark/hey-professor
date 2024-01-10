<?php

namespace App\Http\Requests;

use App\Models\Question;
use App\Rules\{EndWithQuestionMarkRule, SameQuestionRule};
use Illuminate\Foundation\Http\FormRequest;

class QuestionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var Question $question */
        $question = $this->route('question');

        return $this->user()->can('update', $question);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'question' => [
                'required',
                "min:10",
                new EndWithQuestionMarkRule(),
                new SameQuestionRule(),
            ],
        ];
    }
}
