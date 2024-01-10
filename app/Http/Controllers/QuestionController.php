<?php

namespace App\Http\Controllers;

use App\Http\Requests\{QuestionStoreRequest, QuestionUpdateRequest};
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
        $questions         = user()->questions;
        $archivedQuestions = Question::onlyTrashed()->where('created_by', "=", user()->getAttribute('id'));

        return view('question.index', compact(['questions', 'archivedQuestions']));
    }

    public function store(QuestionStoreRequest $request): RedirectResponse
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
        $this->authorize('see', $question);
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
        $this->authorize('see', $question);

        $question->forceDelete();

        return back();
    }

    /**
     * @throws AuthorizationException
     */
    public function archive(Question $question): RedirectResponse
    {
        $this->authorize('see', $question);

        $question->delete();

        return back();
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Question $question): View|ViewApplication|Factory|Application
    {
        $this->authorize('update', $question);

        return view('question.edit', compact('question'));
    }

    public function update(QuestionUpdateRequest $request, Question $question): RedirectResponse
    {
        $question->question = request()->question;
        $question->save();

        return to_route('question.index');
    }

    /**
     * @throws AuthorizationException
     */
    public function restore($id): RedirectResponse
    {
        $question = Question::withTrashed()->find($id);

        $this->authorize('see', $question);

        $question->restore();

        return back();
    }

}
