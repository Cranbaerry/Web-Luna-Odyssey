<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset("storage/img/favicon.ico") }}">

    <title>{{ Config::get('app.name') }}</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">

    <!-- Custom styles for this template -->
    <link href="{{ asset("storage/css/cover.css") }} " rel="stylesheet">
    <link href="{{ asset("storage/css/tagsinput.css") }} " rel="stylesheet">
    <link href="{{ asset("storage/css/json-viewer.css") }} " rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="w-100">
    <div class="banner">
        <img class="w-100 banner-img" src="{{ Helper::getSetting('img_banner') }}" alt="banner">
        <div class="d-flex justify-content-center flex-wrap bd-highlight mb-3 server-status">
            <div class="p-3 bd-highlight status-check status-usercount justify-content-center server-status-wrapper">
                <div class="container" style="width:200px">
                    <div class="row">
                        <div class="col">
                            <div class="d-block status-gold-text">
                                @php
                                    $gold = App\Models\Character::whereHas('user', function($q){
                                               $q->where('UserLevel', 6);
                                            })->sum('CHARACTER_MONEY');

                                    $wh_gold = DB::connection('gamedb')->table("TB_PYOGUK")->get()->sum("PyogukMoney");
                                @endphp
                                {{ number_format($gold + $wh_gold) }}
                            </div>
                            <div class="d-block status-key-text">In-Game Gold Circulation</div>
                        </div>
                        <div class="w-100 pb-2"></div>
                        <div class="col">
                            <div class="d-block status-value-text">{{ App\Models\LoginTable::all()->count() }}</div>
                            <div class="d-block status-key-text">Players Online</div>
                        </div>
                        <div class="col">
                            @if (Helper::pingServer())
                                <div class="d-block status-value-text">ON</div>
                            @else
                                <div class="d-block status-value-text" style="opacity: 0.7">OFF</div>
                            @endif
                            <div class="d-block status-key-text">Server Status</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <header class="masthead mb-auto">
            <div class="row mb-auto view-desktop">
                <nav class="fixed-top nav nav-masthead position-absolute justify-content-center">
                    <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    <a class="nav-link {{ Route::currentRouteName() == 'features' ? 'active' : '' }}" href="{{ route('features') }}">Features</a>
                    <a class="nav-link {{ Route::currentRouteName() == 'leaderboard' ? 'active' : '' }}" href="{{ route('leaderboard') }}">Leaderboard</a>
                    <a class="nav-link {{ Route::currentRouteName() == 'download' ? 'active' : '' }}" href="{{ route('download') }}">Download</a>
                    <div class="nav-link">
                        <img class="logo" src="{{ Helper::getSetting('img_logo') }}" alt="logo">
                    </div>
                    <a class="nav-link {{ Route::currentRouteName() == 'donate' ? 'active' : '' }}" href="{{ route('donate') }}">Donation</a>
                    <a class="nav-link {{ Route::currentRouteName() == 'shop' ? 'active' : '' }}" href="{{ route('shop') }}">Item Mall</a>
                    @if(Helper::isAdmin())
                        <a class="nav-link {{ Route::currentRouteName() == 'admin' ? 'active' : '' }}" href="{{ route('admin') }}">Admin</a>
                    @else
                        <a class="nav-link {{ Route::currentRouteName() == 'support' ? 'active' : '' }}" href="{{ route('support') }}">Support</a>
                    @endif
                    @if (Auth::check())
                        <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}">My Account</a>
                    @else
                        <a class="nav-link {{ Route::currentRouteName() == 'register' ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                    @endif
                </nav>
            </div>
            <div class="position-absolute w-100 pos-f-t fixed-top view-mobile navmobile">
                <nav class="navbar navbar-light">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="nav-link mobile-logo">
                        <img class="" src="{{ Helper::getSetting('img_logo') }}" alt="logo">
                    </div>
                </nav>

                <div class="collapse" id="navbarToggleExternalContent">
                    <div class="p-2 mobile-menu">
                        <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                        <a class="nav-link {{ Route::currentRouteName() == 'features' ? 'active' : '' }}" href="{{ route('features') }}">Features</a>
                        <a class="nav-link {{ Route::currentRouteName() == 'leaderboard' ? 'active' : '' }}" href="{{ route('leaderboard') }}">Leaderboard</a>
                        <a class="nav-link {{ Route::currentRouteName() == 'download' ? 'active' : '' }}" href="{{ route('download') }}">Download</a>
                        <a class="nav-link {{ Route::currentRouteName() == 'donate' ? 'active' : '' }}" href="{{ route('donate') }}">Donation</a>
                        <a class="nav-link {{ Route::currentRouteName() == 'shop' ? 'active' : '' }}" href="{{ route('shop') }}">Item Mall</a>
                        @if(Auth::check() && (Auth::user()->id_idx == 98 || Auth::user()->id_idx == 99 || Auth::user()->id_idx == 100 || Auth::user()->id_idx == 2))
                            <a class="nav-link {{ Route::currentRouteName() == 'admin' ? 'active' : '' }}" href="{{ route('admin') }}">Admin</a>
                        @else
                            <a class="nav-link {{ Route::currentRouteName() == 'support' ? 'active' : '' }}" href="{{ route('support') }}">Support</a>
                        @endif
                        @if (Auth::check())
                            <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}">My Account</a>
                        @else
                            <a class="nav-link {{ Route::currentRouteName() == 'register' ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                        @endif
                    </div>
                </div>
            </div>
        </header>
    </div>

    <div class="container py-4" id="content">
        @yield('content')
    </div>

    <div class="modal fade" id="modalPIN" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="POST" class="m-auto  w-100" id="modalPINForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">PIN Setup</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="modalPINErrorWrapper">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong id="modalPINErrorMsg">{{ __('Whoops! Something went wrong.') }}</strong>
                                <div id="modalPINErrorList"></div>
                                <button type="button" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        <div id="modalPINInfo" class="alert alert-info" role="alert">
                            <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;
                            <strong>Holy guacamole!</strong> You have not configured your PIN.
                        </div>
                        <p class="text-center">
                            We notice that you have not properly setup your Personal Identification Number yet. Please fill in the following field.
                        </p>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">PIN</label>
                            <div class="col-sm-10">
                                <input name="pin" type="password" class="form-control" placeholder="PIN Number" maxlength="4" inputmode="numeric" onkeypress="return isNumber(event)" onpaste="return false;">
                                <small class="form-text text-muted pl-1">PIN consists of 4 numbers that will be used for item purchase confirmations and cannot be changed.</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btn-pin">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="{{ asset('storage/js/bootstrap-input-spinner.js') }}"></script>
    <script src="{{ asset('storage/js/tagsinput.js') }}"></script>
    <script src="{{ asset('storage/js/json-viewer.js') }}"></script>
    <script src="https://kit.fontawesome.com/9ee911f0e3.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script>
        function basename(path) {
            return path.split('/').reverse()[0];
        }

        function addZero(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ( (charCode > 31 && charCode < 48) || charCode > 57) {
                return false;
            }
            return true;
        }

        function number_format(nStr)
        {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

        function buyItem(el) {
            var item = jQuery(el);
            $('#buyItemEffects').html('');

            if (item.data('category') == 4) {
                $("#buyItemEffectsColTitle").html('Items');
                var subitems = item.data('subitems');
                for (const entry in subitems) {
                    var listLabel = $("<small/>");
                    listLabel.html(subitems[entry].Name);

                    var listItem = $("<li/>");
                    listItem.attr('class', 'list-group-item shopToolTip');
                    listItem.html(listLabel);
                    listItem.attr('data-toggle', 'tooltip');
                    listItem.attr('data-html', 'true');
                    listItem.attr('title', '<img src="storage/'+ subitems[entry].Image +'" />');
                    listItem.appendTo('#buyItemEffects');
                }

                if (subitems.length == 0) {
                    $("#buyItemEffectsCol").hide();
                } else {
                    $("#buyItemEffectsCol").show();
                }
            } else {
                $("#buyItemEffectsColTitle").html('Effects');
                for (var key in item.data('effects')) {
                    var listLabel = $("<small/>");
                    listLabel.html(item.data('effects')[key]);

                    var listItem = $("<li/>");
                    listItem.attr('class', 'list-group-item');
                    listItem.html(listLabel);
                    listItem.appendTo('#buyItemEffects');
                }

                if (item.data('effects').length == 0) {
                    $("#buyItemEffectsCol").hide();
                } else {
                    $("#buyItemEffectsCol").show();
                }
            }

            $('#buyErrorWrapper').hide();
            $('#buyInputPin').val('');
            $('#buyItemId').val(item.data('itemid'));

            $("#buyItemQty").val(item.data('minqty'));
            $("#buyItemQty").attr({
                "max" : item.data('maxqty'),
                "min" : item.data('minqty')
            });
            $('#buyItemInfo').html(item.data('name'));
            $('#buyItemDesc').html(item.data('description'));
            $('#buyItemImg').attr('src', item.data('image'));
            $('#buyItemPrice').html(number_format(item.data('price')));
            $('#labelTotal').val(number_format(item.data('price')));
            $('#modalBuy').modal('show');

            $("#buyItemQty").on("change", function() {
                var total   = $(this).val() * item.data('price');
                $('#labelTotal').val(number_format(total));
            });
        }

        $( document ).ready(function() {
            $.fn.changeElementType = function( newType ){
                var $this = this;
                if (this.get(0).tagName == newType.toUpperCase()) {
                    return;
                }

                this.each( function( index ){

                    var atts = {};
                    $.each( this.attributes, function(){
                        atts[ this.name ] = this.value;
                    });

                    var $old = $(this);
                    var $new = $('<'+ newType +'/>', atts ).append(  $old.contents()  );
                    $old.replaceWith( $new );

                    $this[ index ] = $new[0];
                });

                return this;
            };

            $("input[type='number']").inputSpinner();

            $( "#btn-login" ).click(function() {
                $( "#btn-login" ).prop('disabled', true);
                $.post( "{{ route('api.login',[],false) }}", $( "#form-login" ).serialize())
                    .done(function(data) {
                        $("#btn-login").prop('disabled', false);
                        if (data.message === 'success') {
                            $("#main-component div").fadeOut(300, function() {
                                $("#main-component").hide();
                                $("#main-component").html(data.html);
                                $("#main-component div").hide();
                                $("#main-component").show();
                                $("#main-component div").fadeIn(700);
                            });
                        }

                    })
                    .fail( function(xhr, textStatus, errorThrown) {
                        $("#btn-login").prop('disabled', false);
                        $('#modal').modal('show');
                        $('#modal .modal-title').html('Login failure');
                        $('#modal .modal-body').html('');
                        $.each(xhr.responseJSON.errors, function (key, data) {
                            $('#modal .modal-body').append(data[0]);
                            return false;
                        })
                    });
            });

            $( "#btn-password" ).click(function( event ) {
                $("#btn-password").prop('disabled', true);
                $.post( "{{ route('api.update-password',[],false) }}", $( "#form-password" ).serialize())
                    .done(function(data) {
                        $("#form-password").trigger('reset');
                        $("#btn-password").prop('disabled', false);
                        $('#modal').modal('show');
                        $('#modal .modal-title').html('Update success');
                        $('#modal .modal-body').html(data.message);
                    })
                    .fail( function(xhr, textStatus, errorThrown) {
                        $("#form-password").trigger('reset');
                        $("#btn-password").prop('disabled', false);
                        $('#modal').modal('show');
                        $('#modal .modal-title').html('Update failure');
                        $('#modal .modal-body').html('');
                        $.each(xhr.responseJSON.errors, function (key, data) {
                            $('#modal .modal-body').append(data[0]);
                            return false;
                        })
                    });
            });

            $( "#btn-pin" ).click(function( event ) {
                $('#modalPINErrorWrapper').fadeOut();
                $("#pin").prop('disabled', true);
                $("#modalPINInfo").hide();

                $.ajax({
                    url: "{{ route('pin.setup',[],false) }}",
                    method: "POST",
                    dataType: 'json',
                    data: new FormData($("#modalPINForm")[0]),
                    processData: false,
                    contentType: false,
                    success: function(data){
                        if (data.message === 'success') {
                            location.href = '{{ route('dashboard') }}';
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                        $("#btn-pin").prop('disabled', false);
                        $('#modalPINErrorMsg').html(xhr.responseJSON.message);
                        $('#modalPINErrorList').html('');
                        if (xhr.responseJSON.hasOwnProperty('errors')) {
                            $.each(xhr.responseJSON.errors, function (key, data) {
                                var listItem = $("<li/>");
                                listItem.html(data[0]);
                                listItem.appendTo("#modalPINErrorList");
                            })
                        }

                        $('#modalPINErrorWrapper').fadeIn();
                    }
                });
            });


            $( ".user-map" ).click(function( event ) {
                var outer = $(this);
                $.post( "{{ route('api.update-map',[],false) }}", {
                    char_id: $(this).data('char'),
                    map_id: $(this).data('map'),
                    _token: "{{ csrf_token() }}"
                })
                    .done(function(data) {
                        $('#modal').modal('show');
                        $('#modal .modal-title').html('Teleport success');
                        $('#modal .modal-body').html(data.message);
                        // $(this).parent().closest("button").html("Wee");
                        outer.parent().parent().children('button').html(' ' + outer.html() + ' ');
                    })
                    .fail( function(xhr, textStatus, errorThrown) {
                        $('#modal').modal('show');
                        $('#modal .modal-title').html('Teleport failure');
                        $('#modal .modal-body').html('');
                        $.each(xhr.responseJSON.errors, function (key, data) {
                            $('#modal .modal-body').append(data[0]);
                            return false;
                        })
                    });
            });

            setInterval(myTimer, 1000);
            var servertime = new Date('{{ date('D M d Y H:i:s O') }}');
            function myTimer() {
                servertime.setSeconds(servertime.getSeconds() + 1);
                $('.server_hrs').html(addZero(servertime.getHours()));
                $('.server_mins').html(addZero(servertime.getMinutes()));
                $('.server_secs').html(addZero(servertime.getSeconds()));
            }

            $( ".close" ).click(function() {
                $('#buyErrorWrapper').fadeOut();
                $('#modalItemEditorErrorWrapper').fadeOut();
                $('#modalPINErrorWrapper').fadeOut();
            });

            $( "#btn-buy" ).click(function() {
                $('#buyErrorWrapper').fadeOut();
                $( "#btn-buy" ).prop('disabled', true);
                $.post( "{{ route('shop',[],false) }}", $( "#form-buy" ).serialize())
                    .done(function(data) {
                        if (data.message === 'success') {
                            location.href = '{{ route('shop') }}';
                        }
                    })
                    .fail( function(xhr, textStatus, errorThrown) {
                        $("#btn-buy").prop('disabled', false);
                        $('#buyErrorMsg').html(xhr.responseJSON.message);
                        $('#buyErrorList').html('');
                        if (xhr.responseJSON.hasOwnProperty('errors')) {
                            $.each(xhr.responseJSON.errors, function (key, data) {
                                var listItem = $("<li/>");
                                listItem.html(data[0]);
                                listItem.appendTo("#buyErrorList");
                            })
                        }

                        $('#buyErrorWrapper').fadeIn();
                    });
            });

            $('#modalItemEditorCategory').on('change', function() {
                $('#modalItemEditorQty').attr('value', '1');
                if (this.value == 4) {
                    $('#modalItemEditorQty').attr('min', '1');
                    $('#modalItemEditorQty').attr('max', '100');
                    $("#subItemsWrapper").fadeIn();
                    $("#modalItemEditorEffectsRow").hide();
                } else {
                    $('#modalItemEditorQty').attr('min', '1');
                    $('#modalItemEditorQty').attr('max', '1');
                    $("#subItemsWrapper").hide();
                    $("#modalItemEditorEffectsRow").fadeIn();
                }
            });

            $(document).on('change', '.custom-file-input', function (event) {
                $(this).next('.custom-file-label').html(event.target.files[0].name);
            })

            @if(Auth::check() && Auth::user()->pin == null)
            $('#modalPINErrorWrapper').hide();
            $("#modalPIN").modal('show');
            @endif

            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('#startDate').datepicker({
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
                maxDate: today,
            });
            $('#endDate').datepicker({
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
                minDate: function () {
                    return $('#startDate').val();
                },
                maxDate: today
            });

            $('#itemDeliveryUsernameCol > .bootstrap-tagsinput > input').on('paste', function (e) {
                var pastedData = e.originalEvent.clipboardData.getData('text');
                var array = pastedData.match(/[^\s]+/g);
                $.each(array, function( index, value ) {
                    $('#itemDeliveryName').tagsinput('add', value);
                });

                e.preventDefault();
            });

            $("#subItemsWrapper").on("click", "#addSubItem", function(e){
                e.preventDefault();
                var subitems = JSON.parse($('#modalItemEditorSubItems').val());
                subitems.push({"MallItemID": $('#modalItemEditorId').val(),"Name":"","Image":""});
                $("#subItems").append('<div class="input-group mt-2"> <input onfocus="this.oldvalue = this.value;" onchange="subItemsOnChange(this)"  type="text" name="sub_item_name[]" class="form-control m-input" placeholder="Item Name" autocomplete="off"> <div class="input-group-append"> <button type="button" class="btn btn-danger removeSubItem">-</button> </div> <div class="custom-file" style="margin-left: 7px; padding-left: 60px;"> <input onchange="subItemsOnChange(this)" type="file" class="custom-file-input" name="sub_item_img[]"> <label class="custom-file-label"></label> </div> </div>');
                $('#modalItemEditorSubItems').val(JSON.stringify(subitems));
            });

            $("#subItemsWrapper").on("click", ".removeSubItem", function(e){
                e.preventDefault();
                var subitems = JSON.parse($('#modalItemEditorSubItems').val());
                var itemName = $(this).parents(".input-group").find('input:eq(0)').val();
                for (let [i, subitem] of subitems.entries()) {
                    if (subitem.Name == itemName) {
                        subitems.splice(i, 1);
                        break;
                    }
                }

                $(this).parents(".input-group").remove();
                $('#modalItemEditorSubItems').val(JSON.stringify(subitems));
            });

            $('body').tooltip({
                selector: '.shopToolTip',
                animated : 'fade',
                placement : 'right',
                container : 'body',
            });
        });
    </script>

    <footer class="mastfoot">
        <img class="w-100 footer-img" src="/storage/img/bg002.jpg" alt="footer">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="float-left">
                        <span>&copy Luna Online Odyssey</span>
                        <small class="text-muted d-block">All registered trademarks belongs to their respective owners and EYA SOFT CO., Ltd.</small>
                    </div>
                </div>
                <div class="col-6">
                    <a class="float-right pl-3" href="{{ Helper::getSetting('social_facebook') }}" target="_blank">
                        <i class="fab fa-facebook-f fa-2x"></i>
                    </a>
                    <a class="float-right pl-3" href="{{ Helper::getSetting('social_instagram') }}" target="_blank">
                        <i class="fab fa-instagram fa-2x"></i>

                    </a>
                    <a class="float-right pl-3" href="{{ Helper::getSetting('social_discord') }}" target="_blank">
                        <i class="fab fa-discord fa-2x"></i>
                    </a>
                </div>
            </div>
        </div>

    </footer>

</div>
</body>
</html>
