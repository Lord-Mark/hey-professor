<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\{Question};
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Foundation\Application as ViewApplication;
use Illuminate\Http\{RedirectResponse};

class QuestionController extends Controller
{
    public function index(): View|ViewApplication|Factory|Application
    {
        $questions = user()->questions;

        return view('question.index', compact('questions'));
    }

    public function store(StoreQuestionRequest $request): RedirectResponse
    {
        user()->questions()->create([
            'question' => request()->question,
            'draft'    => true,
        ]);

        return back();
    }

    /**
     * @throws AuthorizationException
     */
    public function publish(Question $question): RedirectResponse
    {
        $this->authorize('modify', $question);
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

    /**
     * @throws AuthorizationException
     */
    public function destroy(Question $question): RedirectResponse
    {
        $this->authorize('modify', $question);

        $question->delete();

        return back();
    }

    public function edit()
    {
    }

}
