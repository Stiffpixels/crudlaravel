<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{

    /**
     * Get a JWT via given credentials.
     *
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = request(['email', 'password']);
        $token = auth()->attempt($credentials);

        if (!$token) {
            return redirect("/login");
        }

        return redirect(route('dashboard'))->cookie('token', $token, 5, "/", null, false, true);
    }

    /**
     * Register a user
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed']
        ]);

        $password = Hash::make($request->password);

        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->prof_img = "";
        $user->password = $password;
        $user->save();

        $token = Auth::login($user);

        return redirect(route('dashboard'))->cookie('token', $token, 5, "/", null, false, true);
    }

    /**
     * Get the authenticated User.
     *
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     */
    public function logout(): RedirectResponse
    {
        auth()->logout();

        return redirect(route('login'));
    }
}