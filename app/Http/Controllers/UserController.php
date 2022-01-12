<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Partner;
use App\Models\Redeem;
use App\Models\RedeemClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\ItemLog;
use Validator;

class UserController extends Controller
{

    public function view() {
        $itemlog = ItemLog::where('userid', auth()->user()->id_idx);
        $itemlog->orderByDesc('date_purchased');
        $itemlog = $itemlog->paginate(10, ['*'], 'item_mall');
        $itemlog->appends(['tab' => 'itemmall']);

        $transactions = Invoice::where('user_id', auth()->user()->id_idx);
        $transactions->orderByDesc('date_created');
        $transactions = $transactions->paginate(10, ['*'], 'invoice');
        $transactions->appends(['tab' => 'purchase']);
        return view('dashboard', compact('transactions', 'itemlog'));
    }

    public function redeem(Request $request) {
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'exists:App\Models\Redeem,code',
            function($attribute, $value, $fail) use($request) {
                $isClaimed = RedeemClaim::where('code', $request->code, Auth::user()->id_idx)->exists();
                if ($isClaimed) {
                    return $fail('You already claimed this code!');
                }
            }],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard', ['tab'=> 'redeem'])
                ->withErrors($validator)
                ->withInput();
        }

        $redeem = Redeem::find($request->code);
        Item::create([
            'CHARACTER_IDX' => 0,
            'ITEM_IDX' => $redeem->itemid,
            'ITEM_POSITION' => 0,
            'ITEM_DURABILITY' => $redeem->quantity,
            'ITEM_SHOPIDX' => Auth::user()->id_idx,
        ]);

        RedeemClaim::create([
            'code' => $request->code,
            'userid' => Auth::user()->id_idx,
        ]);

        $request->session()->flash('status', 'Item has been claimed successfully!');
        return redirect()->route('dashboard', ['tab'=> 'redeem']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'id_loginid' => ['required'],
            'password' => ['required'],
            'remember' => 'boolean',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'user' => 'uwu'
            ]);
        }

        return response()->json([
            'user' => null,
        ]);
    }
}
