@extends('layouts.main')
@section('content')
    <div class="row tile py-3 mx-0" style="box-shadow: none; background:none; " xmlns="http://www.w3.org/1999/html">
        <div class="col-8 pl-0">
            <div class="main_left_section">
                <div class="border_bg_tree aos-init aos-animate pt-3" data-aos="fade-right" data-aos-delay="200">
                    <div class="card shadow-sm mb-3 card-bg-transparent" align="center">
                        <div class="edgtf-tournament-timetable-holder" style="width:100%;">
                            <div class="edgtf-tt-item-outer edgtf-with-link">
                                <div class="edgtf-tt-item-holder">
                                    <div class="edgtf-tt-day edgtf-tt-section" style="width: auto;">

                                    </div>
                                    <div class="edgtf-tt-message edgtf-tt-section">
                                        SERVER INFORMATIONS
                                    </div>
                                    <div class="edgtf-tt-event-title edgtf-tt-section" style="width: auto;">

                                    </div>
                                    <a itemprop="url" class="edgtf-tt-link" href="javascript:;"></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div>
                                        <strong>HRS</strong> <span class="server_hrs"></span>
                                    </div>
                                    <div>
                                        <strong>MINS</strong> <span class="server_mins"></span>
                                    </div>
                                    <div>
                                        <strong>SECS</strong> <span class="server_secs"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div class="stats-key">
                                        <strong>Server Location</strong>
                                    </div>
                                    <div class="stats-value w-100" style="display: contents;">
                                        {{ Helper::getSetting('server_location') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div class="stats-key">
                                        <strong>Server Timezone</strong>
                                    </div>
                                    <div class="stats-value w-100" style="display: contents;">
                                        {{ Helper::getSetting('server_timezone') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div class="stats-key">
                                        <strong>Server Status</strong>
                                    </div>
                                    <div class="stats-value w-100" style="display: contents;">
                                        @if (Helper::pingServer())
                                            <span class="text-success">Online</span>
                                        @else
                                            <span class="text-danger">Offline</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div class="stats-key">
                                        <strong>Player Online</strong>
                                    </div>
                                    <div class="stats-value w-100" style="display: contents;">
                                        {{ App\Models\LoginTable::all()->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div class="stats-key">
                                        <strong>EXP Rate</strong>
                                    </div>
                                    <div class="stats-value w-100" style="display: contents;">
                                        <span class="text-1"><b>{{ Helper::getSetting('rate_exp') }}</b></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div class="stats-key">
                                        <strong>Gold Rate</strong>
                                    </div>
                                    <div class="stats-value w-100" style="display: contents;">
                                        <span class="text-1"><b>{{ Helper::getSetting('rate_gold') }}</b></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div class="stats-key">
                                        <strong>Drop Rate</strong>
                                    </div>
                                    <div class="stats-value w-100" style="display: contents;">
                                        <span class="text-1"><b>{{ Helper::getSetting('rate_drop') }}</b></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="stats card-bg-transparent">
                                    <div class="stats-key">
                                        <strong>Party Rate</strong>
                                    </div>
                                    <div class="stats-value w-100" style="display: contents;">
                                        <span class="text-1"><b>{{ Helper::getSetting('rate_party') }}</b></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 hero-banner hero-2" style="background-position: center -15px;"></div>
    </div>
    <div class="row tile mx-0 p-3">
        <div class="col-12 col-md-6">
            <div class="subtitle">Server Features</div>
            <div class="article" style="text-indent: 0;">
                <strong>Optional / Setting</strong>
                <ul class="list-group pt-2 pb-2">
                    <li class="list-group-item">Luna Type Damage [ CLASSIC ]</li>
                    <li class="list-group-item">WASD On/Off</li>
                    <li class="list-group-item">Weather On/Off</li>
                    <li class="list-group-item">Inspect Item On/Off</li>
                    <li class="list-group-item">Balance PVE & PVP System Modified</li>
                    <li class="list-group-item">Game Update Weekly / Montly Active</li>
                    <li class="list-group-item">Smooth Visual 30/60 FPS Active</li>
                </ul>

                <strong>Feature Added</strong>
                <ul class="list-group pt-2">
                    <li class="list-group-item">Pet System</li>
                    <li class="list-group-item">Field Boss</li>
                    <li class="list-group-item">Raid Boss Mechanic</li>
                    <li class="list-group-item">New costumes and more!</li>
                </ul>
            </div>

        </div>
        <div class="col-12 col-md-6">
            <div class="subtitle">Server Rules</div>
            <div class="article" style="text-indent: 0;">
                <strong>Rule #1 - Staff Impersonation</strong>
                <p>Pretending to be a Game Master / Staff in order in order to extract personal information, game items, in-game cash, from another player is a form of scamming and will not be tolerated by game management.</p>
            </div>

            <div class="article" style="text-indent: 0;">
                <strong>Rule #2 - Racial/Religion/Nationality Harassment</strong>
                <p>Harassing or saying inappropriate words towards other Race, Religion or Nationality.</p>
            </div>

            <div class="article" style="text-indent: 0;">
                <strong>Rule #3 - Hacking/Client/Files Modification</strong>
                <p>These are the ILLEGAL PROGRAMS/APPLICATIONS AND MODIFIED GAME CLIENTS, which are not part of the game client. These may be another standalone programs or plug-ins which may be downloaded from other sites.</p>
            </div>

            <div class="article" style="text-indent: 0;">
                <strong>Rule #4 - Bug Exploitation</strong>
                <p>Promoting the use of game glitches in-game. Players are encouraged to report game bugs to the Staffs as soon as they are discovered.</p>
            </div>
            <div class="article" style="text-indent: 0;">
                <strong>Rule #5 - Advertisement</strong>
                <p>Promoting other Luna servers are strictly prohibited.</p>
            </div>
            <div class="article" style="text-indent: 0;">
                <strong>Rule #6 - Real Money Trading</strong>
                <p>Real Money Trading (RMT) is allowed. Users are prohibited to mention a price on their posts in any way.</p>
            </div>

            <div class="article" style="text-indent: 0;">
                <strong>Rule #7 - Offensive Language, Offensive Images, and Threats</strong>
                <p>The use of offensive language, offensive images, or threats directed toward Game Master / Staff is inappropriate and considered harassment.</p>
            </div>

            <div class="article" style="text-indent: 0;">
                <strong>Rule #8 - BOT in Game</strong>
                <p>Botting is not allowed in-game, and we actively take actions against accounts that use third party software to automate their gameplay.</p>
            </div>
        </div>
    </div>
@stop
