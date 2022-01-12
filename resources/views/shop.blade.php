@extends('layouts.main')
@section('content')
    @include('components.modal-shop')

    <div class="row tile p-4 mx-0 my-4">
        <div class="col m-auto w-100">
            <x-auth-validation-errors class="alert alert-danger" role="alert" :errors="$errors" />
            @if(Session::has('item_purchased'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Holy guacamole!</strong> You have just purchased <u>{{ Session::get('item_purchased') }}</u>, the item has been sent to your in-game inventory.

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <ul class="row nav nav-pills mb-4 text-center category-menu" id="pills-tab" role="tablist">
                <li class="col nav-item" role="presentation">
                    <a class="nav-link active" id="pills-equipment-tab" data-toggle="pill" href="#pills-equipment" role="tab" aria-controls="pills-equipment" aria-selected="true">
                        <div class="category-image cat1"></div>
                        Equipment
                    </a>
                </li>
                <li class="col nav-item" role="presentation">
                    <a class="nav-link" id="pills-costume-tab" data-toggle="pill" href="#pills-costume" role="tab" aria-controls="pills-costume" aria-selected="false">
                        <div class="category-image cat2"></div>
                        Costume
                    </a>
                </li>
                <li class="col nav-item" role="presentation">
                    <a class="nav-link" id="pills-acc-tab" data-toggle="pill" href="#pills-acc" role="tab" aria-controls="pills-acc" aria-selected="false">
                        <div class="category-image cat3"></div>
                        Accessories
                    </a>
                </li>
                <li class="col nav-item" role="presentation">
                    <a class="nav-link" id="pills-consumable-tab" data-toggle="pill" href="#pills-consumable" role="tab" aria-controls="pills-consumable" aria-selected="false">
                        <div class="category-image cat4"></div>
                        Consumables
                    </a>
                </li>
                <li class="col nav-item" role="presentation">
                    <a class="nav-link" id="pills-backgear-tab" data-toggle="pill" href="#pills-backgear" role="tab" aria-controls="pills-backgear" aria-selected="false">
                        <div class="category-image cat5"></div>
                        Back Gear
                    </a>
                </li>
                <li class="col nav-item" role="presentation">
                    <a class="nav-link" id="pills-style-tab" data-toggle="pill" href="#pills-style" role="tab" aria-controls="pills-style" aria-selected="false">
                        <div class="category-image cat6"></div>
                        Style
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-equipment" role="tabpanel" aria-labelledby="pills-equipment-tab">
                    <div class="row row-cols-1 row-cols-md-4 text-center grid" >
                        @foreach (App\Models\ItemMall::where('category', 1)->orderBy('name')->get() as $item)
                            <div class="col-lg-3 col-sm-12 col-md-6 mb-4 grid-item">
                                <div class="card h-100">
                                    @switch($item->featured_label)
                                        @case(1)
                                        <div class="featured-item featured-new"></div>
                                        @break
                                        @case(2)
                                        <div class="featured-item featured-hot"></div>
                                        @break
                                    @endswitch
                                    <img src="{{ $item->img }}" class="card-img-top card-product" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title card-shop-title">{{ $item->name }}</h5>
                                        <p class="card-text"><img src="{{ asset('storage/img/coin.png') }}" alt="coin" style="width: 25px"> {{ number_format($item->price) }}</p>
                                        <button data-itemid="{{ $item->item_id }}"
                                                data-name="{{ $item->name }}"
                                                data-minqty="{{ $item->min_quantity }}"
                                                data-maxqty="{{ $item->max_quantity }}"
                                                data-description="{{ $item->description }}"
                                                data-price="{{ $item->price }}"
                                                data-effects='{{ $item->effects }}'
                                                data-image="{{ $item->img }}"
                                                data-category="{{ $item->category }}"
                                                data-subitems="{{ App\Models\ItemMallChild::where('MallItemID', $item->item_id)->get()->toJson() }}"

                                                class="btn btn-main-boder view_detail card-buy" type="button" onclick="buyItem(this)">
                                            <b>BUY NOW</b>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-costume" role="tabpanel" aria-labelledby="pills-costume-tab">
                    <div class="row row-cols-1 row-cols-md-4 text-center grid" >
                        @foreach (App\Models\ItemMall::where('category', 2)->orderBy('name')->get() as $item)
                            <div class="col-lg-3 col-sm-12 col-md-6 mb-4 grid-item">
                                <div class="card h-100">
                                    @switch($item->featured_label)
                                        @case(1)
                                        <div class="featured-item featured-new"></div>
                                        @break
                                        @case(2)
                                        <div class="featured-item featured-hot"></div>
                                        @break
                                    @endswitch
                                    <img src="{{ $item->img }}" class="card-img-top card-product" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title card-shop-title">{{ $item->name }}</h5>
                                        <p class="card-text"><img src="{{ asset('storage/img/coin.png') }}" alt="coin" style="width: 25px"> {{ number_format($item->price) }}</p>
                                        <button data-itemid="{{ $item->item_id }}"
                                                data-name="{{ $item->name }}"
                                                data-minqty="{{ $item->min_quantity }}"
                                                data-maxqty="{{ $item->max_quantity }}"
                                                data-description="{{ $item->description }}"
                                                data-price="{{ $item->price }}"
                                                data-effects='{{ $item->effects }}'
                                                data-image="{{ $item->img }}"
                                                data-category="{{ $item->category }}"
                                                data-subitems="{{ App\Models\ItemMallChild::where('MallItemID', $item->item_id)->get()->toJson() }}"

                                                class="btn btn-main-boder view_detail card-buy" type="button" onclick="buyItem(this)">
                                            <b>BUY NOW</b>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-acc" role="tabpanel" aria-labelledby="pills-acc-tab">
                    <div class="row row-cols-1 row-cols-md-4 text-center grid" >
                        @foreach (App\Models\ItemMall::where('category', 3)->orderBy('name')->get() as $item)
                            <div class="col-lg-3 col-sm-12 col-md-6 mb-4 grid-item">
                                <div class="card h-100">
                                    @switch($item->featured_label)
                                        @case(1)
                                        <div class="featured-item featured-new"></div>
                                        @break
                                        @case(2)
                                        <div class="featured-item featured-hot"></div>
                                        @break
                                    @endswitch
                                    <img src="{{ $item->img }}" class="card-img-top card-product" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title card-shop-title">{{ $item->name }}</h5>
                                        <p class="card-text"><img src="{{ asset('storage/img/coin.png') }}" alt="coin" style="width: 25px"> {{ number_format($item->price) }}</p>
                                        <button data-itemid="{{ $item->item_id }}"
                                                data-name="{{ $item->name }}"
                                                data-minqty="{{ $item->min_quantity }}"
                                                data-maxqty="{{ $item->max_quantity }}"
                                                data-description="{{ $item->description }}"
                                                data-price="{{ $item->price }}"
                                                data-effects='{{ $item->effects }}'
                                                data-image="{{ $item->img }}"
                                                data-category="{{ $item->category }}"
                                                data-subitems="{{ App\Models\ItemMallChild::where('MallItemID', $item->item_id)->get()->toJson() }}"

                                                class="btn btn-main-boder view_detail card-buy" type="button" onclick="buyItem(this)">
                                            <b>BUY NOW</b>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-consumable" role="tabpanel" aria-labelledby="pills-consumable-tab">
                    <div class="row row-cols-1 row-cols-md-4 text-center grid" >
                        @foreach (App\Models\ItemMall::where('category', 4)->orderBy('name')->get() as $item)
                            <div class="col-lg-3 col-sm-12 col-md-6 mb-4 grid-item">
                                <div class="card h-100">
                                    @switch($item->featured_label)
                                        @case(1)
                                        <div class="featured-item featured-new"></div>
                                        @break
                                        @case(2)
                                        <div class="featured-item featured-hot"></div>
                                        @break
                                    @endswitch
                                    <img src="{{ $item->img }}" class="card-img-top card-product" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title card-shop-title">{{ $item->name }}</h5>
                                        <p class="card-text"><img src="{{ asset('storage/img/coin.png') }}" alt="coin" style="width: 25px"> {{ number_format($item->price) }}</p>
                                        <button data-itemid="{{ $item->item_id }}"
                                                data-name="{{ $item->name }}"
                                                data-minqty="{{ $item->min_quantity }}"
                                                data-maxqty="{{ $item->max_quantity }}"
                                                data-description="{{ $item->description }}"
                                                data-price="{{ $item->price }}"
                                                data-effects='{{ $item->effects }}'
                                                data-image="{{ $item->img }}"
                                                data-category="{{ $item->category }}"
                                                data-subitems="{{ App\Models\ItemMallChild::where('MallItemID', $item->item_id)->get()->toJson() }}"

                                                class="btn btn-main-boder view_detail card-buy" type="button" onclick="buyItem(this)">
                                            <b>BUY NOW</b>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-backgear" role="tabpanel" aria-labelledby="pills-backgear-tab">
                    <div class="row row-cols-1 row-cols-md-4 text-center grid" >
                        @foreach (App\Models\ItemMall::where('category', 5)->orderBy('name')->get() as $item)
                            <div class="col-lg-3 col-sm-12 col-md-6 mb-4 grid-item">
                                <div class="card h-100">
                                    @switch($item->featured_label)
                                        @case(1)
                                        <div class="featured-item featured-new"></div>
                                        @break
                                        @case(2)
                                        <div class="featured-item featured-hot"></div>
                                        @break
                                    @endswitch
                                    <img src="{{ $item->img }}" class="card-img-top card-product" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title card-shop-title">{{ $item->name }}</h5>
                                        <p class="card-text"><img src="{{ asset('storage/img/coin.png') }}" alt="coin" style="width: 25px"> {{ number_format($item->price) }}</p>
                                        <button data-itemid="{{ $item->item_id }}"
                                                data-name="{{ $item->name }}"
                                                data-minqty="{{ $item->min_quantity }}"
                                                data-maxqty="{{ $item->max_quantity }}"
                                                data-description="{{ $item->description }}"
                                                data-price="{{ $item->price }}"
                                                data-effects='{{ $item->effects }}'
                                                data-image="{{ $item->img }}"
                                                data-category="{{ $item->category }}"
                                                data-subitems="{{ App\Models\ItemMallChild::where('MallItemID', $item->item_id)->get()->toJson() }}"

                                                class="btn btn-main-boder view_detail card-buy" type="button" onclick="buyItem(this)">
                                            <b>BUY NOW</b>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-style" role="tabpanel" aria-labelledby="pills-style-tab">
                    <div class="row row-cols-1 row-cols-md-4 text-center grid" >
                        @foreach (App\Models\ItemMall::where('category', 6)->orderBy('name')->get() as $item)
                            <div class="col-lg-3 col-sm-12 col-md-6 mb-4 grid-item">
                                <div class="card h-100">
                                    @switch($item->featured_label)
                                        @case(1)
                                        <div class="featured-item featured-new"></div>
                                        @break
                                        @case(2)
                                        <div class="featured-item featured-hot"></div>
                                        @break
                                    @endswitch
                                    <img src="{{ $item->img }}" class="card-img-top card-product" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title card-shop-title">{{ $item->name }}</h5>
                                        <p class="card-text"><img src="{{ asset('storage/img/coin.png') }}" alt="coin" style="width: 25px"> {{ number_format($item->price) }}</p>
                                        <button data-itemid="{{ $item->item_id }}"
                                                data-name="{{ $item->name }}"
                                                data-minqty="{{ $item->min_quantity }}"
                                                data-maxqty="{{ $item->max_quantity }}"
                                                data-description="{{ $item->description }}"
                                                data-price="{{ $item->price }}"
                                                data-effects='{{ $item->effects }}'
                                                data-image="{{ $item->img }}"
                                                data-category="{{ $item->category }}"
                                                data-subitems="{{ App\Models\ItemMallChild::where('MallItemID', $item->item_id)->get()->toJson() }}"

                                                class="btn btn-main-boder view_detail card-buy" type="button" onclick="buyItem(this)">
                                            <b>BUY NOW</b>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


        </div>
    </div>
@stop
