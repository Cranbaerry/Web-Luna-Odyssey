@extends('layouts.main')
@section('content')
    <div class="row tile p-4 mx-0 my-4">
        <div class="col">
            <x-auth-validation-errors class="alert alert-danger" role="alert" :errors="$errors" />
            <x-auth-session-status class="alert alert-success" :status="session('status')" />
            <div class="subtitle">Dashboard</div>
            <div class="article pb-3" style="text-indent: 0;">Here you can find your account information, update details, and billing history.</div>

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-link @if (Session::get('tab') === null) active @endif" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="false">Profile</a>
                    <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">Security</a>
                    <a class="nav-link @if (Session::get('tab') == 'invoice') active @endif" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Top Up History</a>
                    <a class="nav-link @if (Session::get('tab') == 'itemmall') active @endif" id="nav-itemmall-tab" data-toggle="tab" href="#nav-itemmall" role="tab" aria-controls="nav-itemmall" aria-selected="false">Item Mall Log</a>
                    <a class="nav-link @if (Session::get('tab') == 'redeem') active @endif" id="nav-redeem-tab" data-toggle="tab" href="#nav-redeem" role="tab" aria-controls="nav-redeem" aria-selected="false">Redeem Special Codes</a>
                    <a class="nav-link @if (Session::get('tab') == 'tiered') active @endif" id="nav-tiered-tab" data-toggle="tab" href="#nav-tiered" role="tab" aria-controls="nav-tiered" aria-selected="false">Tiered Spender</a>
                </div>
            </nav>
            <div class="tab-content pt-3 px-3" id="nav-tabContent">
                <div class="tab-pane fade  @if (Session::get('tab') === null) active show @endif" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
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

                    <div class="form-group row px-3 pt-3">
                        <label class="pb-2">List of characters</label>


                        <table class="table pt-1 mb-0">
                            <thead>
                            <tr>
                                <th scope="col" >Name</th>
                                <th scope="col">Job</th>
                                <th scope="col" class="text-center">Job level</th>
                                <th scope="col">Location</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach (App\Models\Character::where('USER_IDX', Auth::user()->id_idx)->get() as $char)
                                <tr>
                                    <td style="width: 25%">{{ $char->CHARACTER_NAME }}</td>
                                    <td style="width: 25%">{{ $char->getCurrentJob() }}</td>
                                    <td class="text-center" >{{ $char->CHARACTER_JOB }}</td>
                                    <td style="width: 20%">
                                        <div class="btn-group dropleft">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{ $char->getCurrentMap() }}
                                            </button>
                                            <div class="dropdown-menu">
                                                @foreach($char->getMapsList() as $key => $value)
                                                    <a class="dropdown-item user-map" data-map="{{ $key  }}" data-char="{{ $char->CHARACTER_IDX }}">{{ $value }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <form id="form-password">
                        @csrf
                        <div class="form-group row">
                            <label for="inputPassword1" class="col-sm-2 col-form-label">Old Password</label>
                            <div class="col-sm-10">
                                <input name="old_password" type="password" class="form-control" id="inputPassword1" placeholder="Old Password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">New Password</label>
                            <div class="col-sm-10">
                                <input name="id_passwd" type="password" class="form-control" id="inputPassword3" placeholder="New Password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword4" class="col-sm-2 col-form-label">Confirm Password</label>
                            <div class="col-sm-10">
                                <input name="id_passwd_confirmation" type="password" class="form-control" id="inputPassword4" placeholder="Confirm Password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="mx-auto">
                                <button id="btn-password" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade @if (Session::get('tab') === 'invoice') active show @endif" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="form-group row p-3">
                        <div class="article pb-3" style="text-indent: 0;">This is your purchase history recorded by the system. If you find any issues, please contact administrator on discord.<br /> ** Untuk transfer manual BCA, mohon kirimkan bukti transfer transaksi anda ke staff via <a href="{{ Helper::getSetting('social_discord') }}">Discord</a> untuk memperlancar proses transaksi.</div>
                        <div class="table-responsive">
                            <table class="table pt-1">
                                <thead>
                                <tr>
                                    <th scope="col">Date Issued</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Payment Method</th>
                                    <th scope="col" class="text-center">Price</th>
                                    <th scope="col" class="text-center">Cash Points</th>
                                    <th scope="col" class="text-center">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $data)
                                    <tr>
                                        <td>{{ $data->date_created }}</td>
                                        <td><a href="{{ route('donate.status', ['merchantOrderId' => $data->transaction_id]) }}">{{ $data->reference }}</a></td>
                                        <td>{{ $data->getPaymentMethod() }}</td>

                                        <td class="text-center">Rp. {{ number_format($data->price) }}</td>
                                        <td class="text-center">{{ number_format($data->cash_points) }}</td>

                                        @switch($data->status_code)
                                            @case('00')
                                            <td class="text-center"><span class="badge badge-success">Success</span></td>
                                            @break
                                            @case('01')
                                            <td class="text-center"><span class="badge badge-warning">Pending</span></td>
                                            @break
                                            @case('02')
                                            <td class="text-center"><span class="badge badge-danger">Canceled</span></td>
                                            @break
                                        @endswitch

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center w-100">
                            {!! $transactions->appends(['item_mall' => $itemlog->currentPage()])->links() !!}
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade @if (Session::get('tab') === 'itemmall') active show @endif" id="nav-itemmall" role="tabpanel" aria-labelledby="nav-itemmall-tab">
                    <div class="form-group row p-3">
                        <div class="article pb-3" style="text-indent: 0;">This is your item mall log recorded by the system. If you find any issues, please contact administrator on discord.</div>
                        <div class="table-responsive">
                            <table class="table pt-1">
                                <thead>
                                <tr>
                                    <th scope="col">Date Issued</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col" >Type</th>
                                    <th scope="col" class="text-center">Quantity</th>
                                    <th scope="col" class="text-center">Price</th>
                                    <th scope="col" class="text-center">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($itemlog as $data)
                                    <tr>
                                        <td>{{ $data->date_purchased }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{!! $data->is_reward ? '<span class="badge badge-info">Royalty Reward</span>' : '<span class="badge badge-pill badge-secondary">Item Mall</span>' !!}</td>
                                        <td class="text-center">{{ $data->quantity }}</td>
                                        <td class="text-center">{{ number_format($data->price) }}</td>
                                        <td class="text-center">{{ number_format($data->total) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center w-100">
                            {!! $itemlog->appends(['invoice' => $transactions->currentPage()])->links() !!}
                        </div>
                    </div>
                </div>


                <div class="tab-pane fade @if (Session::get('tab') === 'redeem') active show @endif" id="nav-redeem" role="tabpanel" aria-labelledby="nav-redeem-tab">
                    <form method="POST" action="{{ route('redeem') }}">
                        @csrf
                        <div class="form-row align-items-center mb-5 mt-2">
                            <label class="col-sm-2 col-form-label">Code</label>
                            <div class="col-sm-8">
                                <input placeholder="Enter the redeem code to claim your rewards" type="text" name="code" class="form-control" value="{{ old('userid') }}">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary" onclick="showPlayerEditor(this);">Claim</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade @if (Session::get('tab') === 'tiered') active show @endif" id="nav-tiered" role="tabpanel" aria-labelledby="nav-tiered-tab">
                    <h1 class="display-4">{{ Helper::getSetting('tiered_spender_title') }}</h1>
                    <p class="lead text-justify">The Tiered Spender is the ultimate loyalty reward system. To put it simply; we reward you for the purchases you make. This means that the more you spend on {{ Config::get('app.name') }} the more we want to thank you, and we do that by giving you awesome items!</p>
                    <hr class="my-4">
                        <div class="row spending-highlight">
                            <div class="col-6">
                                <div class="float-left">
                                    <span class="lead" style="font-size: 1.1rem;">Your current spending this month: <b>{{ number_format($freeRewards->topUpAccumulation) }} IDR</b></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <span class="lead" style="font-size: 1.1rem;">This event ends in <b>{{ round((Helper::getSetting('tiered_spender_end') - time()) / (60 * 60 * 24)) }}</b> days</span>
                                </div>
                            </div>
                        </div>

                    <div id="step-progressbar-1" class="p-3"></div>

                    <ul class="nav nav-tabs nav-fill pt-3 mb-3" id="pills-tab" role="tablist">
                        @foreach ($freeRewards->tiers as $index => $tier)
                        <li class="nav-item">
                            <a class="nav-link @if($index == 0)active @endif" id="pills-tier{{$index+1}}-tab" data-toggle="pill" href="#pills-tier{{$index+1}}" role="tab" aria-controls="pills-tier{{$index+1}}" @if($index == 0)aria-selected="true"@endif>Tier {{$index+1}} @if($freeRewards->topUpAccumulation < $tier->goal)<span class="badge badge-danger"><i class="fas fa-lock"></i> Locked</span>@elseif($tier->claimed)<span class="badge badge-primary"><i class="fas fa-check-circle"></i> Redeemed</span>@endif</a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        @foreach ($freeRewards->tiers as $index => $tier)
                        <div class="tab-pane fade @if($index == 0)show active @endif text-center" id="pills-tier{{$index+1}}" role="tabpanel" aria-labelledby="pills-tier{{$index+1}}-tab">
                            <form method="POST" action="{{ route('tiered.spender') }}">
                                @csrf
                                <input type="hidden" name="tier_id" value="{{ $tier->id }}">
                                <p>Choose one reward from the following options</p>
                                <div class="row">
                                    @foreach ($tier->rewards as $reward)
                                        <div class="col-lg-3 col-sm-12 col-md-6 mb-4 grid-item">
                                            <div class="custom-control custom-radio image-checkbox card">
                                                <input type="radio" class="custom-control-input" id="reward-id-{{ $reward->id }}" name="reward_id" value="{{ $reward->id }}">
                                                <label class="custom-control-label" for="reward-id-{{ $reward->id }}" data-toggle="tooltip" data-placement="top" title="{{ $reward->name }}">

                                                    <img src="{{ asset("storage/" . $reward->image_link) }}" alt="#" class="img-fluid pt-1">
{{--                                                    <div class="card-body" style="background-color: #6c757d; padding: 5px; color: white;">--}}
{{--                                                        <h5 class="card-title card-shop-title">{{ $reward->name }}</h5>--}}
{{--                                                    </div>--}}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row pt-4">
                                    <div class="col text-center">
                                        <button type="submit" class="btn btn-primary" onclick="showPlayerEditor(this);" @if($freeRewards->topUpAccumulation < $tier->goal || $tier->claimed) disabled @endif>Redeem</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        window.onload = function () {
            $(function() {
                $.fn.isInViewport = function() {
                    var elementTop = $(this).offset().top;
                    var elementBottom = elementTop + $(this).outerHeight();

                    var viewportTop = $(window).scrollTop();
                    var viewportBottom = viewportTop + $(window).height();

                    return elementBottom > viewportTop && elementTop < viewportBottom;
                };

                $('#step-progressbar-1').stepProgressBar({
                    {{--currentValue: {{ $freeRewards->topUpAccumulation }},--}}
                    currentValue: 0,
                    steps: [
                            @foreach ($freeRewards->tiers as $index => $tier)
                        {
                            value: {{ $tier->goal }},
                            bottomLabel: '<i class="material-icons">Tier {{ $index + 1 }}</i>'
                        },
                        @endforeach
                    ],
                    unit: ' IDR'
                });

                $(".image-checkbox").click( function(){
                    $(".image-checkbox.active").removeClass("active");

                    $(this).addClass("active");
                });

                $(window).on('resize scroll', function() {
                    if ($('#step-progressbar-1').isInViewport()) {
                        $('#step-progressbar-1').stepProgressBar('setCurrentValue', {{ $freeRewards->topUpAccumulation }});
                    }
                });


                @foreach ($freeRewards->tiers as $index => $tier)
                    @if(!$tier->claimed && $freeRewards->topUpAccumulation >= $tier->goal)
                        $('#pills-tier{{$index+1}}-tab').tab('show');
                        @break
                    @endif
                @endforeach

            });
        }
    </script>
@stop
