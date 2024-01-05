<?php

namespace App\Http\Controllers;

use App\Models\{Question, User, Vote};
use App\Rules\EndWithQuestionMarkRule;
use Illuminate\Http\{RedirectResponse, Request};

class QuestionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        Question::query()->create(
            request()->validate([
                'question' => [
                    'required',
                    "min:10",
                    new EndWithQuestionMarkRule(),
                ],
            ])
        );

        return to_route('dashboard');
    }

    /**
     * @param Question $question
     * @return RedirectResponse
     */
    public function like(Question $question): RedirectResponse
    {
        user()->like($question);

        return back();
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
