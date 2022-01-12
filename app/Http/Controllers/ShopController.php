<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemMall;
use App\Models\Item;
use App\Models\ItemLog;
use Illuminate\Support\Facades\Auth;
use Session;

class ShopController extends Controller
{
    public function view() {
        return view('shop');
    }

    public function buy(Request $request)
    {
        $item = ItemMall::find($request->itemid);
        $request->validate([
            'itemid' => ['required', 'exists:App\Models\ItemMall,item_id'],
            'qty' => ['required', function($attribute, $value, $fail) use($request, $item) {
                if ($item) {
                    if ($request->qty > $item->max_quantity) {
                        return $fail(sprintf('You cannot buy more than %d of that item!', $item->max_quantity));
                    }

                    if ($request->qty < $item->min_quantity) {
                        return $fail(sprintf('You cannot buy less than %d of that item!', $item->min_quantity));
                    }
                }
            }],
            'pin' => ['required', sprintf('exists:App\Models\User,pin,id_idx,%s', auth()->user()->id_idx)],
        ]);

        $user = Auth::user();
        $total = $request->qty * $item->price;
        if ($user->UserPointMall >= $total) {
            $user->UserPointMall -= $total;
            $user->save();

            Item::create([
                'CHARACTER_IDX' => 0,
                'ITEM_IDX' => $request->itemid,
                'ITEM_POSITION' => 0,
                'ITEM_DURABILITY' => $request->qty,
                'ITEM_SHOPIDX' => auth()->user()->id_idx,
            ]);

            ItemLog::create([
                'userid' => auth()->user()->id_idx,
                'itemid' => $request->itemid,
                'name' => $item->name,
                'quantity' => $request->qty,
                'price' => $item->price,
                'total' => $total,
            ]);

            Session::flash('item_purchased', $item->name);
            return response()->json([
                'message' => 'success',
            ]);
        } else return response()->json([
            'message' => 'Insufficient funds.',
        ], 422);
    }
}
