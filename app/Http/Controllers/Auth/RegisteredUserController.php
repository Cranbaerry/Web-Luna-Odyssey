<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $messages = [
            'email.required' => 'We need to know your e-mail address!',
            'userid.regex' => 'Username can only contain letters and numbers!'
        ];

        Validator::make($request->all(), [
            'id_loginid' => ['required', 'string', 'regex:/^[a-zA-Z0-9]+$/u', 'alpha_num', 'max:12', 'min:4', 'unique:App\Models\User,id_loginid'],
            'id_email' => ['required', 'string', 'email', 'max:100', 'unique:App\Models\User,id_email'],
            'password' => ['required', 'confirmed', 'min:8', 'max:50'],
            'pin' => ['required', 'min:4', 'max:4'],
        ], $messages)->validate();

        $user = User::create([
            'id_loginid' => $request->id_loginid,
            'id_email' => $request->id_email,
            'id_passwd' => $request->password,
            'code' => Str::random(100),
            'UserPointMall' => 0,
            'UserLevel' => 6,
            'pin' => $request->pin,
        ]);

        $user->update(['id_idx' => $user->propid]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home'));
    }
}
