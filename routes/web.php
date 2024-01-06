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
        Route::post('/store', 'store')->name('store');
        Route::post('/like/{question}', 'like')->name('like');
        Route::post('/dislike/{question}', 'dislike')->name('dislike');
        Route::put('/publish/{question}', 'publish')->name('publish');
    });

require __DIR__ . '/auth.php';
