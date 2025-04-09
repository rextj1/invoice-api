<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
        ]);


        event(new Registered($user));
        // Auth::login($user);


        return response()->noContent();

        // return response()->json([
        //     'token' => $user->createToken('auth_token'),
        // ]);
    }

    public function checkEmailAvailability(Request $request)
    {
        info('email');
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = strtolower($request->email);
        // the `exist() method return a boolean of `true or false`
        $isAvailable = !User::where('email', $email)->exists();

        return response()->json(['available' => $isAvailable]);
    }
}
