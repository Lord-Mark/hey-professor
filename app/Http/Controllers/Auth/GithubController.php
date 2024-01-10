<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GithubController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function login(): RedirectResponse
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback(): RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();

        /** @var User $user */
        $user = User::query()->updateOrCreate(
            ['nickname' => $githubUser->getNickname(), 'email' => $githubUser->getEmail()],
            [
                'name'              => $githubUser->getName(),
                'password'          => bcrypt(Str::random(20)),
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }
}
