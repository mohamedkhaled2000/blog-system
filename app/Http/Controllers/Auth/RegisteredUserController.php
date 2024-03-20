<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Nationality;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Http\Resources\NationalityResource;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $nationalities = Nationality::all();

        return Inertia::render('Auth/Register', [
            'nationalities' => NationalityResource::collection($nationalities)
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
            'national_id'   => 'required|exists:nationalities,id'
        ]);

        $user = User::create($validated);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
