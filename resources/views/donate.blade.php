@extends('layouts.main')
@section('content')
    <div class="row tile p-4 mx-0 my-4">
        <div class="col">
            <form method="POST" class="m-auto  w-100" action="{{ route('donate') }}">
                @csrf
                <x-auth-validation-errors class="alert alert-danger" role="alert" :errors="$errors" />
                <div class="subtitle">Top Up</div>
                <div class="article" style="text-indent: 0;">{{ Config::get('app.name') }} hanya menyediakan donasi dalam bentuk Cash Points.</div>
                <div class="article pb-3" style="text-indent: 0;">HATI - HATI Penipuan yang mengatasnamakan {{ Config::get('app.name') }}, semua informasi / media pembayaran kami hanya yang tersedia di website ini, silahkan laporkan apabila menemukan indikasi penipuan yang mengatasnamakan {{ Config::get('app.name') }} ke administrator.</div>
                <div class="form-group row">
                    <label for="inputUser" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input name="id_loginid" type="name" class="form-control" id="inputUser" placeholder="Username" value="{{ Auth::user()->id_loginid }}" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input name="id_email" type="email" class="form-control" id="inputEmail3" placeholder="E-mail address" value="{{ Auth::user()->id_email }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputAmount" class="col-sm-2 col-form-label">Item</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="inputAmount" name="package">
                            @foreach($packages as $key => $data)
                                @if(empty($data['item']))
                                    <option value="{{ $key }}" @if(Request::old("package") == $key) selected @endif>{{ number_format($data['CP']) }} CP - Rp. {{ number_format($data['price']) }} @if($data['bonus'] > 0) ({{ $data['bonus'] }}% bonus) @endif</option>
                                @else
                                    <option value="{{ $key }}" @if(Request::old("package") == $key) selected @endif>
                                        {{ $data['item']['name'] }} - Rp. {{ number_format($data['price']) }} @if($data['bonus'] > 0) ({{ $data['bonus'] }}% bonus) @endif
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputAmount" class="col-sm-2 col-form-label my-auto">Payment Method</label>
                    <div class="col-sm-10">
                        <select class="form-select selectpicker w-100" name="payment_method" data-live-search="true">
                            @foreach($methods as $key => $method)
                                <option {{ (Request::old("payment_method") == $method['code'] ? 'selected' : '') }} id="payment_method_{{$key}}" value="{{ $method['code'] }}" data-content="
                                    <div class='row'>
                                        <div class='col align-self-center py-2'>
                                         <img class='img-fluid' alt='{{ $method['image'] }}' src='{{ asset("storage/img/payment/". $method['code'] . ".png") }}' style='height: 50px;'></img>
{{--                                            <img class='img-fluid' src='{{ $method['image'] }}' style='height: 50px;'></img>--}}
                                        </div>
                                        <div class='col align-self-center pr-5'>
                                            <span class='bank-item'>{{ $method['name'] }}</span>
                                        </div>
                                    </div>
                                "></option>

                            @endforeach
                        </select>
                        <p>
                            <small class="form-text text-muted pl-1">
                                Untuk pembayaran melalui bank BCA, anda dapat memilih <strong>VA ATM Bersama</strong> untuk proses verifikasi otomatis dari sistem yang lebih cepat dengan estimasi paling lama 30 menit. Jika anda memilih <strong>BCA Transfer (Manual Verification)</strong>, silahkan kirimkan bukti transfer via Discord, dan mohon luangkan waktu lebih panjang untuk Admin kami memproses manual pembayaran anda.
                           </small>
                        </p>

                        <p>
                            <small class="form-text text-muted pl-1">
                                Untuk pembayaran dari bank lain selain partner terdaftar kami, mohon pilih <strong>VA ATM Bersama</strong> sebagai opsi pembayaran karena sudah bekerja sama dengan <a href="https://www.atmbersama.com/news/detail/ini-dia-daftar-bank-anggota-atm-bersama-catat-ya" target="_blank">berbagai bank di Indonesia</a>. Biaya transfer antar bank akan dikenakan sesuai ketentuan masing-masing bank yang berlaku.
                            </small>
                        </p>

                        <p>
                            <small class="form-text text-muted pl-1">
                                All payment options <b>excluding</b> PayPal are only available to Indonesian users.
                                For international users, please choose PayPal.
                            </small>
                        </p>

                        <p>
                            <small class="form-text text-muted pl-1">
                                <b>About Visa/Mastercard (credit card option):</b><br />
                                Credit Card payment option is only available for Indonesian Card, with a maximum of IDR 1.000.000 per transaction. <br />
                                For International Credit Card or transaction over IDR 1.000.000, please use Credit Card option through PayPal.
                            </small>
                        </p>

                    </div>

                </div>

                <div class="form-group row">
                    <label for="inputCode" class="col-sm-2 col-form-label">Referral Code</label>
                    <div class="col-sm-10">
                        <input name="referral" type="name" class="form-control" id="inputCode" placeholder="Enter Referral Code (optional)" value="">
                    </div>
                </div>


                <div class="form-group row">
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary">Buy Now</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
