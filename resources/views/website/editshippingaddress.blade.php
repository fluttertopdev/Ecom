@extends('website.layout.app')
@section('content')


    <main class="main">

      <section class="section-box shop-template mt-60">
        <div class="container">
          <div class="row mb-100">
        
            <div class="col-md-12">
              <h3>Shipping address</h3>
     
           
                
                  <form id="shippingForm" action="{{url('update-shipping-address')}}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <h5 class="font-md-bold color-brand-3 mt-15 mb-20">Edit Shipping address</h5>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <input class="form-control font-sm" value="{{$delivery_address->name}}" name="name" type="text" placeholder="Name*" required>
                <input type="hidden" value="{{$delivery_address->id}}" name="shippingid">
                <div class="error-message text-danger" id="nameError"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <input class="form-control font-sm" value="{{$delivery_address->email}}" name="email" type="text" placeholder="Email*" required>
                <div class="error-message text-danger" id="emailError"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <input class="form-control font-sm" value="{{$delivery_address->phone}}" name="phone" type="text"   oninput="this.value = this.value.replace(/\D/g, '').slice(0, 12);" 
           pattern="[0-9]{10}" placeholder="Phone*" required>
                <div class="error-message text-danger" id="phoneError"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <select class="form-control font-sm select-style1 color-gray-700" name="countryid" id="category-select" required>
                    <option value="">Select Country</option>
                    @foreach($country_data as $country)
                        <option value="{{ $country->id }}" 
                            {{ $country->id == $delivery_address->country_id ? 'selected' : '' }}>
                            {{$country->name}}
                        </option>
                    @endforeach
                </select>
                <div class="error-message text-danger" id="countryError"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <select class="form-control font-sm select-style1 color-gray-700" name="stateid" id="State-select" required>
                    <option value="">Select State</option>
                    @foreach($state_data as $state)
                        <option value="{{ $state->id }}" 
                            {{ $state->id == $delivery_address->state_id ? 'selected' : '' }}>
                            {{ $state->name }}
                        </option>
                    @endforeach
                </select>
                <div class="error-message text-danger" id="stateError"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <select class="form-control font-sm select-style1 color-gray-700" name="cityid" id="city-select" required>
                    <option value="">Select City</option>
                    @foreach($city_data as $city)
                        <option value="{{ $city->id }}" 
                            {{ $city->id == $delivery_address->city_id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
                <div class="error-message text-danger" id="cityError"></div>
            </div>
        </div>
        
        <div class="col-lg-6">
    <div class="form-group">
        <select class="form-control font-sm select-style1 color-gray-700" name="postCode" id="zipcode-select" required>
            <option value="">Select Zipcode</option>
            @foreach($zipcodes as $each)
                <option value="{{ $each }}" 
                    {{ $each == $delivery_address->zip_code ? 'selected' : '' }}>
                    {{ $each }}
                </option>
            @endforeach
        </select>
    </div>
</div>
       
        <div class="col-lg-6">
            <div class="form-group">
                <textarea class="form-control font-sm" name="address" placeholder="Address" required>{{$delivery_address->address}}</textarea>
                <div class="error-message text-danger" id="addressError"></div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group mb-0">
                <textarea class="form-control font-sm" name="landmark" placeholder="Land Mark(Optional)" rows="5">{{$delivery_address->landmark}}</textarea>
            </div>
        </div>
    </div>
    <div class="col-12 text-center mt-4">
        <button type="submit" class="btn btn-buy w-auto">Save</button>
        <a href="{{url('my-account')}}"><button type="button" class="btn btn-buy w-auto btn-reset">Cancel</button></a>
    </div>
</form>



              </div>

            </div>
           
          </div>
        </div>

      </section>

   
    </main>


       @endsection


      
