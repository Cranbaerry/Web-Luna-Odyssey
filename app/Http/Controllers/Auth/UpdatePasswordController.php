<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Auth;

class UpdatePasswordController extends Controller
{

    /**
     * Handle an incoming update password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'old_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if ($value != $user->id_passwd) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'id_passwd' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->id_passwd = $request->id_passwd;
        $user->save();

        return response()->json([
            'message' => 'Password successfuly changed'
        ]);
    }
}
