@extends('layouts.main')
@section('content')
    <div class="row tile p-4 mx-0 my-4">
        <div class="col m-auto  w-100">
            <x-auth-validation-errors class="alert alert-danger" role="alert" :errors="$errors" />

            @if($invoice->method === 'Manual_BCA')
            <div class="subtitle">Bank Transfer Informations</div>
            <div class="article" style="text-indent: 0;">Silahkan melakukan pembayaran dengan informasi bank tujuan dibawah ini. <br/> Proses verifikasi ini akan dilakukan secara manual dengan estimasi paling lama 1 x 24 jam.<br /> Untuk transfer manual BCA, mohon kirimkan bukti transfer transaksi anda ke staff via <a href="{{ Helper::getSetting('social_discord') }}">Discord</a> untuk memperlancar proses transaksi.</div>
            <div class="form-group row">
                <label for="staticTID" class="col-sm-2 col-form-label">Bank Name</label>
                <div class="col">
                    <input type="text" readonly class="form-control-plaintext" id="staticTID" value="BCA">
                </div>
            </div>
            <div class="form-group row">
                <label for="date-c" class="col-sm-2 col-form-label">Bank Number</label>
                <div class="col">
                    <input type="text" readonly class="form-control-plaintext" id="date-c" value="7610690828">
                </div>
            </div>

            <div class="form-group row">
                <label for="staticTID" class="col-sm-2 col-form-label">On Behalf Of</label>
                <div class="col">
                    <input type="text" readonly class="form-control-plaintext" id="staticTID" value="Rendy Valery Kilapong">
                </div>
            </div>

            <div class="form-group row">
                <label for="method" class="col-sm-2 col-form-label">Total Due</label>
                <div class="col">
                    <input type="text" readonly class="form-control-plaintext" id="method" value="Rp. {{  number_format($invoice->price) }}">
                </div>
            </div>
            @endif

            <div class="subtitle">Transaction Details</div>
            <div class="article" style="text-indent: 0;">HATI - HATI Penipuan yang mengatasnamakan {{ Config::get('app.name') }}, semua informasi / media pembayaran kami hanya yang tersedia di website ini, silahkan laporkan apabila menemukan indikasi penipuan yang mengatasnamakan {{ Config::get('app.name') }} ke administrator.</div>
{{--            <div class="form-group row">--}}
{{--                <label for="staticTID" class="col-sm-2 col-form-label">Transaction ID</label>--}}
{{--                <div class="col">--}}
{{--                    <input type="text" readonly class="form-control-plaintext" id="staticTID" value=" {{ $invoice->transaction_id }}">--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="form-group row">
                <label for="staticTID" class="col-sm-2 col-form-label">Reference ID</label>
                <div class="col">
                    <input type="text" readonly class="form-control-plaintext" id="staticTID" value=" {{ $invoice->reference }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="method" class="col-sm-2 col-form-label">Payment Method</label>
                <div class="col">
                    <input type="text" readonly class="form-control-plaintext" id="method" value="{{ $invoice->getPaymentMethod() }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="date-c" class="col-sm-2 col-form-label">Date</label>
                <div class="col">
                    <input type="text" readonly class="form-control-plaintext" id="date-c" value="{{ $invoice->date_created }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="date-u" class="col-sm-2 col-form-label">Last Updated</label>
                <div class="col">
                    <input type="text" readonly class="form-control-plaintext" id="date-u" value="{{ $invoice->date_updated }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="staticAm" class="col-sm-2 col-form-label">Cash Points</label>
                <div class="col">
                    <input type="text" readonly class="form-control-plaintext" id="staticAm" value="{{ number_format($invoice->cash_points) }} CP">
                </div>
            </div>

            @if(!empty(App\Http\Controllers\DonateController::getPackageDetails($invoice->package)['item']))
                <div class="form-group row">
                    <label for="item" class="col-sm-2 col-form-label">Item</label>
                    <div class="col">
                        <input type="text" readonly class="form-control-plaintext" id="item" value="{{ App\Http\Controllers\DonateController::getPackageDetails($invoice->package)['item']['name'] }}">
                    </div>
                </div>
            @endif

            <div class="form-group row">
                <label for="staticP" class="col-sm-2 col-form-label">Price</label>
                <div class="col">
                    <input type="text" readonly class="form-control-plaintext" id="staticP" value="Rp. {{ number_format($invoice->price) }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="staticAm" class="col-sm-2 col-form-label">Payment Status</label>
                <div class="col">
                    @switch($invoice->status_code)
                        @case('00')
                        <input type="text" readonly class="form-control-plaintext text-success" id="staticAm" value="Success">
                        @break
                        @case('01')
                        <input type="text" readonly class="form-control-plaintext text-warning" id="staticAm" value="Pending">
                        @break
                        @case('02')
                        <input type="text" readonly class="form-control-plaintext text-danger" id="staticAm" value="Canceled">
                        @break
                    @endswitch
                </div>
            </div>


            <div class="form-group row">
                <div class="mx-auto">
                    <a href="{{ route('dashboard', ['tab' => 'purchase'])  }}" class="btn btn-secondary">Top Up History</a></a>
                    <a href="@if($invoice->status_code == '01'){{ $invoice->payment_url }}@else # @endif" @if($invoice->status_code == '01') target="_blank" @endif class="btn btn-primary @if($invoice->status_code != '01') btn-disable @endif">Payment URL</a>
                </div>
            </div>
        </div>
    </div>
@stop
