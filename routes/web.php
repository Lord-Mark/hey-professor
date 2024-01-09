<?php

use App\Http\Controllers\{DashboardController, ProfileController, QuestionController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (app()->isLocal()) {
        auth()->loginUsingId(1);

        return to_route('dashboard');
    }

    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('question')
    ->name('question.')
    ->middleware('auth')
    ->controller(QuestionController::class)
    ->group(function () {
        Route::post('/dislike/{question}', 'dislike')->name('dislike');
        Route::put('/publish/{question}', 'publish')->name('publish');
        Route::get('/question/{question}/edit', 'edit')->name('edit');
        Route::patch('/archive/{question}', 'archive')->name('archive');
        Route::delete('/{question}', 'destroy')->name('destroy');
        Route::post('/like/{question}', 'like')->name('like');
        Route::put('/{question}', 'update')->name('update');
        Route::post('/store', 'store')->name('store');
        Route::get('/index', 'index')->name('index');
    });

require __DIR__ . '/auth.php';
