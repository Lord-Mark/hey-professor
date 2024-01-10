<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    public function __invoke(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        /**
         * OrderByRaw ordena os likes de forma descendente e os dislikes de forma ascendente,
         * os nulos são tratados como zero
         */
        $sqlRawQuery = 'case when votes_sum_like is null then 0 else votes_sum_like end desc,
                case when votes_sum_dislike is null then 0 else votes_sum_dislike end';

        /** Closure que faz o search no banco de dados */
        $searchQuestionFunction = fn (Builder $query) => $query->where(
            'question',
            'like',
            '%' . request()->search . '%'
        );

        /** Realiza a busca no banco de dados que será retornada à view dashboard */
        $questions = Question::query()
            ->when(request()->has('search'), $searchQuestionFunction)
            ->where('draft', '=', false)
            ->withSum('votes', 'like')
            ->withSum('votes', 'dislike')
            ->orderByRaw($sqlRawQuery)
            ->paginate(5);

        return view('dashboard', compact('questions'));
    }
}
