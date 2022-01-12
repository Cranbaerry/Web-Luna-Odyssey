<div class="col-12 col-sm-6 col-md-4">
    <div class="card">
        <div class="wrapper">
            <div class="header">Welcome, {{  Auth::user()->id_loginid }}!</div>

            <div class="banner-img">
                <img src="{{ Helper::getSetting('img_login') }}" alt="Image 1">
            </div>

            <div class="stats card-bg-transparent row mx-0">

                <div class="col px-0">
                    <strong>Cash Points</strong> {{  number_format(Auth::user()->UserPointMall) }}
                </div>

                @if (App\Models\Partner::where('userid', Auth::user()->id_idx)->exists())
                    <div class="col px-0">
                        <strong>Virtual Money</strong> Rp. {{ number_format(App\Models\Partner::where('userid', Auth::user()->id_idx)->first()->virtual_money) }}
                    </div>
                    <div class="col px-0">
                        <strong>Membership</strong> Streamer
                    </div>
                @else
                    <div class="col px-0">
                        <strong>Membership</strong> {{  Auth::user()->getAccessLevel() }}
                    </div>
                @endif

            </div>

            <form class="col" method="POST" action="{{ route('logout', [], false) }}" style="display: inline-block;">
                @csrf
                <div class="footer row">
                <a href="{{ route('donate') }}" class="col-4 btn btn-info">Top up</a>
                <a href="{{ route('dashboard') }}" class="col-4 btn btn-primary">CPanel</a>
                <a href="#" class="col-4 btn btn-danger" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
            </div>
            </form>
        </div>
    </div>
    <a href="{{ route('download') }}" class="w-100">
        <img src="{{ asset('storage/img/download.png') }}" alt="download" class="img-fluid mt-2">
    </a>
</div>
