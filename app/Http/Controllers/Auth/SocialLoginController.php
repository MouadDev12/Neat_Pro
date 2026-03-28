<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect(string $provider)
    {
        abort_unless(in_array($provider, ['google', 'github']), 404);
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        abort_unless(in_array($provider, ['google', 'github']), 404);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['social' => 'OAuth authentication failed.']);
        }

        $user = User::updateOrCreate(
            ['provider' => $provider, 'provider_id' => $socialUser->getId()],
            [
                'name'     => $socialUser->getName() ?? $socialUser->getNickname(),
                'email'    => $socialUser->getEmail(),
                'avatar'   => $socialUser->getAvatar(),
                'password' => bcrypt(str()->random(32)),
            ]
        );

        Auth::login($user, true);
        return redirect()->route('dashboard');
    }
}
