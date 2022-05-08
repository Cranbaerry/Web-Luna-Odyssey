<?php

namespace App\Http\Controllers;

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
    protected $packages;

    function __construct(array $attributes = [])
    {
        $this->packages = array();

        $this->packages[0]['CP'] = 200;
        $this->packages[0]['price'] = 25000;
        $this->packages[0]['bonus'] = 0;

        $this->packages[1]['CP'] = 500;
        $this->packages[1]['price'] = 55000;
        $this->packages[1]['bonus'] = 0;

        $this->packages[2]['CP'] = 1050;
        $this->packages[2]['price'] = 105000;
        $this->packages[2]['bonus'] = 0;

        $this->packages[3]['CP'] = 2100;
        $this->packages[3]['price'] = 200000;
        $this->packages[3]['bonus'] = 5;

        $this->packages[4]['CP'] = 3300;
        $this->packages[4]['price'] = 300000;
        $this->packages[4]['bonus'] = 10;

        $this->packages[5]['CP'] = 5500;
        $this->packages[5]['price'] = 500000;
        $this->packages[5]['bonus'] = 10;

        $this->packages[6]['CP'] = 8250;
        $this->packages[6]['price'] = 750000;
        $this->packages[6]['bonus'] = 10;

        $this->packages[7]['CP'] = 11500;
        $this->packages[7]['price'] = 1000000;
        $this->packages[7]['bonus'] = 15;

        $this->packages[8]['CP'] = 23000;
        $this->packages[8]['price'] = 2000000;
        $this->packages[8]['bonus'] = 15;

        $this->packages[9]['CP'] = 34500;
        $this->packages[9]['price'] = 3000000;
        $this->packages[9]['bonus'] = 15;

        $this->packages[10]['CP'] = 46000;
        $this->packages[10]['price'] = 4000000;
        $this->packages[10]['bonus'] = 15;

        $this->packages[11]['CP'] = 60000;
        $this->packages[11]['price'] = 5000000;
        $this->packages[11]['bonus'] = 20;

        $this->packages[12]['CP'] = 125000;
        $this->packages[12]['price'] = 10000000;
        $this->packages[12]['bonus'] = 25;

        $this->packages[13]['CP'] = 390000;
        $this->packages[13]['price'] = 30000000;
        $this->packages[13]['bonus'] = 30;
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
                    sprintf('Top Up +%s', number_format($invoice->price)),
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
                            'name' => sprintf('Top Up +%s', number_format($invoice->price)),
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
                    sprintf('Top Up +%s', number_format($invoice->price)),
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
                sprintf('Top Up +%s', number_format($invoice->price)),
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
            if ($order['status'] === "COMPLETED") {
                $this->onPaymentSuccess(
                    $invoice->transaction_id,
                    sprintf('Top Up +%s', number_format($invoice->price)),
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
