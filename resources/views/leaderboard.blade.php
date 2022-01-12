@extends('layouts.main')
@section('content')


    <div class="row tile p-4 mx-0 my-4">
        <div class="col col-lg-3 col-md-4 col-sm-5 mb-2">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link nav-rank-item d-flex active" id="v-pills-fighter-tab" data-toggle="pill" href="#v-pills-fighter" role="tab" aria-controls="v-pills-fighter" aria-selected="true">
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
                <div class="tab-pane fade show active" id="v-pills-fighter" role="tabpanel" aria-labelledby="v-pills-fighter-tab">
                    <nav>
                        <div class="row nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="col nav-link text-center active" id="nav-phalanx-tab" data-toggle="tab" href="#nav-phalanx" role="tab" aria-controls="nav-phalanx" aria-selected="true">Phalanx</a>
                            <a class="col nav-link text-center" id="nav-knight-tab" data-toggle="tab" href="#nav-knight" role="tab" aria-controls="nav-knight" aria-selected="false">Knight</a>
                            <a class="col nav-link text-center" id="nav-gladiator-tab" data-toggle="tab" href="#nav-gladiator" role="tab" aria-controls="nav-gladiator" aria-selected="false">Gladiator</a>
                            <a class="col nav-link text-center" id="nav-runeknight-tab" data-toggle="tab" href="#nav-runeknight" role="tab" aria-controls="nav-runeknight" aria-selected="false">Rune Knight</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-phalanx" role="tabpanel" aria-labelledby="nav-phalanx-tab">
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
                                            ->where('CHARACTER_JOB4', 1)
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
                        <div class="tab-pane fade" id="nav-knight" role="tabpanel" aria-labelledby="nav-knight-tab">
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
                                            ->where('CHARACTER_JOB4', 2)
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
                        <div class="tab-pane fade" id="nav-gladiator" role="tabpanel" aria-labelledby="nav-gladiator-tab">
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
                                            ->where('CHARACTER_JOB4', 3)
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
                        <div class="tab-pane fade" id="nav-runeknight" role="tabpanel" aria-labelledby="nav-runeknight-tab">
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
                                            ->where('CHARACTER_JOB4', 4)
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


                <div class="tab-pane fade show" id="v-pills-rogue" role="tabpanel" aria-labelledby="v-pills-rogue-tab">
                    <nav>
                        <div class="row nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="col nav-link text-center active" id="nav-phalanx-tab" data-toggle="tab" href="#nav-ranger" role="tab" aria-controls="nav-ranger" aria-selected="true">Ranger</a>
                            <a class="col nav-link text-center" id="nav-knight-tab" data-toggle="tab" href="#nav-hunter" role="tab" aria-controls="nav-hunter" aria-selected="false">Treasure Hunter</a>
                            <a class="col nav-link text-center" id="nav-gladiator-tab" data-toggle="tab" href="#nav-assassin" role="tab" aria-controls="nav-assassin" aria-selected="false">Assassin</a>
                            <a class="col nav-link text-center" id="nav-runeknight-tab" data-toggle="tab" href="#nav-walker" role="tab" aria-controls="nav-walker" aria-selected="false">Rune Walker</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-ranger" role="tabpanel" aria-labelledby="nav-ranger-tab">
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
                                            ->where('CHARACTER_JOB4', 1)
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
                        <div class="tab-pane fade" id="nav-hunter" role="tabpanel" aria-labelledby="nav-hunter-tab">
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
                                        ->where('CHARACTER_JOB4', 2)
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
                        <div class="tab-pane fade" id="nav-assassin" role="tabpanel" aria-labelledby="nav-assassin-tab">
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
                                        ->where('CHARACTER_JOB4', 3)
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
                        <div class="tab-pane fade" id="nav-walker" role="tabpanel" aria-labelledby="nav-walker-tab">
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
                                        ->where('CHARACTER_JOB4', 4)
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
                            <a class="col nav-link text-center active" id="nav-bishop-tab" data-toggle="tab" href="#nav-bishop" role="tab" aria-controls="nav-bishop" aria-selected="true">Bishop</a>
                            <a class="col nav-link text-center" id="nav-warlock-tab" data-toggle="tab" href="#nav-warlock" role="tab" aria-controls="nav-warlock" aria-selected="false">Warlock</a>
                            <a class="col nav-link text-center" id="nav-inquirer-tab" data-toggle="tab" href="#nav-inquirer" role="tab" aria-controls="nav-inquirer" aria-selected="false">Inquirer</a>
                            <a class="col nav-link text-center" id="nav-elemental-tab" data-toggle="tab" href="#nav-elemental" role="tab" aria-controls="nav-elemental" aria-selected="false">Elemental</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-bishop" role="tabpanel" aria-labelledby="nav-bishop-tab">
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
                                            ->where('CHARACTER_JOB4', 1)
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
                        <div class="tab-pane fade" id="nav-warlock" role="tabpanel" aria-labelledby="nav-warlock-tab">
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
                                        ->where('CHARACTER_JOB4', 2)
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
                        <div class="tab-pane fade" id="nav-inquirer" role="tabpanel" aria-labelledby="nav-inquirer-tab">
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
                                        ->where('CHARACTER_JOB4', 3)
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
                        <div class="tab-pane fade" id="nav-elemental" role="tabpanel" aria-labelledby="nav-elemental-tab">
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
                                            ->where('CHARACTER_JOB4', 4)
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


                <div class="tab-pane fade show" id="v-pills-guild" role="tabpanel" aria-labelledby="v-pills-guild-tab">
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
