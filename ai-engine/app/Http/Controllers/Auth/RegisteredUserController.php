<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // =====================================================
        // VALIDASI INPUT
        // =====================================================
        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username'
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults()
            ],

        ]);

        // =====================================================
        // CREATE USER
        // =====================================================
        $user = User::create([

            'name' => $request->name,

            'username' => $request->username,

            'email' => $request->email,

            'password' => Hash::make(
                $request->password
            ),

        ]);

        // =====================================================
        // EVENT REGISTERED
        // =====================================================
        event(new Registered($user));

        // =====================================================
        // AUTO LOGIN
        // =====================================================
        Auth::login($user);

        // =====================================================
        // REDIRECT
        // =====================================================
        return redirect(
            route('dashboard', absolute: false)
        );
    }
}