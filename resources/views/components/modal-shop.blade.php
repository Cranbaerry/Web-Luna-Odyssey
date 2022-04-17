<div class="modal fade" id="modalBuy" tabindex="-1" role="dialog" aria-labelledby="modelItemInfo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form-buy" method="POST" action="{{ route('shop') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="buyItemInfo">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="buyErrorWrapper">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong id="buyErrorMsg">{{ __('Whoops! Something went wrong.') }}</strong>
                            <div id="buyErrorList"></div>
                            <button type="button" class="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="row align-items-center h-100">
                        <div class="col text-center mx-auto">
                            <img id="buyItemImg" src="" class="card-product" alt="item img" />
                            <div class="price d-block">
                                <img src="{{ asset('storage/img/coin.png') }}" alt="coin" style="width: 25px">
                                <span id="buyItemPrice"></span>
                            </div>
                        </div>
                        <div id="buyItemEffectsCol" class="col">
                            <div class="tile h-100 p-3 w-100 text-center mx-auto" style="background: aliceblue;">

                                <span><strong id="buyItemEffectsColTitle">Effects</strong></span>
                                <ul id="buyItemEffects" class="list-group list-group-flush mt-2 overflow-auto" style="height: 240px; overflow-y: scroll;">

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col px-5">
                            <input type="hidden" id="buyItemId" name="itemid" value="">
                            <p id="buyItemDesc" class="mt-4 text-center">

                            </p>

                            <div class="form-group row">
                                <label for="inputQty" class="col-sm-2 col-form-label">Quantity</label>
                                <div class="col-sm-10">
                                    <input name="qty" id="buyItemQty" class="form-control h-auto" type="number" value="1" min="1" max="100" step="1"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="labelTotal" class="col-sm-2 col-form-label">Total</label>
                                <div class="col-sm-10">
                                    <input type="name" readonly="" class="form-control" id="labelTotal" value="BCA KlikPay" disabled>
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <label for="inputPIN" class="col-sm-2 col-form-label">PIN</label>
                                <div class="col-sm-10">
                                    <input name="pin" type="password" class="form-control" id="buyInputPin" placeholder="PIN Number" maxlength="4" inputmode="numeric" onkeypress="return isNumber(event)" onpaste="return false;">
                                    <small class="form-text text-muted pl-1">PIN consists of 4 numbers that is used for item purchase confirmations and cannot be changed. <a href="{{ route('pin.request') }}">Forgot your PIN?</a></small>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    @if(Auth::check())
                        <p class="float-left mr-auto">
                            My Cash Points: <strong>{{  number_format(Auth::user()->UserPointMall) }}</strong>
                            <small class="d-block text-muted">Currently logged in as {{ Auth::user()->id_loginid }}</small>
                        </p>
                    @endif
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="btn-buy" type="button" class="btn btn-primary">Purchase</button>
                </div>
            </form>
        </div>
    </div>
</div>
