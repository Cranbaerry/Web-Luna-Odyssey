<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Character;

class CharacterController extends Controller
{

    public function update_map(Request $request)
    {
        $user = Auth::user();
        $char = Character::find($request->char_id);

        $request->validate([
            'char_id' => ['required', 'integer',
                function($attribute, $value, $fail) use($user, $char, $request) {
                    if ($char === null) {
                        return $fail('Character does not exist in our record');
                    }

                    if ($char->USER_IDX != $user->id_idx) {
                        return $fail('Character does not belong to this account');
                    }
                }],
            'map_id' => ['required', 'integer']
        ]);

        $char->CHARACTER_MAP = $request->map_id;
        $char->save();

        return response()->json([
            'message' => "Character <b>{$char->CHARACTER_NAME}</b> was
            successfully teleported to <b>{$char->getMapById($char->CHARACTER_MAP)}</b>. Please note that you may need to re-login to apply the update.",
        ]);
    }
}
