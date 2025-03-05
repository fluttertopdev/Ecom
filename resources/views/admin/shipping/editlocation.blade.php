@extends('admin.layouts.app')
@section('content')







          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="app-ecommerce">
                <!-- Add Product -->
                <div
                  class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                  <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1">Edit Location</h4>
               
                  </div>
                 
                </div>

                <div class="row">
              <form id="productform" action="{{url('admin/shipping-update')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="col-12 col-lg-12">
        <div class="card mb-6 mt-4">
            <div class="card-body">
                <!-- Country -->
                <div class="mb-6">
                    <label class="form-label" for="ecommerce-product-name">Country</label>
                    <select class="form-control select2 form-select validate-field" name="country_id" id="category-select" required>
                        <option value="">Select Country</option>
                        @foreach($country_data as $country)
                            <option value="{{ $country->id }}" {{ $country->id == $result->country_id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <input type="hidden" name="id" value="{{$result->id}}">
                <!-- State -->
                <div class="mb-6">
                    <label class="form-label" for="ecommerce-product-name">State</label>
                    <select id="State-select" name="state_id" class="select2 form-select validate-field" required>
                        <option value="">Select State</option>
                        @foreach($state_data as $state)
                            <option value="{{ $state->id }}" {{ $state->id == $result->state_id ? 'selected' : '' }}>
                                {{ $state->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- City -->
                <div class="mb-6">
                    <label class="form-label" for="ecommerce-product-name">City</label>
                    <select class="form-control select2 form-select validate-field" id="city-select" name="city_id" required>
                        <option value="">Select City</option>
                        @foreach($city_data as $city)
                            <option value="{{ $city->id }}" {{ $city->id == $result->city_id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Pincode -->
                <div class="mb-6">
                    <label class="form-label" for="ecommerce-product-name">Pincode</label>
                    <input class="form-control" maxlength="6" name="post_code" value="{{$result->post_code}}" required>
                </div>
                <!-- Submit Button -->
                <div class="d-flex align-content-center flex-wrap gap-4">
                    <button type="submit" class="btn btn-primary mt-4">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>

    </div>
</div>
                
                    
                  </div>
                  
                </div>
              </div>
            </div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>





<script type="text/javascript">
$(document).ready(function() {
    // Initialize select2
    $('#category-select, #State-select, #city-select').select2({
        placeholder: 'Select an option',
        allowClear: true
    });

    // Load states when a country is selected
    $('#category-select').on('change', function() {
        var countryId = $(this).val();
        if (countryId) {
            $.ajax({
                url: "{{url('admin/country-change')}}",
                type: 'POST',
                data: {
                    category_id: countryId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        var states = response.statename;
                        $('#State-select').empty().append('<option value="">Select State</option>');
                        $.each(states, function(key, state) {
                            $('#State-select').append('<option value="' + state.id + '">' + state.name + '</option>');
                        });
                        $('#State-select').trigger('change');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $('#State-select').empty().append('<option value="">Select State</option>');
            $('#city-select').empty().append('<option value="">Select City</option>');
        }
    });

    // Load cities when a state is selected
    $('#State-select').on('change', function() {
        var stateId = $(this).val();
        if (stateId) {
            $.ajax({
                url: "{{url('admin/state-change')}}",
                type: 'POST',
                data: {
                    state_id: stateId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        var cities = response.cities;
                        $('#city-select').empty().append('<option value="">Select City</option>');
                        $.each(cities, function(key, city) {
                            $('#city-select').append('<option value="' + city.id + '">' + city.name + '</option>');
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

