@extends('layouts.main')
@section('content')
@include('components.modal-shop')

<div class="row tile py-4" style="box-shadow: none; background:none;">
    <div class="col">
        <div class="title" id="welcome">Welcome to <b>{{config('app.name')}}</b></div>
        <div class="article">{{config('app.name')}} is a new Private Server Luna that is going to be released on mid Sept 2021. Odyssey will serve you a new modern feature by improving various old Luna feature that will make you excited and never get bored!</div>
        <div class="text-center mb-2">FOLLOW US</div>

        <div class="container">
            <div class="row">
                <div class="col col-social-banner">
                    <a href="{{ Helper::getSetting('social_facebook') }}" target="_blank">
                        <img src="{{ asset("storage/img/social-media/banner/fb.png") }}" alt="fb" class="social-banner"></a>
                </div>
                <div class="col col-social-banner">
                    <a href="{{ Helper::getSetting('social_discord') }}" target="_blank">
                        <img src="{{ asset("storage/img/social-media/banner/discord.png") }}" alt="discord" class="social-banner"></a>
                </div>
                <div class="col col-social-banner">
                    <a href="{{ Helper::getSetting('social_instagram') }}" target="_blank">
                        <img src="{{ asset("storage/img/social-media/banner/IG.png") }}" alt="ig" class="social-banner">
                    </a>
                </div>
            </div>
        </div>


        <div class="main_left_section">
            <div class="border_bg_tree aos-init aos-animate pt-3" data-aos="fade-right" data-aos-delay="200">
                <div class="card shadow-sm mb-3 card-bg-transparent">
                    <div class="edgtf-tournament-timetable-holder" style="width:100%;">
                        <div class="edgtf-tt-item-outer edgtf-with-link">
                            <div class="edgtf-tt-item-holder">
                                <div class="edgtf-tt-day edgtf-tt-section" style="width: auto;">

                                </div>
                                <div class="edgtf-tt-message edgtf-tt-section text-center">
                                    HOT ITEMS
                                </div>
                                <div class="edgtf-tt-event-title edgtf-tt-section" style="width: auto;">

                                </div>
                                <a itemprop="url" class="edgtf-tt-link" href="javascript:;"></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="carouselExampleIndicators" class="carousel slide" align="center" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach (App\Models\ItemMall::where('featured_label', 2)->orderByDesc('item_id')->take(5)->get() as $data)
                                    <div class="carousel-item @if($loop->index == 0) active @endif">
                                        <div class="d-block">
                                            <img class="rounded mx-auto d-block" style="width:90px;height:auto;" src="{{ $data->img }}" alt="--No Image--">
                                        </div>
                                        <div class="d-block">
                                            <div class="d-block" style="height:50px;"><small class="text-primary">{{ $data->name }}</small></div>
                                            <button style="letter-spacing:2px;"
                                                    data-itemid="{{ $data->item_id }}"
                                                    data-name="{{ $data->name }}"
                                                    data-minqty="{{ $data->min_quantity }}"
                                                    data-maxqty="{{ $data->max_quantity }}"
                                                    data-description="{{ $data->description }}"
                                                    data-price="{{ $data->price }}"
                                                    data-effects='{{ $data->effects }}'
                                                    data-image="{{ $data->img }}"
                                                    onclick="buyItem(this);" class="btn btn-main-boder view_detail " type="button">
                                                <b>BUY NOW</b>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <svg class="svg-inline--fa fa-angle-left fa-w-8 text-primary fa-2x" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"></path></svg><!-- <i class="fas fa-angle-left text-primary fa-2x"></i> -->
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <svg class="svg-inline--fa fa-angle-right fa-w-8 text-primary fa-2x" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right text-primary fa-2x"></i> -->
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clouds"></div>
    <div class="col hero-banner hero-animated d-none d-md-block" style="background-image: url({{ Helper::getSetting('img_hero') }});"></div>
    <div class="col" id="main-component">
        @includeWhen(Auth::check(), 'components.home-usercard')
        @includeWhen(Auth::guest(), 'components.home-loginform')
    </div>
</div>

<div class="row">
    <div class="col py-2">
        <div id="carouselBanner" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselBanner" data-slide-to="0" class="active"></li>
                <li data-target="#carouselBanner" data-slide-to="1"></li>
                <li data-target="#carouselBanner" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href="{{ Helper::getSetting('img_banner_1_link') }}" target="_blank"><img class="d-block w-100" src="{{ Helper::getSetting('img_banner_1') }}" alt="First slide"></a>
                </div>
                <div class="carousel-item">
                    <a href="{{ Helper::getSetting('img_banner_2_link') }}" target="_blank"><img class="d-block w-100" src="{{ Helper::getSetting('img_banner_2') }}" alt="Second slide"></a>
                </div>
                <div class="carousel-item">
                    <a href="{{ Helper::getSetting('img_banner_3_link') }}" target="_blank"><img class="d-block w-100" src="{{ Helper::getSetting('img_banner_3') }}" alt="Third slide"></a>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselBanner" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselBanner" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>

<div class="row pt-3 d-flex justify-content-center">
    <div class="col-lg-3 col-sm-12 col-md-6">
        <div class="main_left_section">
            <div class="border_bg_tree aos-init aos-animate pt-3" data-aos="fade-right" data-aos-delay="200">
                <div class="card shadow-sm mb-3 card-bg-transparent" style="min-height:250px;">
                    <div class="edgtf-tournament-timetable-holder" style="width:100%;">
                        <div class="edgtf-tt-item-outer edgtf-with-link">
                            <div class="edgtf-tt-item-holder card-leaderboard-header">
                                <div class="edgtf-tt-day edgtf-tt-section" style="width: auto;">

                                </div>
                                <div class="edgtf-tt-message edgtf-tt-section text-center card-leaderboard-header-text">
                                    BEST GUILD
                                </div>
                                <div class="edgtf-tt-event-title edgtf-tt-section" style="width: auto;">

                                </div>
                                <a itemprop="url" class="edgtf-tt-link" href="javascript:;"></a>
                            </div>
                        </div>
                    </div>


                    <div class="card-body card-leaderboard card-guild">
                        <div id="carouselGuild" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item px-4 active">
                                    <label class="text-center w-100">Top 3 Guild</label>
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        @foreach (App\Models\Guild::orderBy('GuildLevel', 'DESC')
                                            ->orderBy('SCORE', 'DESC')
                                            ->take(3)
                                            ->whereHas('masterCharacter', function($q){ $q->whereHas('user', function($p){ $p->where('UserLevel', 6); }); })
                                            ->get() as $guild)
                                        <tr>
                                            <th scope="row" class="text-right">#{{ $loop->index + 1 }}</th>
                                            <td class="text-left">{{ $guild->GuildName }}</td>
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
    </div>

    <div class="col-lg-3 col-sm-12 col-md-6">
        <div class="main_left_section">
            <div class="border_bg_tree aos-init aos-animate pt-3" data-aos="fade-right" data-aos-delay="200">
                <div class="card shadow-sm mb-3 card-bg-transparent" style="min-height:250px;">
                    <div class="edgtf-tournament-timetable-holder" style="width:100%;">
                        <div class="edgtf-tt-item-outer edgtf-with-link">
                            <div class="edgtf-tt-item-holder card-leaderboard-header">
                                <div class="edgtf-tt-day edgtf-tt-section" style="width: auto;">

                                </div>
                                <div class="edgtf-tt-message edgtf-tt-section text-center card-leaderboard-header-text">
                                    BEST FIGHTER
                                </div>
                                <div class="edgtf-tt-event-title edgtf-tt-section" style="width: auto;">

                                </div>
                                <a itemprop="url" class="edgtf-tt-link" href="javascript:;"></a>
                            </div>
                        </div>
                    </div>


                    <div class="card-body card-leaderboard card-fighter">
                        <div id="fighterCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item px-4 active">
                                    <label class="text-center w-100">Phalanx Class</label>
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        @foreach (App\Models\Character::where('CHARACTER_JOB1', 1)
                                            ->where('CHARACTER_JOB4', 1)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(3)
                                            ->get() as $char)
                                        <tr>
                                            <th scope="row" class="text-right">#{{ $loop->index + 1 }}</th>
                                            <td class="text-left">{{ $char->CHARACTER_NAME }}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="carousel-item px-4">
                                    <label class="text-center w-100">Knight Class</label>
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        @foreach (App\Models\Character::where('CHARACTER_JOB1', 1)
                                            ->where('CHARACTER_JOB4', 2)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(3)
                                            ->get() as $char)
                                            <tr>
                                                <th scope="row" class="text-right">#{{ $loop->index + 1 }}</th>
                                                <td class="text-left">{{ $char->CHARACTER_NAME }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="carousel-item px-4">
                                    <label class="text-center w-100">Gladiator Class</label>
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        @foreach (App\Models\Character::where('CHARACTER_JOB1', 1)
                                            ->where('CHARACTER_JOB4', 3)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(3)
                                            ->get() as $char)
                                            <tr>
                                                <th scope="row" class="text-right">#{{ $loop->index + 1 }}</th>
                                                <td class="text-left">{{ $char->CHARACTER_NAME }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="carousel-item px-4">
                                    <label class="text-center w-100">Rune Knight Class</label>
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        @foreach (App\Models\Character::where('CHARACTER_JOB1', 1)
                                            ->where('CHARACTER_JOB4', 4)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(3)
                                            ->get() as $char)
                                            <tr>
                                                <th scope="row" class="text-right">#{{ $loop->index + 1 }}</th>
                                                <td class="text-left">{{ $char->CHARACTER_NAME }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#fighterCarousel" role="button" data-slide="prev">
                                <svg class="svg-inline--fa fa-angle-left fa-w-8 text-primary fa-2x" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"></path></svg><!-- <i class="fas fa-angle-left text-primary fa-2x"></i> -->
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#fighterCarousel" role="button" data-slide="next">
                                <svg class="svg-inline--fa fa-angle-right fa-w-8 text-primary fa-2x" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right text-primary fa-2x"></i> -->
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-12 col-md-6">
        <div class="main_left_section">
            <div class="border_bg_tree aos-init aos-animate pt-3" data-aos="fade-right" data-aos-delay="200">
                <div class="card shadow-sm mb-3 card-bg-transparent" style="min-height:250px;">
                    <div class="edgtf-tournament-timetable-holder" style="width:100%;">
                        <div class="edgtf-tt-item-outer edgtf-with-link">
                            <div class="edgtf-tt-item-holder card-leaderboard-header">
                                <div class="edgtf-tt-day edgtf-tt-section" style="width: auto;">

                                </div>
                                <div class="edgtf-tt-message edgtf-tt-section text-center card-leaderboard-header-text">
                                    BEST ROGUE
                                </div>
                                <div class="edgtf-tt-event-title edgtf-tt-section" style="width: auto;">

                                </div>
                                <a itemprop="url" class="edgtf-tt-link" href="javascript:;"></a>
                            </div>
                        </div>
                    </div>


                    <div class="card-body card-leaderboard card-rogue">
                        <div id="rogueCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item px-4 active">
                                    <label class="text-center w-100">Ranger Class</label>
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        @foreach (App\Models\Character::where('CHARACTER_JOB1', 2)
                                            ->where('CHARACTER_JOB4', 1)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(3)
                                            ->get() as $char)
                                            <tr>
                                                <th scope="row" class="text-right">#{{ $loop->index + 1 }}</th>
                                                <td class="text-left">{{ $char->CHARACTER_NAME }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="carousel-item px-4">
                                    <label class="text-center w-100">Treasure Hunter</label>
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        @foreach (App\Models\Character::where('CHARACTER_JOB1', 2)
                                            ->where('CHARACTER_JOB4', 2)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(3)
                                            ->get() as $char)
                                            <tr>
                                                <th scope="row" class="text-right">#{{ $loop->index + 1 }}</th>
                                                <td class="text-left">{{ $char->CHARACTER_NAME }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="carousel-item px-4">
                                    <label class="text-center w-100">Assassin Class</label>
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        @foreach (App\Models\Character::where('CHARACTER_JOB1', 2)
                                            ->where('CHARACTER_JOB4', 3)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(3)
                                            ->get() as $char)
                                            <tr>
                                                <th scope="row" class="text-right">#{{ $loop->index + 1 }}</th>
                                                <td class="text-left">{{ $char->CHARACTER_NAME }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="carousel-item px-4">
                                    <label class="text-center w-100">Rune Walker Class</label>
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        @foreach (App\Models\Character::where('CHARACTER_JOB1', 2)
                                            ->where('CHARACTER_JOB4', 4)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(3)
                                            ->get() as $char)
                                            <tr>
                                                <th scope="row" class="text-right">#{{ $loop->index + 1 }}</th>
                                                <td class="text-left">{{ $char->CHARACTER_NAME }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#rogueCarousel" role="button" data-slide="prev">
                                <svg class="svg-inline--fa fa-angle-left fa-w-8 text-primary fa-2x" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"></path></svg><!-- <i class="fas fa-angle-left text-primary fa-2x"></i> -->
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#rogueCarousel" role="button" data-slide="next">
                                <svg class="svg-inline--fa fa-angle-right fa-w-8 text-primary fa-2x" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right text-primary fa-2x"></i> -->
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-12 col-md-6">
        <div class="main_left_section">
            <div class="border_bg_tree aos-init aos-animate pt-3" data-aos="fade-right" data-aos-delay="200">
                <div class="card shadow-sm mb-3 card-bg-transparent" style="min-height:250px;">
                    <div class="edgtf-tournament-timetable-holder" style="width:100%;">
                        <div class="edgtf-tt-item-outer edgtf-with-link">
                            <div class="edgtf-tt-item-holder card-leaderboard-header">
                                <div class="edgtf-tt-day edgtf-tt-section" style="width: auto;">

                                </div>
                                <div class="edgtf-tt-message edgtf-tt-section text-center card-leaderboard-header-text">
                                    BEST MAGE
                                </div>
                                <div class="edgtf-tt-event-title edgtf-tt-section" style="width: auto;">

                                </div>
                                <a itemprop="url" class="edgtf-tt-link" href="javascript:;"></a>
                            </div>
                        </div>
                    </div>


                    <div class="card-body card-leaderboard card-mage">
                        <div id="mageCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item px-4 active">
                                    <label class="text-center w-100">Bishop Class</label>
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        @foreach (App\Models\Character::where('CHARACTER_JOB1', 3)
                                            ->where('CHARACTER_JOB4', 1)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(3)
                                            ->get() as $char)
                                            <tr>
                                                <th scope="row" class="text-right">#{{ $loop->index + 1 }}</th>
                                                <td class="text-left">{{ $char->CHARACTER_NAME }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="carousel-item px-4">
                                    <label class="text-center w-100">Warlock Class</label>
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        @foreach (App\Models\Character::where('CHARACTER_JOB1', 3)
                                            ->where('CHARACTER_JOB4', 2)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(3)
                                            ->get() as $char)
                                            <tr>
                                                <th scope="row" class="text-right">#{{ $loop->index + 1 }}</th>
                                                <td class="text-left">{{ $char->CHARACTER_NAME }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="carousel-item px-4">
                                    <label class="text-center w-100">Inquirer Class</label>
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        @foreach (App\Models\Character::where('CHARACTER_JOB1', 3)
                                            ->where('CHARACTER_JOB4', 3)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(3)
                                            ->get() as $char)
                                            <tr>
                                                <th scope="row" class="text-right">#{{ $loop->index + 1 }}</th>
                                                <td class="text-left">{{ $char->CHARACTER_NAME }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="carousel-item px-4">
                                    <label class="text-center w-100">Elemental Master</label>
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                        @foreach (App\Models\Character::where('CHARACTER_JOB1', 3)
                                            ->where('CHARACTER_JOB4', 4)
                                            ->whereHas('user', function($q){ $q->where('UserLevel', 6); })
                                            ->orderBy('CHARACTER_GRADE', 'DESC')
                                            ->orderBy('CHARACTER_EXPOINT', 'DESC')
                                            ->take(3)
                                            ->get() as $char)
                                            <tr>
                                                <th scope="row" class="text-right">#{{ $loop->index + 1 }}</th>
                                                <td class="text-left">{{ $char->CHARACTER_NAME }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#mageCarousel" role="button" data-slide="prev">
                                <svg class="svg-inline--fa fa-angle-left fa-w-8 text-primary fa-2x" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"></path></svg><!-- <i class="fas fa-angle-left text-primary fa-2x"></i> -->
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#mageCarousel" role="button" data-slide="next">
                                <svg class="svg-inline--fa fa-angle-right fa-w-8 text-primary fa-2x" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right text-primary fa-2x"></i> -->
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@stop
