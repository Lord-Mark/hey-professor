<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\{Question, User, Vote};
use Illuminate\Http\{RedirectResponse, Request};

class QuestionController extends Controller
{
    public function store(StoreQuestionRequest $request): RedirectResponse
    {

        Question::query()->create([
            'question' => request()->question,
            'draft'    => true,
        ]);

        return to_route('dashboard');
    }

    public function publish(Question $question): RedirectResponse
    {
        $question->update(['draft' => false]);

        return back();
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
