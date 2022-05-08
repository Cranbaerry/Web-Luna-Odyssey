<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Tier;
use App\Models\TierReward;
use App\Models\Redeem;
use App\Models\RedeemClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\ItemLog;
use Validator;
use App\Http\Helper;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function view(Request $request) {
        $itemlog = ItemLog::where('userid', auth()->user()->id_idx);
        $itemlog->orderByDesc('date_purchased');
        $itemlog = $itemlog->paginate(10, ['*'], 'item_mall');
        $itemlog->appends(['tab' => 'itemmall']);

        $transactions = Invoice::where('user_id', auth()->user()->id_idx);
        $transactions->orderByDesc('date_created');
        $transactions = $transactions->paginate(10, ['*'], 'invoice');
        $transactions->appends(['tab' => 'invoice']);

        $freeRewards = new \stdClass();
        $freeRewards->tiers = Tier::where('active', 1)->orderBy('goal')->get();
        $freeRewards->topUpAccumulation = $this->getTopUpAccumulation();

        foreach ($freeRewards->tiers as &$tier) {
            $tier->claimed = ItemLog::where('userid', auth()->user()->id_idx)->where('tier_id', $tier->id)->exists();
        }

        if ($request->has('invoice')) {
            session()->flash('tab', 'invoice');
            if ($transactions->count() === 0) {
                if (!is_null($transactions->previousPageUrl())) {
                    return redirect()->to($transactions->previousPageUrl());
                }
            }
        }

        if ($request->has('itemmall')) {
            session()->flash('tab', 'itemmall');
            if ($itemlog->count() === 0) {
                if (!is_null($itemlog->previousPageUrl())) {
                    return redirect()->to($itemlog->previousPageUrl());
                }
            }
        }

        return view('dashboard', compact('transactions', 'itemlog', 'freeRewards'));
    }

    public function redeem(Request $request) {
        session()->flash('tab', 'redeem');
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
        return redirect()->route('dashboard');
    }

    public function tieredSpender(Request $request) {
        session()->flash('tab', 'tiered');

        $request->validate([
            //table[,column[,ignore value[,ignore column[,where column,where value]...]]]
            'tier_id' => ['required', 'exists:App\Models\Tier,id',
                Rule::unique(app(ItemLog::Class)->getTable())->where(function ($query) use ($request) {
                    $query->where('userid', auth()->user()->id_idx)->where('tier_id', $request->tier_id);
                })
            ],
            'reward_id' => ['required', 'exists:App\Models\TierReward,id']
        ]);

        $tier = Tier::find($request->tier_id);
        $reward = TierReward::find($request->reward_id);
        $points = $this->getTopUpAccumulation();

        if ($points < $tier->goal)
            return redirect()->route('dashboard', ['tab'=> 'tiered'])->withErrors(['msg' => 'Not enough spending for this month.']);

        if (!$tier->active)
            return redirect()->route('dashboard', ['tab'=> 'tiered'])->withErrors(['msg' => 'This event is not active yet or has already expired.']);

        Item::create([
            'CHARACTER_IDX' => 0,
            'ITEM_IDX' => $reward->itemId,
            'ITEM_POSITION' => 0,
            'ITEM_DURABILITY' => $reward->quantity,
            'ITEM_SHOPIDX' => auth()->user()->id_idx,
        ]);

        ItemLog::create([
            'userid' => auth()->user()->id_idx,
            'itemid' => $reward->itemId,
            'name' => $reward->name,
            'quantity' => $reward->quantity,
            'price' => 0,
            'total' => 0,
            'is_reward' => 1,
            'tier_id' => $tier->id,
        ]);

        $request->session()->flash('status', 'Item has been successfully!');
        return redirect()->route('dashboard');
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

    private function getTopUpAccumulation() {
        return Invoice::where([
            ['user_id', '=', auth()->user()->id_idx],
            ['status_code', '=', '00']
        ])->whereBetween('date_updated', [date("Y-m-d", time()), date("Y-m-d", Helper::getSetting('tiered_spender_end'))])->sum('price');
    }
}
