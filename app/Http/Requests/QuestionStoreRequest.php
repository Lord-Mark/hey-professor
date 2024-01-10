<?php

namespace App\Http\Requests;

use App\Rules\{EndWithQuestionMarkRule, SameQuestionRule};
use Illuminate\Foundation\Http\FormRequest;

class QuestionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
