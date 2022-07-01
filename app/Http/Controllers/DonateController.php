<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Royryando\Duitku\Facades\Duitku;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Partner;
use Illuminate\Support\Facades\Redirect;
use Royryando\Duitku\Http\Controllers\DuitkuBaseController;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Helper;

class DonateController extends DuitkuBaseController
{
    public $packages;

    function __construct(array $attributes = [])
    {
        $this->packages = array();
        $this->addPackage(200, 25000, 0);
        $this->addPackage(500, 55000, 0);
        $this->addPackage(1050, 105000, 0);
        $this->addPackage(2100, 200000, 5);
        $this->addPackage(3300, 300000, 10);
        $this->addPackage(5500, 500000, 10);
        $this->addPackage(8250, 750000, 10);
        $this->addPackage(11500, 1000000, 15);
        $this->addPackage(23000, 2000000, 15);
        $this->addPackage(34500, 3000000, 15);
        $this->addPackage(46000, 4000000, 15);
        $this->addPackage(60000, 5000000, 20);
        $this->addPackage(125000, 10000000, 25);
        $this->addPackage(390000, 30000000, 30);

        $this->addPackage(0,15000,0, array (
            'name' => 'Odyssey Adventure Package I',
            'id' => 60000024,
            'quantity' => 1
        ));
        $this->addPackage(0,70000,0, array (
            'name' => 'Odyssey Adventure Package II',
            'id' => 60000025,
            'quantity' => 1
        ));
        $this->addPackage(0,250000,0, array (
            'name' => 'Odyssey Adventure Package III',
            'id' => 60000026,
            'quantity' => 1
        ));

    }

    public static function getPackageDetails($id) {
        $class = new DonateController();
        return $class->packages[$id];
    }

    private function getPackageName($id) {
        $package = $this->packages[$id];
        if (empty($package['item']))
            return sprintf('Top Up +%s', number_format($package['price']));
        else
            return sprintf('%s', $package['item']['name']);
    }

    private function addPackage($CP, $price, $bonus = 0, $items = array()) {
        array_push($this->packages, array (
            'CP' => $CP,
            'price' => $price,
            'bonus' => $bonus,
            'item' => $items,
        ));
    }

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $packages = $this->packages;
        $methods = Duitku::paymentMethods(1000);
        $partner = Partner::where('userid', auth()->user()->id_idx)->first();
        if ($partner) {
            array_push($methods, [
                'code' => 'VM',
                'name'  => sprintf('Virtual Money (Rp. %s)', number_format($partner->virtual_money)),
                'image' => Helper::getSetting('img_logo'),
                'fee'   => 0
            ]);
        }

        array_push($methods, [
            'code' => 'Manual_BCA',
            'name'  => 'BCA Transfer (Manual Verification)',
            'image' => '/storage/img/payment/bca.png',
            'fee'   => 0
        ]);

        array_push($methods, [
            'code' => 'PayPal',
            'name'  => 'PayPal',
            'image' => '/storage/img/payment/paypal.png',
            'fee'   => 0
        ]);

        return view('donate', compact('methods', 'packages'));
    }

    public function payment(Request $request) {
        $request->validate([
            'package' => ['required', 'integer',
                function($attribute, $value, $fail) use($request) {
                    if (!isset($this->packages[$value]))
                        return $fail('Invalid package. If this persists, please contact administrators.');
                }],
            'referral' => [
                function($attribute, $value, $fail) use($request, &$bonus_points) {
                    if (!$request->filled('referral')) return;
                    $partner = Partner::find($request->input('referral'));

                    if (!$partner)
                        return $fail('Can\'t find the referral code in our records.');

                    if ($request->input('payment_method') === 'VM')
                        return $fail('Can\'t use the referral code if you are purchasing with Virtual Money.');
                }],
            'payment_method' => ['required', 'string',
                function($attribute, $value, $fail) use($request, &$bonus_points) {
                    if ($value === 'VM') {
                        $partner = Partner::where('userid', auth()->user()->id_idx)->first();
                        if (!$partner)
                            return $fail('Partner identification failed.  If this persists, please contact administrators.');

                        if ($partner->virtual_money < $this->packages[$request->input('package')]['price'])
                            return $fail('Insufficient funds.');
                    }
                }
            ]
        ]);

        $packg = $request->input('package');
        $cashp = $this->packages[$packg]['CP'];
        $price = $this->packages[$packg]['price'];

        $invoice = new Invoice();
        $invoice->user_id = auth()->user()->id_idx;
        $invoice->package = $packg;
        $invoice->cash_points = $cashp;
        $invoice->price = $price;
        $invoice->method = $request->input('payment_method');

        if ($request->filled('referral')) {
            $invoice->referral_code = $request->input('referral');
            $invoice->bonus_points = 0.1 * $cashp;
        }

        $invoice->save();

        switch ($request->input('payment_method')) {
            case 'VM':
                $partner = Partner::where('userid', auth()->user()->id_idx)->first();
                $partner->virtual_money -= $price;
                $partner->save();

                $invoice->reference = sprintf('VM%018d', $invoice->transaction_id);
                $invoice->payment_url = url()->current();
                $invoice->save();

                $this->onPaymentSuccess(
                    $invoice->transaction_id,
                    $this->getPackageName($invoice->package),
                    $invoice->price,
                    $invoice->method,
                    null,
                    $invoice->reference,
                    null
                );
                return Redirect::to(route('donate.status', ['merchantOrderId' => $invoice->transaction_id]));
            case 'Manual_BCA':
                $invoice->reference = sprintf('BCA%017d', $invoice->transaction_id);
                $invoice->payment_url = route('donate.status', ['merchantOrderId' => $invoice->transaction_id]);
                $invoice->save();

                return Redirect::to(route('donate.status', ['merchantOrderId' => $invoice->transaction_id]));
            case 'PayPal':
                $provider = new PayPalClient;
                $provider->setApiCredentials(config('paypal')); // Pull values from Config
                $token = $provider->getAccessToken();
                $provider->setAccessToken($token);

                $price = round($invoice->price / 15000, 2);
                $currency = 'USD';

                $order = $provider->createOrder([
                    'intent' => 'CAPTURE',
                    'purchase_units' => [[
                        'reference_id' => $invoice->transaction_id,
                        'description' => 'In-game currency purchase.',
                        'amount' => [
                            'currency_code' => $currency,
                            'value' => $price,
                            'breakdown' => [
                                'item_total' => [
                                    'value' => $price,
                                    'currency_code' => $currency
                                ]
                            ],
                        ],
                        'items' => [[
                            'name' => $this->getPackageName($invoice->package),
                            'description' => 'In-game currency purchase.',
                            'unit_amount' => [
                                'value' => $price,
                                'currency_code' => $currency
                            ],
                            'quantity' => 1,
                            'category' => 'DIGITAL_GOODS'
                        ]]
                    ]],
                    'application_context' => [
                        'cancel_url' => env('PAYPAL_CANCEL_URL'),
                        'return_url' => env('PAYPAL_RETURN_URL'),
                        'brand_name' => env('APP_NAME'),
                        'shipping_preference' => 'NO_SHIPPING',
                    ]
                ]);

                // Store Token so we can retrieve after PayPal sends them back to us
                $invoice->reference = $order['id'];
                $invoice->save();

                // Send user to PayPal to confirm payment
                return Redirect::to($order['links'][1]['href']);
            default:
                $response = Duitku::createInvoice(
                    (string) $invoice->transaction_id,
                    $invoice->price,
                    $invoice->method,
                    $this->getPackageName($invoice->package),
                    auth()->user()->id_loginid,
                    auth()->user()->id_email,
                    30);

                if (!$response['success'])
                    return Redirect::back()->withErrors(['msg', $response['message']]);

                $invoice->reference = $response['reference'];
                $invoice->payment_url = $response['payment_url'];
                $invoice->save();

                return Redirect::to($invoice->payment_url);
        }
    }

    public function paypalCancel(Request $request) {
        $invoice = Invoice::where('reference', $request->input('token'))->first();
        if ($invoice && $invoice->user_id == auth()->user()->id_idx && $invoice->code != '00') {
            $this->onPaymentFailed(
                $invoice->transaction_id,
                $this->getPackageName($invoice->package),
                $invoice->price,
                $invoice->method,
                null,
                $invoice->reference,
                null
            );

            return Redirect::to(route('donate.status', ['merchantOrderId' => $invoice->transaction_id]));
        }

        return abort(500);
    }

    public function paypalCapture(Request $request) {
        $invoice = Invoice::where('reference', $request->input('token'))->first();
        if ($invoice && $invoice->user_id == auth()->user()->id_idx) {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);
            $order = $provider->capturePaymentOrder($invoice->reference);

            // TODO: add log if 'status' is not present
            if (array_key_exists("status", $order) && $order['status'] === "COMPLETED") {
                $this->onPaymentSuccess(
                    $invoice->transaction_id,
                    $this->getPackageName($invoice->package),
                    $invoice->price,
                    $invoice->method,
                    null,
                    $invoice->reference,
                    null
                );
            }

            return Redirect::to(route('donate.status', ['merchantOrderId' => $invoice->transaction_id]));
        }

        return abort(500);
    }

    public function invoice(Request $request) {
        $invoice = Invoice::find($request->input('merchantOrderId'));
        if ($invoice && $invoice->user_id == auth()->user()->id_idx)
            return view('donate-status', compact('invoice'));

        return abort(404);
    }

    public function onPaymentSuccess(string $orderId, string $productDetail, int $amount, string $paymentCode,
                                        ?string $shopeeUserHash, string $reference, ?string $additionalParam): void
    {
        $invoice = Invoice::where('transaction_id', $orderId)->first();
        if (!$invoice) return;
        if ($invoice->status_code == 00) return;
        $invoice->status_code = '00';
        $invoice->save();

        $partner = Partner::find($invoice->referral_code);
        if ($partner) {
            $partner->virtual_money += 0.1 * $invoice->price;
            $partner->save();
        }

        $user = User::find($invoice->user_id);
        $user->UserPointMall += $invoice->cash_points;
        $user->UserPointMall += $invoice->bonus_points;
        $user->save();

        $item = $this->packages[$invoice->package]['item'];
        if (!empty($item)) {
            Item::create([
                'CHARACTER_IDX' => 0,
                'ITEM_IDX' => $item['id'],
                'ITEM_POSITION' => 0,
                'ITEM_DURABILITY' => $item['quantity'],
                'ITEM_SHOPIDX' => $invoice->user_id,
            ]);
        }
    }

    public function onPaymentFailed(string $orderId, string $productDetail, int $amount, string $paymentCode,
                                       ?string $shopeeUserHash, string $reference, ?string $additionalParam): void
    {
        $invoice = Invoice::where('transaction_id', $orderId)->first();
        if (!$invoice) return;
        $invoice->status_code = '02';
        $invoice->save();
        /*
         * Transaction failed, just delete
         */
        //$invoice->delete();
    }

    public function myReturnCallback() {
        return 'You can close this page';
    }
}
