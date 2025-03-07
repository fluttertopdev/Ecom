@extends('website.layout.app')
@section('content')
<div id="cartTable">
    <?php
    $Symbol = \Helpers::getActiveCurrencySymbol();
    ?>
    <main class="main">
        <div class="section-box">
            <div class="breadcrumbs-div">
                <div class="container">
                    <ul class="breadcrumb">
                        <li><a class="font-xs color-gray-1000" href="{{url('/')}}">{{__('lang.Home')}}</a></li>
                        <li><a class="font-xs color-gray-500" href="{{url('/')}}">{{__('lang.Shop')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <section class="section-box shop-template">
            <div class="container mb-40 mt-40" style="min-height:550px;">
                <div class="row">

                    @if(count($res_data) > 0)
                    <!-- Cart Items -->
                    <div class="col-lg-9">
                        <div class="box-carts">
                            <div class="table-responsive">
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>{{__('lang.Product')}}</th>
                                            <th>{{__('lang.Unit_Price')}}</th>
                                            <th>{{__('lang.Quantity')}}</th>
                                            <th>{{__('lang.Remove')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalPrice = 0;
                                        $totalDiscount = 0;
                                        $finalTotal = 0;
                                        @endphp

                                        @foreach($res_data as $list)
                                        @php
                                        $productdiscountamount = $list->product_price * ($list->product->discount / 100);
                                        if (setting('including_tax') == 0) {
                                        $totalPrice += ($list->product_price + $list->producttaxprice) * $list->qty;
                                        $totalDiscount += $productdiscountamount * $list->qty;
                                        $finalTotal += ($list->price_after_discount + $list->producttaxprice) * $list->qty;
                                        } else {
                                        $totalPrice += ($list->product_price * $list->qty);
                                        $totalDiscount += $productdiscountamount * $list->qty;
                                        $finalTotal += ($list->price_after_discount) * $list->qty;
                                        }
                                        @endphp


                                        <tr>
                                            <td class="d-flex align-items-center justify-content-center">
                                                <div class="product-wishlist">
                                                    <div class="product-image me-3">
                                                        <a href="{{ url('product-details/'.$list->product->slug) }}">
                                                            <img src="{{ asset($list->product_image) }}" alt="Ecom" style="width: 50px; height: 50px;">
                                                        </a>
                                                    </div>
                                                    <div class="product-info">
                                                        <a href="{{ url('product-details/'.$list->product->slug) }}">
                                                            <h6 class="color-brand-3 m-0">{{ Str::words($list->product->name, 2, '...') }}</h6>

                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if(setting('including_tax') == 0)
                                                <h4 class="color-brand-3 m-0">{{$Symbol}}{{ number_format($list->price_after_discount + $list->producttaxprice, 2, '.', ',') }}</h4>
                                                @else
                                                <h4 class="color-brand-3 m-0">{{$Symbol}}{{ number_format($list->price_after_discount, 2, '.', ',') }}</h4>
                                                @endif
                                                @if(!is_null($list->product->discount) && $list->product->discount != 0)
                                                <small class="text-muted" style="text-decoration: line-through;">
                                                    MRP: {{$Symbol}}{{ number_format(setting('including_tax') == 0 ? $list->product_price + $list->producttaxprice : $list->product_price, 2, '.', ',') }}
                                                </small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="box-quantity">
                                                    <div class="input-quantity">
                                                        <input class="font-xl color-brand-3 updateCartqty" type="text" value="{{ $list->qty }}"
                                                            data-variantid="{{ $list->variants_id }}"
                                                            data-productid="{{ $list->product_id }}"
                                                            readonly> <!-- Prevent manual entry -->
                                                        <span class="minus-cart"></span>
                                                        <span class="plus-cart"></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="btn btn-delete remove-cart" data-product_id="{{ $list->product_id }}"></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Cart -->
                    <div class="col-lg-3 mt-30">
                        <div class="summary-cart">
                            <div class="mb-10 pb-3 border-bottom">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="font-md-bold color-gray-500">Price ({{$cart_count}})</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <h4>{{$Symbol}}{{ number_format($totalPrice, 2, '.', ',') }}</h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Discount Label -->
                            <div class="mb-10 pb-3 border-bottom">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="font-md-bold color-gray-500">{{__('lang.Discount')}}</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <h4>{{$Symbol}}{{ number_format($totalDiscount, 2, '.', ',') }}</h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Final Total -->
                            <div class="mb-10 pb-3 border-bottom">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="font-md-bold color-gray-500">{{__('lang.Total')}}</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <h4>{{$Symbol}}{{ number_format($finalTotal, 2, '.', ',') }}</h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Proceed to Checkout Button -->
                            <div class="box-button">
                                <a class="btn btn-custom w-100" href="{{ url('checkout') }}">{{__('lang.proceed_to_checkout')}}</a>
                            </div>
                        </div>
                    </div>

                    @else
                    <!-- Empty Cart Section -->
                    <div class="col-12 text-center mb-10">
                        <img src="{{asset('uploads/empty-cart.png')}}" alt="Empty Cart" style="max-width: 250px;">
                        <h3 class="mt-4">{{__('Your cart is empty!')}}</h3>
                        <p>{{__('Add items to it now.')}}</p>
                        <a href="{{ url('/') }}" class="btn btn Light mt-4" style="background-color:#FD9636; color:white;">{{__('Shop now')}}</a>
                    </div>
                    @endif

                </div>
            </div>
        </section>
    </main>
</div>
@endsection
