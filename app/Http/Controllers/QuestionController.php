<?php

namespace App\Http\Controllers;

use App\Models\{Question, User, Vote};
use App\Rules\EndWithQuestionMarkRule;
use Illuminate\Http\{RedirectResponse, Request};

class QuestionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $attributes = request()->validate([
            'question' => [
                'required',
                "min:10",
                new EndWithQuestionMarkRule(),
            ],
        ]);
        Question::query()
            ->create(
                array_merge($attributes, ['draft' => true])
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

    /**
     * @param Question $question
     * @return RedirectResponse
     */
    public function dislike(Question $question): RedirectResponse
    {
        user()->dislike($question);

        return back();
    }
}
