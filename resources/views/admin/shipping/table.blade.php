



<?php
use App\Models\Subcategory;
$Subcategory = Subcategory::where('deleted_at', null)->get();


?>
<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>Location List</h5>
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
                   
                    <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                 
                    <td>
                        @if($row->status == 1)
                        <a href="{{ url('admin/update-location-column/'.$row->id) }}">
                            <span class="badge bg-success">{{__('lang.admin_active')}}</span></a>
                        @else
                        <a href="{{ url('admin/update-location-column/'.$row->id) }}">
                            <span class="badge bg-warning">{{__('lang.admin_deactive')}}</span></a>
                        @endif
                    </td>
                   
                    
                    <td>
                        <div class="inline_action_btn">
                          
                            <a class="edit_icon" href="{{ url('admin/edit-location/'.$row->id) }}"
                           
                   
                                title="{{__('lang.admin_edit')}}"><i
                                    class="ti ti-pencil me-1"></i>
                            </a>
                       
                            <a class="delete_icon" href="javascript:void(0);"
                                onclick="showDeleteConfirmation('shipping' , {{ $row->id }})"
                                ><i class="ti ti-trash me-1"></i>
                            </a>
                         
                        </div>
                    </td>
               
                    <!-- Modal to edit new record -->
               
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