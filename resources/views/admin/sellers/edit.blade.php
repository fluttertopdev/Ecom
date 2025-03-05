@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .identity_image_upload_btn {
        color: #ffffff;
        border-color: #7367f0;
        background: #7266ee;
        border: 1px solid;
        padding: 4px 6px;
        cursor: pointer;
        border-radius: 6px;
        width: 240px;
    }
    .upload_identity_image_show{
        height: 120px;
        width: 240px;
        margin-bottom: 5px;
    }
</style>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">


    <form action="{{url('admin/update-sellers')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-8">
                <h4 class="py-3 mb-4">
                  <span class="text-muted fw-light">
                    <a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> /
                  </span><span class="text-muted fw-light">
                  </span>
                  Edit Seller</h4>
            </div>
            <div class="col-md-4">
                <div class="table-btn-css">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        <span class="ti-xs ti ti-plus me-1"></span>{{__('lang.admin_update')}}
                    </button>
                    <a type="reset" class="btn btn-outline-secondary" href="{{url('admin/all-sellers')}}">{{__('lang.admin_back')}}</a>
                </div>
            </div>
        </div>
        

        <!-- Add -->
          <div class="row">
                  <!-- First column-->
                  <div class="col-12 col-lg-12">

                    <!-- General Information -->
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-tile mb-0">{{__('lang.admin_general_info')}}</h5>
                      </div>
                      <div class="card-body row">

                          <div class="col-md-12 row">
                            <input type="hidden" name="id" value="{{$result->id}}">
                            <!-- name -->
                            <div class="mb-3 col-md-4">
                              <label class="form-label" for="ecommerce-product-name">{{__('lang.admin_name')}} <span class="required">*</span></label>
                              <input
                                type="text"
                                class="form-control"
                                id="ecommerce-product-name"
                                placeholder="{{__('lang.admin_name_placeholder')}}"
                                name="name"
                                value="{{$result->name}}"
                                aria-label="{{__('lang.admin_name')}}" required/>
                            </div>

                            <!-- email -->
                           

                           <div class="mb-3 col-md-4">
                              <label class="form-label" for="ecommerce-product-name">{{__('lang.admin_email')}} <span class="required">*</span></label>
                              <input
                                type="text"
                                class="form-control"
                                id="ecommerce-product-name"
                                placeholder="{{__('lang.admin_email_placeholder')}}"
                                name="email"
                                value="{{$result->email}}"
                                aria-label="{{__('lang.admin_email')}}" required/>
                            </div>

                             <div class="mb-3 col-md-4">
                              <label class="form-label" for="ecommerce-product-name">Shop Name<span class="required">*</span></label>
                              <input
                                type="text"
                                class="form-control"
                                id="ecommerce-product-name"
                                placeholder="Shop Name"
                                name="shopname"
                                value="{{$result->shopname}}"
                                aria-label="shop name}" required/>
                            </div>

                    <div class="mb-3 col-md-4">
    <label class="form-label" for="ecommerce-product-name">Country<span class="required">*</span></label>
    <select id="category-select" class="form-control select2 form-select" name="countryid" required>
        <option value="">Select Country</option>
        @foreach($country_data as $country)
            <option value="{{ $country->id }}" 
                @if($result->countryid == $country->id) selected @endif>
                {{ $country->name }}
            </option>
        @endforeach
    </select>
</div>

<!-- State -->
<div class="mb-3 col-md-4">
    <label class="form-label" for="ecommerce-product-name">State<span class="required">*</span></label>
    <select id="State-select" name="stateid" class="select2 form-select" required>
        <option value="">Select State</option>
        @if($selectedState)
            <!-- Populate the states for the selected country -->
            @foreach($states as $state)
                <option value="{{ $state->id }}" 
                    @if($selectedState == $state->id) selected @endif>
                    {{ $state->name }}
                </option>
            @endforeach
        @endif
    </select>
</div>

<!-- City -->
<div class="mb-3 col-md-4">
    <label class="form-label" for="ecommerce-product-name">City<span class="required">*</span></label>
    <select id="city-select" name="cityid" class="form-control select2 form-select" required>
        <option value="">Select City</option>
        @if($selectedCity)
            <!-- Populate the cities for the selected state -->
            @foreach($cities as $city)
                <option value="{{ $city->id }}" 
                    @if($selectedCity == $city->id) selected @endif>
                    {{ $city->name }}
                </option>
            @endforeach
        @endif
    </select>
</div>

                            <!-- Image -->


                             <div class="mb-3 col-md-4">
                              <label class="form-label" for="ecommerce-product-name">Address<span class="required">*</span></label>
                              <textarea type="text"
                                class="form-control"
                                id="ecommerce-product-name"
                                placeholder="Shop Name"
                                name="address"
                                value="{{$result->address}}"
                                aria-label="shop name}" required/>{{$result->address}}</textarea>
                              
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label image_lable" for="ecommerce-category-image">{{__('lang.admin_image')}} <span class=""></span></label>
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                            <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="image">
                                            <label for="imageUpload"><i class="ti ti-pencil me-1 pencil_for_img_upload"></i></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview" style='background-image: url("{{asset('/uploads/sellers/'.$result->image)}}");'>
                                            </div>
                                        </div>
                                </div>
                            </div>
                          </div>
                      </div>
                    </div>
                  

                    <!-- Account Info -->
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-title mb-0">{{__('lang.admin_account_information')}}</h5>
                      </div>
                      <div class="card-body row">

                        <!-- phone -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label" for="ecommerce-product-name">{{__('lang.admin_phone')}} <span class="required">*</span></label>
                            <input type="tel" class="form-control" name="phone" placeholder="{{__('lang.admin_phone')}}" required value="{{$result->phone}}" maxlength="10">
                        </div>

                        <!-- password -->
                        <div class="mb-3 col-md-4">
                            <label for="password" class="form-label">{{__('lang.admin_password')}} </label>
                            <input
                              class="form-control"
                              type="text"
                              id="password"
                              name="password"
                              
                              placeholder="{{__('lang.admin_password')}}"
                              value="">
                            
                          </div>
                         
                        <!--confirm password -->
                        <div class="mb-3 col-md-4">
                            <label for="password" class="form-label">{{__('lang.admin_confirm_password')}}</label>
                            <input
                              class="form-control"
                              type="text"
                              id="confirm_password"
                              name="confirm_password"
                              
                              placeholder="{{__('lang.admin_confirm_password')}}">
                        
                          </div>
                      </div>
                    </div>
                    <!-- /Account Info -->
  
                  </div>
                  <!-- /First column -->
                </div>
        <!-- end product add -->

    </form>
       

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>


<script type="text/javascript">
  
$(document).ready(function() {
    // Initialize select2 plugin
    $('#category-select').select2({
        placeholder: 'Select Country',
        allowClear: true
    });

    $('#State-select').select2({
        placeholder: 'Select State',
        allowClear: true
    });

    $('#city-select').select2({
        placeholder: 'Select City',
        allowClear: true
    });

    // Pre-select state and city if already selected
    var selectedState = "{{ $selectedState }}";
    var selectedCity = "{{ $selectedCity }}";

    if (selectedState) {
        // Load cities based on the selected state
        $.ajax({
            url: "{{ url('admin/get-cities') }}", // Route to get cities
            type: 'POST',
            data: {
                state_id: selectedState,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    var cities = response.cities;
                    $('#city-select').empty();
                    $('#city-select').append('<option value="">Select City</option>');

                    $.each(cities, function(key, city) {
                        $('#city-select').append('<option value="'+city.id+'" '+(selectedCity == city.id ? 'selected' : '')+'>'+city.name+'</option>');
                    });
                }
            }
        });
    }

    // Trigger when country is selected
    $('#category-select').on('change', function() {
        var categoryId = $(this).val(); // Get the selected category ID

        if (categoryId) {
            $.ajax({
                url: "{{ url('admin/country-change') }}", // Route to handle the AJAX request
                type: 'POST',
                data: {
                    category_id: categoryId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        var statename = response.statename;

                        // Clear and populate the state select box
                        $('#State-select').empty();
                        $('#State-select').append('<option value="">Select State</option>');

                        // Append states dynamically
                        $.each(statename, function(key, state) {
                            $('#State-select').append('<option value="'+state.id+'">'+state.name+'</option>');
                        });

                        // If a state was pre-selected, set it
                        if (selectedState) {
                            $('#State-select').val(selectedState).trigger('change');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#State-select').empty().append('<option value="">Select State</option>');
        }
    });

    // Trigger when state is selected to load cities
    $('#State-select').on('change', function() {
        var stateId = $(this).val(); // Get the selected state ID

        if (stateId) {
            $.ajax({
                url: "{{ url('admin/state-change') }}", // Route to handle the city request
                type: 'POST',
                data: {
                    state_id: stateId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        var cities = response.cities;
                        $('#city-select').empty();
                        $('#city-select').append('<option value="">Select City</option>');

                        $.each(cities, function(key, city) {
                            $('#city-select').append('<option value="'+city.id+'" '+(selectedCity == city.id ? 'selected' : '')+'>'+city.name+'</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#city-select').empty().append('<option value="">Select City</option>');
        }
    });
});

</script>

@endsection
