<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\{Question, User, Vote};
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\{RedirectResponse, Request};
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class QuestionController extends Controller
{
    public function store(StoreQuestionRequest $request): RedirectResponse
    {

        user()->questions()->create([
            'question' => request()->question,
            'draft'    => true,
        ]);

        return to_route('dashboard');
    }

    /**
     * @throws AuthorizationException
     */
    public function publish(Question $question): RedirectResponse
    {
        // abort_unless(user()->can('publish', $question), SymfonyResponse::HTTP_FORBIDDEN);

        $this->authorize('publish', $question);
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
