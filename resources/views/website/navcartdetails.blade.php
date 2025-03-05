<div class="dropdown-cart">
    @if($res_data->isEmpty())
        <div class="no-products text-center">
            <p>No products in cart</p>
        </div>
    @else
        @foreach($res_data as $list)
            <div class="item-cart mb-20">
                <div class="cart-image">
                    <img src="{{ url('uploads/'.$list->image_prefix.$list->first_image) }}" alt="Ecom">
                </div>
                <div class="cart-info">
                    <a class="font-sm-bold color-brand-3" href="shop-single-product.html">{{ $list->product_name }}</a>
                    <p>
                        <span class="color-brand-2 font-sm-bold">{{ $list->qty }} ₹{{ $list->variantprice }}</span>
                    </p>
                </div>
            </div>
        @endforeach
        
        <div class="border-bottom pt-0 mb-15"></div>
        <div class="cart-total">
            <div class="row">
                <div class="col-6 text-start"><span class="font-md-bold color-brand-3">Total</span></div>
                <div class="col-6"><span class="font-md-bold color-brand-1">₹{{ $total }}</span></div>
            </div>
            <div class="row mt-15">
                <div class="col-6 text-start"><a class="btn btn-cart w-auto" href="{{ url('cart-details') }}">View cart</a></div>
                <div class="col-6"><a class="btn btn-buy w-auto" href="{{url('checkout')}}">Checkout</a></div>
            </div>
        </div>
    @endif
</div>
