<?php

use App\Http\Controllers\{
    Auth\GithubController,
    DashboardController,
    ProfileController,
    QuestionController
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //    if (app()->isLocal()) {
    //        auth()->loginUsingId(1);
    //
    //        return to_route('dashboard');
    //    }

    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(GithubController::class)
    ->prefix('github')
    ->name('github.')
    ->group(function () {
        Route::get('login', 'login')->name('login');
        Route::get('callback', 'callback')->name('callback');
    });

Route::prefix('question')
    ->name('question.')
    ->middleware('auth')
    ->controller(QuestionController::class)
    ->group(function () {
        Route::post('/dislike/{question}', 'dislike')->name('dislike');
        Route::put('/publish/{question}', 'publish')->name('publish');
        Route::get('/question/{question}/edit', 'edit')->name('edit');
        Route::patch('/{question}/archive', 'archive')->name('archive');
        Route::patch('/{question}/restore', 'restore')->name('restore');
        Route::delete('/{question}', 'destroy')->name('destroy');
        Route::post('/like/{question}', 'like')->name('like');
        Route::put('/{question}', 'update')->name('update');
        Route::post('/store', 'store')->name('store');
        Route::get('/index', 'index')->name('index');
    });

require __DIR__ . '/auth.php';
