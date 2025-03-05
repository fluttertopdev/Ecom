



<?php
use App\Models\Subcategory;
$Subcategory = Subcategory::where('deleted_at', null)->get();


?>
<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>Shipping List</h5>
        </div>
        <div class="col-md-6">
            <h6 class="float-right">
                <?php if ($result->firstItem() != null) {?>
                {{__('lang.admin_showing')}} {{ $result->firstItem() }}-{{ $result->lastItem() }}
                {{__('lang.admin_of')}} {{ $result->total() }} <?php }?>
            </h6>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-light">
                <tr class="text-nowrap">
                    <th>{{__('lang.admin_id')}}</th>
                    <th>Country Name</th>
                    <th>State Name</th>
                    <th>City Name</th>
                    <th>Post Code</th>
                    <th>Amount</th>
                    
                    <th>Created at</th>
                    <th>{{__('lang.admin_status')}}</th>
                
                
                    <th>{{__('lang.admin_action')}}</th>
                
                </tr>
            </thead>
            <tbody>
                @if(count($result) > 0)
                @foreach($result as $row)
                <tr>
                    <td>{{$row->id}}</td>
                    <td>{{$row->Country->name}}</td>
                    <td>{{$row->State->name}}</td>
                    <td>{{$row->City->name}}</td>
                    <td>{{$row->post_code}}</td>
                    <td>{{$row->amount}}</td>
                    <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                    @can('update-subcategory-column')
                    <td>
                        @if($row->status == 1)
                        <a href="{{ url('admin/update-shipping-column/'.$row->id) }}">
                            <span class="badge bg-success">{{__('lang.admin_active')}}</span></a>
                        @else
                        <a href="{{ url('admin/update-shipping-column/'.$row->id) }}">
                            <span class="badge bg-warning">{{__('lang.admin_deactive')}}</span></a>
                        @endif
                    </td>
                    @endcan
                    @canany(['update-subcategory', 'delete-subcategory'])
                    <td>
                        <div class="inline_action_btn">
                            @can('update-subcategory')
                            <a class="edit_icon" href="javascript:void(0);"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#edit-new-record_{{$row->id}}"
                                aria-controls="edit-new-record_{{$row->id}}"
                                title="{{__('lang.admin_edit')}}"><i
                                    class="ti ti-pencil me-1"></i>
                            </a>
                            @endcan
                            @can('delete-subcategory')
                            <a class="delete_icon" href="javascript:void(0);"
                                onclick="showDeleteConfirmation('shipping' , {{ $row->id }})"
                                ><i class="ti ti-trash me-1"></i>
                            </a>
                            @endcan
                        </div>
                    </td>
                    @endcanany
                    <!-- Modal to edit new record -->
                    <div class="offcanvas offcanvas-end" id="edit-new-record_{{$row->id}}">
                        <div class="offcanvas-header border-bottom">
                            <h5 class="offcanvas-title"
                                id="exampleModalLabel">Edit Shipping </h5>
                            <button type="button" class="btn-close text-reset"
                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body flex-grow-1">
                          <form action="{{ url('admin/shipping-update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $row->id }}">

    <!-- Country Selection -->
    <div class="col-sm-12">
        <label class="form-label" for="country">Country Name <span class="required">*</span></label>
        <select class="form-control select2 form-select" name="country_id" id="category-selects" required>
            @foreach($country_data as $country)
                <option value="{{ $country->id }}" {{ $country->id == $row->country_id ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- State Selection -->
    <div class="col-sm-12 mt-3">
        <label class="form-label" for="state">State Name<span class="required">*</span></label>
        <select id="State-selects" name="state_id" class="select2 form-select" required>
            <option value="">Select State</option>
            @foreach($state_data as $state)
                <option value="{{ $state->id }}" {{ $state->id == $row->state_id ? 'selected' : '' }} data-country="{{ $state->country_id }}">
                    {{ $state->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- City Selection -->
    <div class="col-sm-12 mt-3">
        <label class="form-label" for="city">City Name<span class="required">*</span></label>
        <select id="city-selects" name="city_id" class="select2 form-select" required>
            <option value="">Select City</option>
            @foreach($city_data as $city)
                <option value="{{ $city->id }}" {{ $city->id == $row->city_id ? 'selected' : '' }} data-state="{{ $city->state_id }}">
                    {{ $city->name }}
                </option>
            @endforeach
        </select>
    </div>


   <div class="col-sm-12 mt-3 " id="">
    <label class="form-label" for="city_name">Post Code<span class="required">*</span></label>
    <div class="input-group input-group-merge">
        <input type="text" id="basicCityName"  name="post_code"value="{{$row->post_code}}" class="form-control dt-full-name"  placeholder="Post Code" aria-label="Post code" aria-describedby="basicCityName">
    </div>
</div>



   <div class="col-sm-12 mt-3 " id="">
    <label class="form-label" for="city_name">Amount<span class="required">*</span></label>
    <div class="input-group input-group-merge">
        <input type="text" id="basicCityName"  name="amount"value="{{$row->amount}}" class="form-control dt-full-name"  placeholder="amount" aria-label="Post code" aria-describedby="basicCityName">
    </div>
</div>
    <div class="col-sm-12 mt-3">
        <button type="submit" class="btn btn-primary">{{ __('lang.admin_save_changes') }}</button>
        <button type="reset" class="btn btn-outline-secondary">{{ __('lang.admin_cancel') }}</button>
    </div>
</form>         </div>
                    </div>
                    <!--/ Modal to add new record -->
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="7" class="record-not-found">
                        <span>{{__('lang.admin_no_data_found')}}</span>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer">
    <div class="pagination" style="float: right;">
        {{$result->withQueryString()->links('pagination::bootstrap-4')}}
    </div>
</div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>






<script type="text/javascript">
    $(document).ready(function() {
        // Trigger when a country is selected
        $('#category-selects').on('change', function() {
            var categoryId = $(this).val(); // Get the selected country ID
            console.log("Country ID selected:", categoryId);
            
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
                            
                            // Clear and populate the State select box
                            $('#State-selects').empty();
                            $('#State-selects').append('<option value="">Select State</option>');
                            
                            $.each(statename, function(key, state) {
                                $('#State-selects').append('<option value="'+state.id+'">'+state.name+'</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                // Clear State select box if no country is selected
                $('#State-selects').empty();
                $('#State-selects').append('<option value="">Select State</option>');
            }
        });

        // Trigger when a state is selected to load cities
        $('#State-selects').on('change', function() {
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
                            $('#city-selects').empty();
                            $('#city-selects').append('<option value="">Select City</option>');

                            $.each(cities, function(key, city) {
                                $('#city-selects').append('<option value="'+city.id+'">'+city.name+'</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                $('#city-selects').empty();
                $('#city-selects').append('<option value="">Select City</option>');
            }
        });
    });
</script>