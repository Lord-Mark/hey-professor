<?php

namespace App\Http\Controllers;

use App\Models\Question;

class DashboardController extends Controller
{
    public function __invoke(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        // OrderByRaw ordena os likes de forma descendente e os dislikes de forma ascendente,
        // os nulos são tratados como zero
        return view('dashboard', [
            'questions' => Question::query()
                ->withSum('votes', 'like')
                ->withSum('votes', 'dislike')
                ->orderByRaw('case when votes_sum_like is null then 0 else votes_sum_like end desc,
                case when votes_sum_dislike is null then 0 else votes_sum_dislike end')
                ->paginate(5),
        ]);
        /**
         * OrderByRaw ordena os likes de forma descendente e os dislikes de forma ascendente,
         * os nulos são tratados como zero
         */
        $sqlRawQuery = 'case when votes_sum_like is null then 0 else votes_sum_like end desc,
                case when votes_sum_dislike is null then 0 else votes_sum_dislike end';
        /** Realiza a busca no banco de dados que será retornada à view dashboard */
        $questions = Question::query()
            ->where('draft', '=', false)
            ->withSum('votes', 'like')
            ->withSum('votes', 'dislike')
            ->orderByRaw($sqlRawQuery)
            ->paginate(5);

        return view('dashboard', compact('questions'));
    }
}
