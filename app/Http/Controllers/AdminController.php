<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Item;
use App\Models\Partner;
use Illuminate\Http\Request;
use App\Models\WebSettings;
use App\Models\ItemMall;
use App\Models\ItemMallChild;
use App\Models\Redeem;
use App\Models\User;
use App\Exports\TransactionExport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Facades\CauserResolver;
use Session;
use Redirect;
use Auth;

class AdminController extends Controller
{
    public function view(Request $request) {
        $transactions = Invoice::where('method', 'Manual_BCA');
        $transactions->where('status_code', '01');
        $transactions->orderByDesc('date_created');
        $transactions = $transactions->paginate(10, ['*'], 'page_invoice');

        $itemMall = ItemMall::paginate(10, ['*'], 'page_itemmall');
        $itemMall->sortBy('id');
        $itemMall->sortBy('Category');

        $referrals = Partner::paginate(10, ['*'], 'page_partner');
        $referrals->sortBy('code');

        $redeems = Redeem::paginate(10, ['*'], 'page_redeem');
        $redeems->sortBy('code');

        $activities = Activity::where('log_name', 'admin');
        $activities->orderByDesc('created_at');
        $activities = $activities->paginate(5, ['*'], 'page_activity');

        if ($request->has('page_invoice')) {
            session()->flash('tab', 'transactions');
            if ($transactions->count() === 0) {
                if (!is_null($transactions->previousPageUrl())) {
                    return redirect()->to($transactions->previousPageUrl());
                }
            }
        }

        if ($request->has('page_itemmall')) {
            session()->flash('tab', 'itemmall');
            if ($itemMall->count() === 0) {
                if (!is_null($itemMall->previousPageUrl())) {
                    return redirect()->to($itemMall->previousPageUrl());
                }
            }
        }

        if ($request->has('page_partner')) {
            session()->flash('tab', 'referrals');
            if ($referrals->count() === 0) {
                if (!is_null($referrals->previousPageUrl())) {
                    return redirect()->to($referrals->previousPageUrl());
                }
            }
        }

        if ($request->has('page_redeem')) {
            session()->flash('tab', 'redeem');
            if ($redeems->count() === 0) {
                if (!is_null($redeems->previousPageUrl())) {
                    return redirect()->to($redeems->previousPageUrl());
                }
            }
        }

        if ($request->has('page_activity')) {
            session()->flash('tab', null);
            if ($activities->count() === 0) {
                if (!is_null($activities->previousPageUrl())) {
                    return redirect()->to($activities->previousPageUrl());
                }
            }
        }

        return view('admin', compact('transactions', 'itemMall', 'referrals', 'redeems', 'activities'));
    }

    public function post(Request $request)
    {
        $request->validate([
            'mode' => ['required'],
        ]);

        switch($request->mode) {
            case 'web':
                $request->validate([
                    'cap_level' => ['nullable'],
                    'img_banner' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg'],
                    'img_banner_1' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg'],
                    'img_banner_2' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg'],
                    'img_banner_3' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg'],
                    'img_banner_1_link' => ['nullable', 'url'],
                    'img_banner_2_link' => ['nullable', 'url'],
                    'img_banner_3_link' => ['nullable', 'url'],
                    'img_hero' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg'],
                    'img_login' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg'],
                    'img_logo' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg'],
                    'patch_date' => ['nullable'],
                    'patch_dl_gdrive' => ['nullable', 'url'],
                    'patch_dl_mega' => ['nullable', 'url'],
                    'patch_dl_mfire' => ['nullable', 'url'],
                    'patch_version' => ['nullable'],
                    'rate_drop' => ['nullable'],
                    'rate_exp' => ['nullable'],
                    'rate_gold' => ['nullable'],
                    'rate_party' => ['nullable'],
                    'server_location' => ['nullable'],
                    'server_timezone' => ['nullable'],
                    'social_discord' => ['nullable', 'url'],
                    'social_facebook' => ['nullable', 'url'],
                    'social_instagram' => ['nullable', 'url'],
                ]);

                $data = $request->except('_token', 'mode');
                $save = [];
                foreach ($data as $key => $value) {
                    $setting = WebSettings::where('data', $key)->first();

                    if ($setting == null)
                        return redirect()->back()->withErrors(['msg' => sprintf('Column %s is not found in the database.', $key)]);

                    if ($setting->value == $request->$key)
                        continue;

                    /*
                     * KNOWN ISSUE: Permission on IIS
                     * Set C:/Windows/Temp for everyone can read
                     */
                    switch($key) {
                        case 'img_banner':
                        case 'img_login':
                        case 'img_logo':
                        case 'img_hero':
                            $storagePath = Storage::disk('public')->putFile('img', $request->file($key));
                            $setting->value = '/storage/' . $storagePath;
                            break;
                        case 'img_banner_1':
                        case 'img_banner_2':
                        case 'img_banner_3':
                            $storagePath = Storage::disk('public')->putFile('img/promo-banner', $request->file($key));
                            $setting->value = '/storage/' . $storagePath;
                            break;
                        default:
                            $setting->value = $request->$key;
                            break;
                    }

                    array_push($save, $setting);
                }

                foreach ($save as $field) $field->save();
                $request->session()->flash('status', 'Task was successful!');
                return redirect()->back();
            case 'topup':
                $request->validate([
                    'action' => ['required', 'digits_between:0,1'],
                    'id' => ['required', 'integer', 'exists:App\Models\Invoice,transaction_id'],
                ]);

                $invoice = Invoice::where('transaction_id', $request->id)->first();

                switch($request->action) {
                    case 0:
                        app(DonateController::class)->onPaymentFailed(
                            $invoice->transaction_id,
                            'Top Up',
                            $invoice->price,
                            $invoice->method,
                            null,
                            $invoice->reference,
                            null
                        );

                        activity('admin')
                            ->causedBy(Auth::user())
                            ->performedOn($invoice->getModel())
                            ->event('updated')
                            ->withProperties(['attributes' => ['transactionID' => $invoice->transaction_id]])
                            ->log('Rejected top up payment');
                        break;
                    case 1:
                        app(DonateController::class)->onPaymentSuccess(
                            $invoice->transaction_id,
                            'Top Up',
                            $invoice->price,
                            $invoice->method,
                            null,
                            $invoice->reference,
                            null
                        );

                        activity('admin')
                            ->causedBy(Auth::user())
                            ->performedOn($invoice->getModel())
                            ->event('updated')
                            ->withProperties(['attributes' => ['transactionID' => $invoice->transaction_id]])
                            ->log('Approved top up payment');
                        break;
                }


                $request->session()->flash('status', 'Task was successful!');
                return redirect()->back()->with('tab', 'transactions');;
            case 'malleditor':
                $request->session()->flash('tab', 'itemmall');
                $request->validate([
                    'action' => ['required'],
                ]);

                switch($request->action) {
                    case 0:
                        $request->validate([
                            'id' => ['required', 'integer', 'exists:App\Models\ItemMall,item_id'],
                        ]);

                        $item = ItemMall::find($request->id);
                        $item->delete();

                        $request->session()->flash('status',
                            sprintf('%s was removed successfully from the mall!', $item->name));
                        return redirect()->back();;
                        break;
                    case 1:
                        $request->validate([
                            'itemid' => ['required', 'integer'],
                            'name' => ['required'],
                            'description' => ['required'],
                            'effects' => ['nullable'],
                            'img' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg', 'dimensions:max_width=200,max_height=260'],
                            'category' => ['required', 'integer', 'digits_between:1,6'],
                            'sub_item_name.*' => ['required_with:sub_item_img'],
                            'sub_item_img.*' => ['required_with:sub_item_name', 'file', 'image', 'mimes:jpeg,png,jpg'],
                            'price' => ['required', 'integer'],
                            'quantity' => ['required', 'integer'],
                            'featured_label' => ['required', 'integer'],
                        ]);

                        $storagePath = Storage::disk('public')->putFile('img/store', $request->file('img'));
                        ItemMall::create([
                            'item_id' => $request->itemid,
                            'name' => $request->name,
                            'description' => $request->description,
                            'effects' => $request->effects,
                            'img' => '/storage/' . $storagePath,
                            'category' => $request->category,
                            'price' => $request->price,
                            'min_quantity' => 1,
                            'max_quantity' => $request->quantity,
                            'featured_label' => $request->featured_label,
                        ]);

                        if ($request->category == 4) {
                            $files = $request->file('sub_item_img');
                            for ($i = 0; $i < count($request->sub_item_name); $i++) {
                                $storagePath = Storage::disk('public')->putFile('img/store', $files[$i]);
                                ItemMallChild::create([
                                    'MallItemID' => $request->itemid,
                                    'Name' => $request->sub_item_name[$i],
                                    'Image' => $storagePath,
                                ]);
                            }
                        }

                        $request->session()->flash('status', 'Task was successful!');
                        return response()->json([
                            'message' => 'success',
                        ]);
                    case 2:
                        $request->validate([
                            'name' => ['required'],
                            'description' => ['required'],
                            'effects' => ['required'],
                            'img' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg', 'dimensions:max_width=200,max_height=260'],
                            'category' => ['required', 'integer', 'min:1'],
                            'price' => ['required', 'integer'],
                            'quantity' => ['required', 'integer'],
                            'featured_label' => ['required', 'integer'],
                            'sub_item_name.*' => ['required_with:sub_item_img'],
                            'sub_item_img.*' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg'],
                        ]);

                        $request->validate(['itemid' => ['required', 'exists:App\Models\ItemMall,item_id']]);
                        $item = ItemMall::find($request->itemid);
                        $item->name = $request->name;
                        $item->description = $request->description;
                        $item->effects = $request->effects;

                        if ($request->hasFile('img')) {
                            $storagePath = Storage::disk('public')->putFile('img/store', $request->file('img'));
                            $item->img = '/storage/' . $storagePath;
                        }

                        $index = 0;
                        $subitems = json_decode($request->subitems, true);
                        $files = $request->file('sub_item_img');

                        $itemMallChildDB = itemMallChild::where('MallitemID', $request->itemid)->get();
                        foreach ($itemMallChildDB as $sub) {
                            $found = false;
                            foreach($subitems as $subitem) {
                                if (isset($subitem['id']) && $subitem['id'] == $sub->id) {
                                    $found = true;
                                    break;
                                }
                            }

                            if (!$found) {
                                itemMallChild::destroy($sub->id);
                            }
                        }

                        foreach($subitems as $subitem) {
                            if (isset($subitem['id'])) {
                                // update existing
                                $child = itemMallChild::find($subitem['id']);
                                $child->Name = $subitem['Name'];
                                if ($request->hasFile('sub_item_img.' .  $index)) {
                                    $storagePath = Storage::disk('public')->putFile('img/store', $files[$index]);
                                    $child->Image = $storagePath;
                                }
                                $child->save();
                            } else {
                                // insert new
                                $storagePath = $request->hasFile('sub_item_img.' .  $index)
                                    ? Storage::disk('public')->putFile('img/store', $files[$index])
                                    : $subitem['Image'];

                                ItemMallChild::create([
                                    'MallItemID' => $subitem['MallItemID'],
                                    'Name' => $subitem['Name'],
                                    'Image' => $storagePath,
                                ]);
                            }
                            $index++;
                        }

                        $item->category = $request->category;
                        $item->max_quantity = $request->quantity;
                        $item->price = $request->price;
                        $item->featured_label = $request->featured_label;
                        $item->save();

                        $request->session()->flash('status', 'Task was successful!');
                        return response()->json([
                            'message' => 'success',
                        ]);
                };
                break;
            case 'partnereditor':
                $request->session()->flash('tab', 'referrals');
                $request->validate([
                    'action' => ['required'],
                ]);

                CauserResolver::setCauser(Auth::user());

                switch($request->action) {
                    case 0:
                        $request->validate([
                            'id' => ['required', 'integer', 'exists:App\Models\Partner,userid'],
                        ]);

                        $partner = Partner::where('userid', $request->id)->first();
                        $partner->delete();
                        $request->session()->flash('status', sprintf('Partnership with %s was successfully revoked!', User::find($request->id)->id_loginid));
                        return redirect()->back();;
                    case 1:
                        $user = User::where('id_loginid', $request->name)->first();
                        $request->validate([
                            'name' => [
                                'required',
                                'exists:App\Models\User,id_loginid',
                                function($attribute, $value, $fail) use($request, $user) {
                                    if ($user != null && Partner::where('userid', $user->id_idx)->exists()) {
                                        return $fail(sprintf('The name %s is already in-use.', $request->name));
                                    }
                                }
                            ],
                            'code' => [
                                'required',
                                'unique:App\Models\Partner,code'
                            ],
                            'virtual_money' => [
                                'required',
                                'integer'
                            ],
                        ]);

                        Partner::create([
                            'userid' => $user->id_idx,
                            'code' => $request->code,
                            'virtual_money' => $request->virtual_money,
                        ]);

                        $request->session()->flash('status', 'Task was successful!');
                        return response()->json([
                            'message' => 'success',
                        ]);
                    case 2:
                        $request->validate([
                            'userid' => ['required'],
                            'code' => [
                                'required',
                                Rule::unique(app(Partner::Class)->getTable())
                                    ->ignore($request->userid, 'userid')
                            ],
                            'virtual_money' => ['required', 'integer'],
                        ]);

                        $partner = Partner::where('userid', $request->userid)->first();
                        $partner->code = $request->code;
                        $partner->virtual_money = $request->virtual_money;
                        $partner->save();

                        $request->session()->flash('status', 'Task was successful!');
                        return response()->json([
                            'message' => 'success',
                        ]);
                }
            case 'playereditor':
                $request->session()->flash('tab', 'player');
                $request->validate([
                    'action' => ['required'],
                ]);

                switch($request->action) {
                    case 0:
                        $player = User::where('id_loginid', $request->userid)->first();
                        return response()->json([
                            'player' => $player,
                        ]);
                    case 1:
                        break;
                    case 2:
                        $request->validate([
                            'userid' => ['required', 'exists:App\Models\User,id_idx'],
                            'name' => ['required'],
                            'accesslevel' => ['required', 'integer'],
                            'cashpoints' => ['required', 'integer'],
                        ]);

                        $player = User::find($request->userid);
                        $player->id_loginid = $request->name;
                        $player->UserLevel = $request->accesslevel;
                        $player->UserPointMall = $request->cashpoints;
                        $player->save();

                        $request->session()->flash('status', 'Task was successful!');
                        return response()->json([
                            'message' => 'success',
                        ]);
                }
                break;
            case 'itemdelivery':
                $request->session()->flash('tab', 'items');
                $request->validate([
                    'action' => ['required'],
                    'id' => [
                        'required',
                        function($attribute, $value, $fail) use($request) {
                            if ($request->action == 2) return;
                            $names = json_decode($request->id);
                            foreach ($names as $name) {
                                $user = User::where('id_loginid', $name)->first();
                                if ($user == null) {
                                    return $fail(sprintf('The user %s does not exist in our records.', $name));
                                }
                            }
                        }],
                    'itemid' => ['required', 'integer'],
                    'quantity' => ['required', 'integer'],
                ]);

                switch($request->action) {
                    case 1:
                        $names = json_decode($request->id);
                        foreach ($names as $name) {
                            $userId = User::where('id_loginid', $name)->first()->id_idx;
                            Item::create([
                                'CHARACTER_IDX' => 0,
                                'ITEM_IDX' => $request->itemid,
                                'ITEM_POSITION' => 0,
                                'ITEM_DURABILITY' => $request->quantity,
                                'ITEM_SHOPIDX' => $userId,
                            ]);
                        }
                        break;
                    case 2:
                        $users = User::all(['id_idx']);
                        foreach ($users as $user) {
                            Item::create([
                                'CHARACTER_IDX' => 0,
                                'ITEM_IDX' => $request->itemid,
                                'ITEM_POSITION' => 0,
                                'ITEM_DURABILITY' => $request->quantity,
                                'ITEM_SHOPIDX' => $user->id_idx,
                            ]);
                        }
                        break;
                }

                $request->session()->flash('status', 'Task was successful');
                return redirect()->back();
            case 'report':
                $request->session()->flash('tab', 'report');
                $request->validate([
                    'date_start' => ['required', 'date'],
                    'date_end' => ['required', 'date'],
                ]);

                activity('admin')
                    ->causedBy(Auth::user())
                    ->event('download')
                    ->withProperties(['attributes' => [
                        'date_start' => ['required', 'date'],
                        'date_end' => ['required', 'date'],
                    ]])
                    ->log('Downloaded transaction report');
                return Excel::download(new TransactionExport(
                    $request->date_start,
                    $request->date_end
                ), 'Report.xlsx');
            case 'redeemeditor':
                $request->session()->flash('tab', 'redeem');
                $request->validate([
                    'action' => ['required'],
                ]);

                switch($request->action) {
                    case 0:
                        $request->validate([
                            'id' => ['required', 'exists:App\Models\Redeem,code'],
                        ]);

                        $redeem = Redeem::find($request->id);
                        $redeem->delete();
                        $request->session()->flash('status', sprintf('Redeem code %s was successfully removed!', $request->id));
                        return redirect()->back();;
                    case 1:
                        $request->validate([
                            'code' => ['required',  'unique:App\Models\Redeem,code'],
                            'itemid' => ['required', 'integer'],
                            'quantity' => ['required'],
                        ]);

                        Redeem::create([
                            'code' => $request->code,
                            'itemid' => $request->itemid,
                            'quantity' => $request->quantity,
                        ]);

                        $request->session()->flash('status', 'Task was successful!');
                        return response()->json([
                            'message' => 'success',
                        ]);
                    case 2:
                        $request->validate([
                            'old_code' => ['required',  'exists:App\Models\Redeem,code'],
                            'code' => ['required', 'unique:App\Models\Redeem,code,' . $request->old_code],
                            'itemid' => ['required', 'integer'],
                            'quantity' => ['required'],
                        ]);

                        $item = Redeem::find($request->old_code);
                        $item->code = $request->code;
                        $item->itemid = $request->itemid;
                        $item->quantity = $request->quantity;
                        $item->save();

                        $request->session()->flash('status', 'Task was successful!');
                        return response()->json([
                            'message' => 'success',
                        ]);
                }

                break;
        }
    }
}
