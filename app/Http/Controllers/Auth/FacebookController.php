<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use function redirect;

class FacebookController extends Controller
{
    public const FB_DRIVER = 'facebook';

    public function loginUsingFacebook()
    {
        return Socialite::driver(self::FB_DRIVER)->redirect();
    }

    public function callbackFromFacebook()
    {
        try {
            $user = Socialite::driver(self::FB_DRIVER)->user();
        } catch (InvalidStateException $invalidStateException) {
            return redirect('/login')->with('fb_error', true);
        }

        $isUser = User::findByFacebookId($user->id);
        if($isUser) {
            Auth::login($isUser);
        } else {
            $newUser = User::createByFacebookId($user->name, $user->email, $user->id);

            Auth::login($newUser);
        }

        return redirect('/dashboard');
    }
}
