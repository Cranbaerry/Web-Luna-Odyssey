<?php

namespace App\Http\Controllers\Auth;

use App\Mail\PinRecovery;
use App\Models\Partner;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PinController extends Controller
{

    public function view() {
        return view('auth.forgot-pin');
    }

    public function send(Request $request) {
        $validator =  $request->validate([
            'email'=>'required|email|exists:App\Models\User,id_email'
        ]);

        $data = User::where('id_email', $request->email)->first();
        Mail::to($request->email)->send(new PinRecovery($data));
    }

    public function setup(Request $request) {
        $request->validate(['pin' => ['required', 'min:4', 'max:4',
            function($attribute, $value, $fail) use($request) {
                if (Auth::user()->pin != null) {
                    return $fail('PIN has already been setup for this user!');
                }
            }]]);

        $user = Auth::user();
        $user->pin = $request->pin;
        $user->save();

        $request->session()->flash('status', 'PIN was successfully setup!');
        return response()->json([
            'message' => 'success',
        ]);
    }
}
