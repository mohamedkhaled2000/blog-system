<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToLogin($type): RedirectResponse
    {
        return Socialite::driver($type)->redirect();
    }

    public function handleLoginCallback($type): RedirectResponse
    {
        $user = Socialite::driver($type)->user();

        $existingUser = User::where($type . "_id", $user->id)->first();

        if ($existingUser) {
            auth()->login($existingUser, true);
        } else {
            $newUser = User::create([
                'name'              => $user->name,
                'email'             => $user->email,
                $type . '_id'       => $user->id,
            ]);

            auth()->login($newUser, true);
        }

        return redirect()->intended('/dashboard');
    }
}
