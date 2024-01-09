<?php

namespace App\Http\Controllers;

use App\Models\Question;

class DashboardController extends Controller
{
    public function __invoke(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('dashboard', [
            'questions' => Question::query()->withSum('votes', 'like')
                ->withSum('votes', 'dislike')
                ->paginate(5),
        ]);
    }
}
