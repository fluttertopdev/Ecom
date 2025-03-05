@extends('admin.layouts.app')
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-6">
                <h4 class="py-3 mb-4">
                  <span class="text-muted fw-light">
                    <a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> /
                  </span>
                  Shipping List</h4>
            </div>
            @can('add-subcategory')
            <div class="col-md-6">
                <div class="table-btn-css">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="offcanvas"
                        data-bs-target="#add-new-record" aria-controls="add-new-record">
                        <span class="ti-xs ti ti-plus me-1"></span>Add New
                    </button>
                </div>
            </div>
            @endcan
        </div>


        <div class="card margin-bottom-20">
            <div class="card-header">
                <form method="get">
                    <div class="row">
                        <h5 class="card-title display-inline-block">{{__('lang.admin_filters')}}</h5>
                        <!-- <div class="form-group col-sm-3 display-inline-block">
                            <input type="text" class="form-control dt-full-name" placeholder="{{__('lang.admin_search_name')}}" name="name" value="@if(isset($_GET['name']) && $_GET['name']!=''){{$_GET['name']}}@endif">
                        </div> -->
    <div class="col-sm-3 display-inline-block">
    <select class="form-control select2 form-select category-select" name="country_id">
        <option value="">Select Country</option>
        @if(count($country_data))
            @foreach($country_data as $country)
                <option value="{{ $country->id }}" @if(request()->get('country_id') == $country->id) selected @endif>{{ $country->name }}</option>
            @endforeach
        @endif
    </select>
</div>


     
<div class="col-sm-3 display-inline-block">
    <select class="form-control select2 form-select State-select" name="state_id">
        <option value="">Select State</option>
        @if(isset($state_data) && count($state_data))
            @foreach($state_data as $state)
                <option value="{{ $state->id }}" @if(request()->get('state_id') == $state->id) selected @endif>{{ $state->name }}</option>
            @endforeach
        @endif
    </select>
</div>


   
<div class="col-sm-3 display-inline-block">
    <select class="form-control select2 form-select city-select" name="city_id">
        <option value="">Select City</option>
        @if(isset($city_data) && count($city_data))
            @foreach($city_data as $city)
                <option value="{{ $city->id }}" @if(request()->get('city_id') == $city->id) selected @endif>{{ $city->name }}</option>
            @endforeach
        @endif
    </select>
</div>
                     
    <div class="col-sm-3 display-inline-block">
    <select class="form-control select2 form-select post-code-select" name="post_code">
        <option value="">Select Post Code</option>
        @if(isset($postcode_data) && count($postcode_data))
            @foreach($postcode_data as $postCode)
                <option value="{{ $postCode->post_code }}" @if(request()->get('post_code') == $postCode->post_code) selected @endif>{{ $postCode->post_code }}</option>
            @endforeach
        @endif
    </select>
</div>


   <div class="col-sm-3 display-inline-block mt-4">
                            <select class="form-control select2 form-select" name="status">
                                <option value="">{{__('lang.admin_select_status')}}</option>
                                    @if(count($statusTypes))
                                    @foreach($statusTypes as $value => $label)
                                        <option value="{{$value}}" @if(isset($_GET['status']) && $_GET['status']!='') @if($_GET['status']==$value) selected @endif @endif>{{$label}}</option>
                                    @endforeach
                                    @endif
                            </select>
                        </div>

                        <div class="col-sm-3 display-inline-block mt-4">
                            <button type="submit" class="btn btn-primary data-submit">{{__('lang.admin_search')}}</button>
                            <a type="reset" class="btn btn-outline-secondary" href="{{url('admin/shipping')}}">{{__('lang.admin_reset')}}</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <!-- Bordered Table -->
        @include('admin/shipping/table')
        <!--/ Bordered Table -->

        <!-- Modal to add new record -->
        @include('admin/shipping/add_modal')
        <!--/ Modal to add new record -->

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

@endsection


<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script type="text/javascript">
$(document).ready(function() {
    // Initialize select2 plugin
    $('.category-select, .State-select, .city-select, .post-code-select').select2({
        placeholder: 'Select',
        allowClear: true
    });

    // Trigger when country is selected
    $('.category-select').on('change', function() {
        var countryId = $(this).val();
        var selectedStateId = '{{ request()->get('state_id') }}';
        var selectedCityId = '{{ request()->get('city_id') }}';
        var selectedPostCode = '{{ request()->get('post_code') }}';

        if (countryId) {
            $.ajax({
                url: "{{ url('admin/country-change-filters') }}",
                type: 'POST',
                data: {
                    country_id: countryId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        var states = response.statename;
                        $('.State-select').empty().append('<option value="">Select State</option>');

                        $.each(states, function(key, state) {
                            var selected = (state.id == selectedStateId) ? 'selected' : '';
                            $('.State-select').append('<option value="'+state.id+'" '+selected+'>'+state.name+'</option>');
                        });

                        // Trigger the change event to load cities
                        $('.State-select').trigger('change');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('.State-select').empty().append('<option value="">Select State</option>');
            $('.city-select').empty().append('<option value="">Select City</option>');
            $('.post-code-select').empty().append('<option value="">Select Post Code</option>');
        }
    });

    // Trigger when a state is selected to load cities
    $('.State-select').on('change', function() {
        var stateId = $(this).val();
        var selectedCityId = '{{ request()->get('city_id') }}';
        var selectedPostCode = '{{ request()->get('post_code') }}';

        if (stateId) {
            $.ajax({
                url: "{{ url('admin/state-change-filters') }}",
                type: 'POST',
                data: {
                    state_id: stateId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        var cities = response.cities;
                        $('.city-select').empty().append('<option value="">Select City</option>');

                        $.each(cities, function(key, city) {
                            var selected = (city.id == selectedCityId) ? 'selected' : '';
                            $('.city-select').append('<option value="'+city.id+'" '+selected+'>'+city.name+'</option>');
                        });

                        // Trigger the change event to load post codes
                        $('.city-select').trigger('change');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('.city-select').empty().append('<option value="">Select City</option>');
            $('.post-code-select').empty().append('<option value="">Select Post Code</option>');
        }
    });

    // Trigger when a city is selected to load post codes
    $('.city-select').on('change', function() {
        var cityId = $(this).val();
        var selectedPostCode = '{{ request()->get('post_code') }}';

        if (cityId) {
            $.ajax({
                url: "{{ url('admin/postcodefilters') }}", // Route to handle the post code request
                type: 'POST',
                data: {
                    city_id: cityId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        var postCodes = response.post_codes;
                        $('.post-code-select').empty().append('<option value="">Select Post Code</option>');

                        $.each(postCodes, function(key, postCode) {
                            var selected = (postCode.post_code == selectedPostCode) ? 'selected' : '';
                            $('.post-code-select').append('<option value="'+postCode.post_code+'" '+selected+'>'+postCode.post_code+'</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('.post-code-select').empty().append('<option value="">Select Post Code</option>');
        }
    });

    // On page load, if country is already selected, trigger the change event
    var initialCountryId = '{{ request()->get('country_id') }}';
    if (initialCountryId) {
        $('.category-select').val(initialCountryId).trigger('change');
    }
});
</script>
<!-- 
<script type="text/javascript">
$(document).ready(function() {
    // Initialize select2 plugin
    $('.category-select').select2({
        placeholder: 'Select Country',
        allowClear: true
    });

    $('.State-select').select2({
        placeholder: 'Select State',
        allowClear: true
    });

    $('.city-select').select2({
        placeholder: 'Select City',
        allowClear: true
    });

    $('.post-code-select').select2({
        placeholder: 'Select Post Code',
        allowClear: true
    });

    // Trigger when country is selected
    $('.category-select').on('change', function() {
        var countryId = $(this).val(); // Get the selected country ID
        var selectedStateId = '{{ request()->get('state_id') }}'; // Get selected state from URL

        // Check if a country is selected
        if (countryId) {
            $.ajax({
                url: "{{ url('admin/country-change-filters') }}",
                type: 'POST',
                data: {
                    country_id: countryId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        var states = response.statename;

                        // Clear and populate the state select box
                        $('.State-select').empty();
                        $('.State-select').append('<option value="">Select State</option>');

                        $.each(states, function(key, state) {
                            var selected = (state.id == selectedStateId) ? 'selected' : '';
                            $('.State-select').append('<option value="'+state.id+'" '+selected+'>'+state.name+'</option>');
                        });

                        // Trigger the change event to load cities
                        $('.State-select').trigger('change');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('.State-select').empty().append('<option value="">Select State</option>');
            $('.city-select').empty().append('<option value="">Select City</option>');
            $('.post-code-select').empty().append('<option value="">Select Post Code</option>');
        }
    });

    // Trigger when a state is selected to load cities
    $('.State-select').on('change', function() {
        var stateId = $(this).val(); // Get the selected state ID
        var selectedCityId = '{{ request()->get('city_id') }}'; // Get selected city from URL

        if (stateId) {
            $.ajax({
                url: "{{ url('admin/state-change-filters') }}",
                type: 'POST',
                data: {
                    state_id: stateId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        var cities = response.cities;
                        $('.city-select').empty();
                        $('.city-select').append('<option value="">Select City</option>');

                        $.each(cities, function(key, city) {
                            var selected = (city.id == selectedCityId) ? 'selected' : '';
                            $('.city-select').append('<option value="'+city.id+'" '+selected+'>'+city.name+'</option>');
                        });

                        // Trigger the change event to load post codes
                        $('.city-select').trigger('change');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('.city-select').empty().append('<option value="">Select City</option>');
            $('.post-code-select').empty().append('<option value="">Select Post Code</option>');
        }
    });

    // Trigger when a city is selected to load post codes
    $('.city-select').on('change', function() {
        var cityId = $(this).val(); // Get the selected city ID
        var selectedPostCodeId = '{{ request()->get('post_code') }}'; // Get selected post code from URL

        if (cityId) {
            $.ajax({
                url: "{{ url('admin/postcodefilters') }}",
                type: 'POST',
                data: {
                    city_id: cityId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        var postCodes = response.post_codes;
                        $('.post-code-select').empty();
                        $('.post-code-select').append('<option value="">Select Post Code</option>');

                        $.each(postCodes, function(key, postCode) {
                            var selected = (postCode.post_code == selectedPostCodeId) ? 'selected' : '';
                            $('.post-code-select').append('<option value="'+postCode.post_code+'" '+selected+'>'+postCode.post_code+'</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('.post-code-select').empty().append('<option value="">Select Post Code</option>');
        }
    });

    // On page load, if country is already selected, trigger the change event
    var initialCountryId = '{{ $countryId ?? "" }}';
    if (initialCountryId) {
        $('.category-select').val(initialCountryId).trigger('change');
    }

    // After form submission, set the selected values from the request
    var selectedCityId = '{{ request()->get('city_id') }}';
    var selectedPostCodeId = '{{ request()->get('post_code') }}';
    if (selectedCityId) {
        $('.city-select').val(selectedCityId).trigger('change'); // Load post codes for the selected city
    }
});
</script> -->