<style type="text/css">
     .helpline-input {
        max-width: 250px; /* Adjust the width as needed */
    }
</style>



<h5 class="font-weight-bold mt-2 mb-2">Information</h5>
<div class="row">
    @foreach($loactionsettings as $row)
        @if($row->key == 'company_name')
        <div class="col-md-3">
            <label class="form-label" for="company_name">Name</label>
            <input type="text" class="form-control" placeholder="Name" name="company_name" value="{{$row->value}}"/>
        </div>
        @endif
        @if($row->key == 'email')
        <div class="col-md-3">
            <label class="form-label" for="email">Email</label>
            <input type="text" class="form-control" placeholder="Email" name="email" value="{{$row->value}}"/>
        </div>
        @endif
        @if($row->key == 'phone')
        <div class="col-md-3">
            <label class="form-label" for="phone">Phone</label>
            <input type="text" class="form-control" placeholder="Phone" name="phone" value="{{$row->value}}"/>
        </div>
        @endif
        @if($row->key == 'country')
        <div class="col-md-3">
            <label class="form-label" for="country">Country</label>
            <select id="category-select" class="form-control select2 form-select" name="country">
                <option value="">Select Country</option>
                @foreach($country_data as $country)
                    <option value="{{ $country->id }}" {{ $row->value == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
        @endif
        @if($row->key == 'state')
        <div class="col-md-3">
            <label class="form-label" for="state">State</label>
            <select id="State-select" class="form-control select2 form-select" name="state">
               <option value="">Select State</option>
               @foreach($state_data as $state)
                   <option value="{{ $state->id }}" {{ $row->value == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
               @endforeach
            </select>
        </div>
        @endif
        @if($row->key == 'city')
        <div class="col-md-3">
            <label class="form-label" for="city">City</label>
            <select id="city-select" class="form-control select2 form-select" name="city">
               <option value="">Select City</option>
               @foreach($city_data as $city)
                    <option value="{{ $city->id }}" {{ $row->value == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
               @endforeach
            </select>
        </div>
        @endif
    @endforeach
</div>

<div class="col-md-12">
    @foreach($result as $row)
        @if($row->key == 'address')
        <div class="col-md-12 mt-3">
            <label class="form-label" for="address">Full Address</label>
            <textarea class="form-control" name="address" placeholder="Full Address">{{$row->value}}</textarea>
        </div>
        @endif
    @endforeach
</div>

<div class="col-md-12">
    @foreach($result as $row)
        @if($row->key == 'description')
        <div class="col-md-12 mt-3">
            <label class="form-label" for="description">Description</label>
            <textarea class="form-control" name="description" placeholder="Description" rows="6">{{$row->value}}</textarea>
        </div>
        @endif
    @endforeach
</div>

<div class="row">
    @foreach($result as $row)
        @if($row->key == 'logo')
        <div class="col-md-6 mt-3">
            <label class="form-label">{{__('lang.admin_logo')}}</label>
            <div class="d-flex">
                <img src="{{url('uploads/setting/'.$row->value)}}" class="rounded me-50" id="site-logo-preview" alt="logo" height="80" width="80" 
                     onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`"/>
                <div class="mt-75 ms-1">
                    <label class="btn btn-primary me-75 mb-0" for="change-site-logo">
                        <span class="d-none d-sm-block">{{__('lang.admin_upload_logo')}}</span>
                        <input class="form-control" type="file" name="logo" id="change-site-logo" hidden accept="image/*" 
                               onclick="showImagePreview('change-site-logo','site-logo-preview',512,512);"/>
                    </label>
                    <p>{{__('lang.admin_upload_logo_resolution')}}</p>
                </div>
            </div>
        </div>
        @endif

        @if($row->key == 'favicon')
        <div class="col-md-6 mt-3">
            <label class="form-label">{{__('lang.admin_favicon')}}</label>
            <div class="d-flex">
                <img src="{{url('uploads/setting/'.$row->value)}}" class="rounded me-50" id="website-admin-logo-preview" alt="favicon" height="80" width="80" 
                     onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`"/>
                <div class="mt-75 ms-1">
                    <label class="btn btn-primary me-75 mb-0" for="change-website-admin-logo">
                        <span class="d-none d-sm-block">{{__('lang.admin_upload_favicon')}}</span>
                        <input class="form-control" type="file" name="favicon" id="change-website-admin-logo" hidden accept="image/*" 
                               onclick="showImagePreview('change-website-admin-logo','website-admin-logo-preview',512,512);"/>
                    </label>
                    <p>{{__('lang.admin_favicon_resolution')}}</p>
                </div>
            </div>
        </div>
        @endif
    @endforeach
</div>

<!-- Separate Loop for Help Line, Multi Language, and Footer Image -->
<div class="row">
    @foreach($result as $row)
        @if($row->key == 'helpline')
            <div class="col-md-6 mt-3">
                <label class="form-label" for="helpline">Help Line Number</label>
                <input type="text" class="form-control helpline-input" placeholder="Help Line Number" name="helpline" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 12);" 
           pattern="[0-9]{10}"  value="{{$row->value}}"/>
            </div>
        @endif
        @if($row->key == 'footerimg')
            <div class="col-md-6 mt-3">
                <label class="form-label" for="footerimg">Footer Image</label>
                <div class="d-flex">
                    <img src="{{ url('uploads/setting/'.$row->value) }}" class="rounded me-50" id="footerimg-preview" alt="Footer Image" height="50" width="50" 
                        onerror="this.onerror=null;this.src='{{ asset('uploads/no-image.png') }}'"/>
                    <div class="mt-75 ms-1">
                        <label class="btn btn-primary me-75 mb-0">
                            <span class="d-none d-sm-block">Upload Footer Image</span>
                            <input class="form-control" type="file" name="footerimg" id="footerimg-input" hidden accept="image/*">
                            <span class="d-block d-sm-none">
                                <i class="me-0" data-feather="edit"></i>
                            </span>
                        </label>
                        <p>{{ __('lang.admin_favicon_resolution') }}</p>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>

<div class="row mt-60">
    @foreach($result as $row)
        @if($row->key == 'multilanguage' || $row->key == 'shipping_discount')
            <div class="col-md-6 mt-4">
                <label class="switch switch-square d-flex" style="width: 100%;">
                    <input value="1" type="checkbox" class="switch-input" name="{{ $row->key }}" @if($row->value == 1) checked @endif>
                    <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                    </span>
                    <span class="switch-label d-inline-block ms-2">
                        @if($row->key == 'multilanguage')
                            Multi Language
                        @elseif($row->key == 'shipping_discount')
                            Do you want to allow coupon discount on shipping
                        @endif
                    </span>
                </label>
            </div>
        @endif
    @endforeach
</div>






<style>
    #map {
        height: 400px;
    }

    .controls {
        margin-top: 10px;
        margin-left: 16px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #pac-input {
        background-color: #fff;
        padding: 0 11px 0 13px;
        width: 400px;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        text-overflow: ellipsis;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    .pac-container {
        font-family: Roboto;
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }
</style>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUNZZgE72aRG8H_aW_f9K1y1SedPg3LJI&libraries=places"></script>

    <script>
        let map;
        let marker;
        let autocomplete;

    function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 0, lng: 0 },
        zoom: 2
    });

    let input = document.getElementById('pac-input');
    autocomplete = new google.maps.places.Autocomplete(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    autocomplete.bindTo('bounds', map);

    autocomplete.addListener('place_changed', function () {
        let place = autocomplete.getPlace();
        if (!place.geometry || !place.geometry.location) {
            window.alert("No details available for the entered location.");
            return;
        }

        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }

        updateLocation(place.geometry.location);
    });

    input.addEventListener('keyup', function(event) {
        if (event.key === "Enter") {
            let query = input.value;
            let geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'address': query }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK && results.length > 0) {
                    let location = results[0].geometry.location;
                    map.setCenter(location);
                    updateLocation(location);
                } else {
                    window.alert("No details available for the entered location.");
                }
            });
        }
    });

    map.addListener('click', function (event) {
        updateLocation(event.latLng);
    });
    }

    function updateLocation(latLng) {
        if (marker) {
            marker.setMap(null);
        }

        marker = new google.maps.Marker({
            position: latLng,
            map: map
        });

        document.getElementById('latitude').value = latLng.lat();
        document.getElementById('longitude').value = latLng.lng();

        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'location': latLng }, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    document.getElementById('placeName').value = results[0].formatted_address;
                    for (let i = 0; i < results[0].address_components.length; i++) {
                        let addressType = results[0].address_components[i].types[0];
                        if (addressType === 'country') {
                            document.getElementById('country').value = results[0].address_components[i].long_name;
                        } else if (addressType === 'administrative_area_level_1') {
                            document.getElementById('state').value = results[0].address_components[i].long_name;
                        } else if (addressType === 'locality') {
                            document.getElementById('city').value = results[0].address_components[i].long_name;
                        }
                    }
                }
            }
        });
    }


    document.addEventListener("DOMContentLoaded", function () {
        initMap();
    });
    </script>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>





<script type="text/javascript">
  
 $(document).ready(function() {
    // Initialize select2 plugin if needed
    $('#category-select').select2({
        placeholder: 'Select Country',
        allowClear: true
    });

  $('#State-select').select2({
            placeholder: 'Select State',
            allowClear: true
        });
    // Trigger when category is selected
    $('#category-select').on('change', function() {
        var categoryId = $(this).val(); // Get the selected category ID
         
        // Check if a category is selected
        if (categoryId) {
            $.ajax({
                url: "{{url('admin/country-change')}}", // Route to handle the AJAX request
                type: 'POST',
                data: {
                    category_id: categoryId,
                    _token: '{{ csrf_token() }}' // Laravel CSRF token
                },
                success: function(response) {
                    if (response.success) {
                        var statename = response.statename;
                        
                        // Clear and populate the subcategory select box
                        $('#State-select').empty();
                        $('#State-select').append('<option value="">Select State</option>');
                        
                        $.each(statename, function(key, state) {
                            $('#State-select').append('<option value="'+state.id+'">'+state.name+'</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            // Clear subcategory select box if no category is selected
            $('#State-select').empty();
            $('#State-select').append('<option value="">Select State</option>');
        }
    });



        // Trigger when a state is selected to load cities
        $('#State-select').on('change', function() {
            var stateId = $(this).val(); // Get the selected state ID

            if (stateId) {
                $.ajax({
                    url: "{{url('admin/state-change')}}", // Route to handle the city request
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
                                $('#city-select').append('<option value="'+city.id+'">'+city.name+'</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                $('#city-select').empty();
                $('#city-select').append('<option value="">Select City</option>');
            }
        });
});


</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const faviconInput = document.getElementById('favicon-input');
        const faviconPreview = document.getElementById('favicon-preview');

        faviconInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    faviconPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>