@extends('layouts.main')
@section('content')
@php($showTopUp = (boolean) Helper::getSetting('topup_ranking_status'))

    <div class="row tile p-4 mx-0 my-4">
        @if(!$showTopUp && Helper::isAdmin())
            <div class="col col-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Only you can see top up ranking!</strong>
                    <div>The ranking for donation is currently disabled in the admin panel.</div>
                    <button type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        <div class="col col-lg-3 col-md-4 col-sm-5 mb-2">


            <div class="nav flex-column nav-pills " id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link nav-rank-item d-flex {{ $showTopUp ? 'active':  null}}" id="v-pills-topup-tab" data-toggle="pill" href="#v-topup-guild" role="tab" aria-controls="v-topup-guild" aria-selected="{{ $showTopUp ? 'true' : 'false'}}">
                    <img src="{{ asset("storage/img/badge/badge_transaction.png") }}" style="width: 65px" class="float-left " alt="Responsive image">
                    <span class="pl-2 align-self-center font-weight-bold">Top Up</span>
                </a>

                <a class="nav-link nav-rank-item d-flex {{ $showTopUp ? null :  'active'}}" id="v-pills-fighter-tab" data-toggle="pill" href="#v-pills-fighter" role="tab" aria-controls="v-pills-fighter" aria-selected="{{ $showTopUp ? 'false' : 'true'}}">
                    <img src="{{ asset("storage/img/badge/badge_fighter.png") }}" style="width: 65px" class="float-left " alt="Responsive image">
                    <span class="pl-2 align-self-center font-weight-bold">Fighter</span>
                </a>
                <a class="nav-link nav-rank-item d-flex" id="v-pills-rogue-tab" data-toggle="pill" href="#v-pills-rogue" role="tab" aria-controls="v-pills-rogue" aria-selected="false">
                    <img src="{{ asset("storage/img/badge/badge_rogue.png") }}" style="width: 65px" class="float-left " alt="Responsive image">
                    <span class="pl-2 align-self-center font-weight-bold">Rogue</span>
                </a>
                <a class="nav-link nav-rank-item d-flex" id="v-pills-mage-tab" data-toggle="pill" href="#v-pills-mage" role="tab" aria-controls="v-pills-mage" aria-selected="false">
                    <img src="{{ asset("storage/img/badge/badge_mage.png") }}" style="width: 65px" class="float-left " alt="Responsive image">
                    <span class="pl-2 align-self-center font-weight-bold">Mage</span>
                </a>

                <a class="nav-link nav-rank-item d-flex" id="v-pills-guild-tab" data-toggle="pill" href="#v-pills-guild" role="tab" aria-controls="v-pills-guild" aria-selected="false">
                    <img src="{{ asset("storage/img/badge/badge_guild.png") }}" style="width: 65px" class="float-left " alt="Responsive image">
                    <span class="pl-2 align-self-center font-weight-bold">Guild</span>
                </a>
            </div>
        </div>
        <div class="col col-lg-9 col-md-8 col-sm-7">
            <div class="tab-content" id="v-pills-tabContent">


                <div class="tab-pane fade show {{ $showTopUp ? 'active':  null}}" id="v-topup-guild" role="tabpanel" aria-labelledby="v-pills-topup-tab">
                    <nav>
                        <div class="row nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="col nav-link text-center active" id="nav-guildrank-tab" data-toggle="tab" href="#nav-guildrank" role="tab" aria-controls="nav-guildrank" aria-selected="true">Donation Ranking between {{ date("d/m/y", Helper::getSetting('topup_ranking_start')) }} and {{ date("d/m/y", Helper::getSetting('topup_ranking_end')) }}</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-guildrank" role="tabpanel" aria-labelledby="nav-guildrank-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col">User ID</th>
                                        <th scope="col" class="text-center">Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (App\Models\Invoice::select('user_id', DB::raw('SUM(price) as Amount'))
                                               ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                               ->groupBy('user_id')
                                               ->orderBy('Amount', 'DESC')
                                               ->where('status_code', '==', '00')
                                               ->whereRaw('DATEDIFF(SECOND,\'1970-01-01\', date_created) BETWEEN ? AND ?', [Helper::getSetting('topup_ranking_start'), Helper::getSetting('topup_ranking_end')])
                                               ->take(50)
                                               ->get() as $data)

                                        <tr>
                                            <th scope="row" class="text-center">#{{ $loop->index + 1 }}</th>
                                            <td class="text-left">{{ App\Models\User::find($data->user_id)->id_loginid }}</td>
                                            <td class="text-center">Rp. {{ number_format($data->Amount) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="tab-pane fade show {{ $showTopUp ? null:  'active'}}" id="v-pills-fighter" role="tabpanel" aria-labelledby="v-pills-fighter-tab">
                    <nav>
                        <div class="row nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="col nav-link text-center active" id="nav-paladin-tab" data-toggle="tab" href="#nav-paladin" role="tab" aria-controls="nav-paladin" aria-selected="true">Paladin</a>
                            <a class="col nav-link text-center" id="nav-panzer-tab" data-toggle="tab" href="#nav-panzer" role="tab" aria-controls="nav-panzer" aria-selected="false">Panzer</a>
                            <a class="col nav-link text-center" id="nav-crusader-tab" data-toggle="tab" href="#nav-crusader" role="tab" aria-controls="nav-crusader" aria-selected="false">Crusader</a>
                            <a class="col nav-link text-center" id="nav-destroyer-tab" data-toggle="tab" href="#nav-destroyer" role="tab" aria-controls="nav-destroyer" aria-selected="false">Destroyer</a>
                            <a class="col nav-link text-center" id="nav-swordmaster-tab" data-toggle="tab" href="#nav-swordmaster" role="tab" aria-controls="nav-swordmaster" aria-selected="false">Sword Master</a>
                            <a class="col nav-link text-center" id="nav-magnus-tab" data-toggle="tab" href="#nav-magnus" role="tab" aria-controls="nav-magnus" aria-selected="false">Magnus</a>
                        </div>
                    </nav>


                    <div class="tab-content" id="nav-tabContent">

                        <div class="tab-pane fade active show" id="nav-paladin" role="tabpanel" aria-labelledby="nav-paladin-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-center">Level</th>
                                        <th scope="col" class="text-center">EXP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (App\Models\Character::where('CHARACTER_JOB1', 1)
                                            ->where('CHARACTER_JOB5', 1)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(50)
                                            ->get() as $char)
                                        <tr>
                                            <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                            <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                            <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                            <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-panzer" role="tabpanel" aria-labelledby="nav-panzer-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-center">Level</th>
                                        <th scope="col" class="text-center">EXP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (App\Models\Character::where('CHARACTER_JOB1', 1)
                                            ->where('CHARACTER_JOB5', 2)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(50)
                                            ->get() as $char)
                                        <tr>
                                            <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                            <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                            <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                            <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-crusader" role="tabpanel" aria-labelledby="nav-crusader-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-center">Level</th>
                                        <th scope="col" class="text-center">EXP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (App\Models\Character::where('CHARACTER_JOB1', 1)
                                            ->where('CHARACTER_JOB5', 3)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(50)
                                            ->get() as $char)
                                        <tr>
                                            <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                            <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                            <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                            <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-destroyer" role="tabpanel" aria-labelledby="nav-destroyer-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-center">Level</th>
                                        <th scope="col" class="text-center">EXP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (App\Models\Character::where('CHARACTER_JOB1', 1)
                                            ->where('CHARACTER_JOB5', 4)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(50)
                                            ->get() as $char)
                                        <tr>
                                            <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                            <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                            <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                            <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-swordmaster" role="tabpanel" aria-labelledby="nav-swordmaster-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-center">Level</th>
                                        <th scope="col" class="text-center">EXP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (App\Models\Character::where('CHARACTER_JOB1', 1)
                                            ->where('CHARACTER_JOB5', 5)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(50)
                                            ->get() as $char)
                                        <tr>
                                            <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                            <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                            <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                            <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-magnus" role="tabpanel" aria-labelledby="nav-magnus-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-center">Level</th>
                                        <th scope="col" class="text-center">EXP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (App\Models\Character::where('CHARACTER_JOB1', 1)
                                            ->where('CHARACTER_JOB5', 6)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(50)
                                            ->get() as $char)
                                        <tr>
                                            <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                            <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                            <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                            <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="tab-pane fade" id="v-pills-rogue" role="tabpanel" aria-labelledby="v-pills-rogue-tab">
                    <nav>
                        <div class="row nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="col nav-link text-center active" id="nav-sniper-tab" data-toggle="tab" href="#nav-sniper" role="tab" aria-controls="nav-sniper" aria-selected="true">Sniper</a>
                            <a class="col nav-link text-center" id="nav-entrapper-tab" data-toggle="tab" href="#nav-entrapper" role="tab" aria-controls="nav-entrapper" aria-selected="false">Entrapper</a>
                            <a class="col nav-link text-center" id="nav-blade-tab" data-toggle="tab" href="#nav-blade" role="tab" aria-controls="nav-blade" aria-selected="false">Blade Taker</a>
                            <a class="col nav-link text-center" id="nav-templar-tab" data-toggle="tab" href="#nav-templar" role="tab" aria-controls="nav-templar" aria-selected="false">Templar Master</a>
                            <a class="col nav-link text-center" id="nav-arch-tab" data-toggle="tab" href="#nav-arch" role="tab" aria-controls="nav-arch" aria-selected="false">Arch Ranger</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-sniper" role="tabpanel" aria-labelledby="nav-sniper-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-center">Level</th>
                                        <th scope="col" class="text-center">EXP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (App\Models\Character::where('CHARACTER_JOB1', 2)
                                            ->where('CHARACTER_JOB5', 1)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(50)
                                            ->get() as $char)
                                        <tr>
                                            <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                            <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                            <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                            <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-entrapper" role="tabpanel" aria-labelledby="nav-entrapper-tab">
                            <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col" class="text-center">Level</th>
                                    <th scope="col" class="text-center">EXP</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach (App\Models\Character::where('CHARACTER_JOB1', 2)
                                        ->where('CHARACTER_JOB5', 2)
                                        ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                        ->orderBy('CHARACTER_GRADE', 'DESC')
                                        ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                        ->take(50)
                                        ->get() as $char)
                                    <tr>
                                        <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                        <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                        <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                        <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-blade" role="tabpanel" aria-labelledby="nav-blade-tab">
                            <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col" class="text-center">Level</th>
                                    <th scope="col" class="text-center">EXP</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach (App\Models\Character::where('CHARACTER_JOB1', 2)
                                        ->where('CHARACTER_JOB5', 3)
                                        ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                        ->orderBy('CHARACTER_GRADE', 'DESC')
                                        ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                        ->take(50)
                                        ->get() as $char)
                                    <tr>
                                        <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                        <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                        <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                        <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-templar" role="tabpanel" aria-labelledby="nav-templar-tab">
                            <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col" class="text-center">Level</th>
                                    <th scope="col" class="text-center">EXP</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach (App\Models\Character::where('CHARACTER_JOB1', 2)
                                        ->where('CHARACTER_JOB5', 4)
                                        ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                        ->orderBy('CHARACTER_GRADE', 'DESC')
                                        ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                        ->take(50)
                                        ->get() as $char)
                                    <tr>
                                        <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                        <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                        <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                        <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-arch" role="tabpanel" aria-labelledby="nav-arch-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-center">Level</th>
                                        <th scope="col" class="text-center">EXP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (App\Models\Character::where('CHARACTER_JOB1', 2)
                                            ->where('CHARACTER_JOB5', 5)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(50)
                                            ->get() as $char)
                                        <tr>
                                            <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                            <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                            <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                            <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show" id="v-pills-mage" role="tabpanel" aria-labelledby="v-pills-mage-tab">
                    <nav>
                        <div class="row nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="col nav-link text-center active" id="nav-cardinal-tab" data-toggle="tab" href="#nav-cardinal" role="tab" aria-controls="nav-cardinal" aria-selected="true">Cardinal</a>
                            <a class="col nav-link text-center" id="nav-soul-tab" data-toggle="tab" href="#nav-soul" role="tab" aria-controls="nav-soul" aria-selected="false">Soul Arbiter</a>
                            <a class="col nav-link text-center" id="nav-grand-tab" data-toggle="tab" href="#nav-grand" role="tab" aria-controls="nav-grand" aria-selected="false">Grand Master</a>
                            <a class="col nav-link text-center" id="nav-necro-tab" data-toggle="tab" href="#nav-necro" role="tab" aria-controls="nav-necro" aria-selected="false">Necromancer</a>
                            <a class="col nav-link text-center" id="nav-rune-tab" data-toggle="tab" href="#nav-rune" role="tab" aria-controls="nav-rune" aria-selected="false">Rune Master</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-cardinal" role="tabpanel" aria-labelledby="nav-cardinal-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-center">Level</th>
                                        <th scope="col" class="text-center">EXP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (App\Models\Character::where('CHARACTER_JOB1', 3)
                                            ->where('CHARACTER_JOB5', 1)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(50)
                                            ->get() as $char)
                                        <tr>
                                            <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                            <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                            <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                            <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-soul" role="tabpanel" aria-labelledby="nav-soul-tab">
                            <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col" class="text-center">Level</th>
                                    <th scope="col" class="text-center">EXP</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach (App\Models\Character::where('CHARACTER_JOB1', 3)
                                        ->where('CHARACTER_JOB5', 2)
                                        ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                        ->orderBy('CHARACTER_GRADE', 'DESC')
                                        ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                        ->take(50)
                                        ->get() as $char)
                                    <tr>
                                        <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                        <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                        <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                        <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-grand" role="tabpanel" aria-labelledby="nav-grand-tab">
                            <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col" class="text-center">Level</th>
                                    <th scope="col" class="text-center">EXP</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach (App\Models\Character::where('CHARACTER_JOB1', 3)
                                        ->where('CHARACTER_JOB5', 3)
                                        ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                        ->orderBy('CHARACTER_GRADE', 'DESC')
                                        ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                        ->take(50)
                                        ->get() as $char)
                                    <tr>
                                        <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                        <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                        <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                        <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-necro" role="tabpanel" aria-labelledby="nav-necro-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-center">Level</th>
                                        <th scope="col" class="text-center">EXP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (App\Models\Character::where('CHARACTER_JOB1', 3)
                                            ->where('CHARACTER_JOB5', 4)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(50)
                                            ->get() as $char)
                                        <tr>
                                            <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                            <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                            <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                            <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-rune" role="tabpanel" aria-labelledby="nav-rune-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-center">Level</th>
                                        <th scope="col" class="text-center">EXP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (App\Models\Character::where('CHARACTER_JOB1', 3)
                                            ->where('CHARACTER_JOB5', 5)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(50)
                                            ->get() as $char)
                                        <tr>
                                            <th scope="row" class="text-center" style="width: 10%">{{ $loop->index + 1 }}</th>
                                            <td class="text-left" style="width: 50%">{{ $char->CHARACTER_NAME }}</td>
                                            <td class="text-center">{{ $char->CHARACTER_GRADE }}</td>
                                            <td class="text-center" style="width: 50%">{{ number_format($char->CHARACTER_EXPOINT) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-guild" role="tabpanel" aria-labelledby="v-pills-guild-tab">
                    <nav>
                        <div class="row nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="col nav-link text-center active" id="nav-guildrank-tab" data-toggle="tab" href="#nav-guildrank" role="tab" aria-controls="nav-guildrank" aria-selected="true">Guild Ranking</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-guildrank" role="tabpanel" aria-labelledby="nav-guildrank-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Master</th>
                                        <th scope="col" class="text-center">Level</th>
                                        <th scope="col" class="text-center">Score</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (App\Models\Guild::orderBy('GuildLevel', 'DESC')
                                               ->whereHas('masterCharacter', function($q){ $q->whereHas('user', function($p){ $p->where('UserLevel', 6); }); })
                                               ->orderBy('SCORE', 'DESC')
                                               ->take(50)
                                               ->get() as $guild)

                                        <tr>
                                            <th scope="row" class="text-center">#{{ $loop->index + 1 }}</th>
                                            <td class="text-left">{{ $guild->GuildName }}</td>
                                            <td class="text-left">{{ App\Models\Character::find($guild->MasterIdx)->CHARACTER_NAME }}</td>
                                            <td class="text-center">{{ $guild->GuildLevel }}</td>
                                            <td class="text-center">{{ number_format($guild->SCORE) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
