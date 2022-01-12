@extends('layouts.main')
@section('content')
    <script type="text/javascript">
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ( (charCode > 31 && charCode < 48) || charCode > 57) {
                return false;
            }
            return true;
        }
    </script>
    <div class="row tile p-4 mx-0 my-4">
        <div class="col m-auto w-100">
            <div class="subtitle">Support</div>
            <div class="article pb-3" style="text-indent: 0;">For help and support regarding any technical issues, please contact our staff at <a href="{{ Helper::getSetting('social_discord') }}" target="_blank">our discord</a>.</div>
            <div class="article" style="text-indent: 0;">
                <strong>Rendy </strong>
                <p>
                    Phone: +62 821 2553 8923<br/>
                    Email: <a href="mailto:odysseylunaonline@gmail.com">odysseylunaonline@gmail.com</a><br/>
                    Mailing address: <small>Jln. Cibogo Wetan No. 72 Gading Serpong, Tangerang, Banten 15810</small>
                </p>
            </div>

            <a href="{{ Helper::getSetting('social_facebook') }}" target="_blank">
                <img src="{{ asset('storage/img/social-media/banner/fb.png') }}" alt="fb" class="img-fluid pb-2">
            </a>
            <a href="{{ Helper::getSetting('social_discord') }}" target="_blank">
                <img src="{{ asset('storage/img/social-media/banner/discord.png') }}" alt="discord" class="img-fluid pb-2">
            </a>
            <a href="{{ Helper::getSetting('social_instagram') }}" target="_blank">
                <img src="{{ asset('storage/img/social-media/banner/ig.png') }}" alt="instagram" class="img-fluid">
            </a>
        </div>
        <div class="col">
            <img class="img-fluid" src="{{ asset('storage/img/support.png') }}" style="height: 100%"></img>
        </div>
    </div>
@stop
