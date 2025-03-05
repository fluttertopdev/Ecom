
<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>Sellers List</h5>
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
                    <th>ID</th>
                    <th>Name</th>
                    <th>image</th>
                    <th>Email</th>
                    <th>Shop Name</th>
                     <th>Commison</th>
                    <th>{{__('lang.admin_created_at')}}</th>
               
                    <th>{{__('lang.admin_status')}}</th>
                
                 
                    <th>{{__('lang.admin_action')}}</th>
                
                </tr>
            </thead>
            <tbody>
                @if(count($result) > 0)
                @foreach($result as $row)
                <tr>
                    <td>{{$row->id}}</td>
                    <td>
                        <div class="d-flex flex-column">
                                <p class="mb-0 fw-medium">
                               {{ \Helpers::checkNull($row->name) }}
                                </p>
                                <small class="text-muted text-nowrap">{{ $row->phone }}
                                </small>
                        </div>
                    </td>
                    <td> 
                        <img src="{{ url('uploads/sellers/'.$row->image)}}" class="table_img"
                            onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                    </td>
                  
                    <td>{{$row->email}}</td>

                      <td>{{$row->shopname}}</td>

                        <td>
                        @if($row->commison_status == 1)
                        <a href="#">
                            <span class="badge bg-success" data-id="{{$row->id}}"  data-status="{{$row->commison_status}}" data-commsionsrate="{{$row->commison}}" id="addcommisonbutton">{{__('lang.admin_active')}}</span></a>
                        @else
                        <a href="#">
                            <span class="badge bg-warning" data-id="{{$row->id}}" data-status="{{$row->commison_status}}" data-commsionsrate="{{$row->commison}}" id="addcommisonbutton">{{__('lang.admin_deactive')}}</span></a>
                        @endif
                    </td>
                    <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                 
                    <td>
                        @if($row->status == 1)
                        <a href="{{ url('admin/update-sellers-column/'.$row->id) }}">
                            <span class="badge bg-success">{{__('lang.admin_active')}}</span></a>
                        @else
                        <a href="{{ url('admin/update-sellers-column/'.$row->id) }}">
                            <span class="badge bg-warning">{{__('lang.admin_deactive')}}</span></a>
                        @endif
                    </td>
               
                
                    <td>
                        <div class="inline_action_btn">
                           
                         <a class="edit_icon" href="{{ url('admin/seller-view') }}?seller_id={{ $row->id }}" title="{{ __('lang.admin_view') }}">
                      <i class="ti ti-eye me-1"></i>
                          </a>
                          
                         
                            <a class="edit_icon" href="{{url('admin/edit-sellers/'.$row->id)}}" title="{{__('lang.admin_edit')}}"><i class="ti ti-pencil me-1"></i>
                            </a>
                        
                            <a class="delete_icon" title="{{__('lang.admin_delete')}}" href="javascript:void(0);" onclick="showDeleteConfirmation('sellers' , {{ $row->id }})">
                                <i class="ti ti-trash me-1"></i>
                            </a>
                        
                        </div>
                    </td>
                
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="10" class="record-not-found">
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







  <div class="modal fade" id="commsionModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
                  <div class="modal-content">
                    <div class="modal-body">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="text-center mb-6">
                        <h4 class="mb-2">Seller Commission</h4>
                      
                      </div>
                       <form action="{{ url('admin/update-commison') }}" method="POST">
                        @csrf
                       <input type="hidden" id="seller_id_input" value="" name="sellerid">
                      

                        <div class="col-12">
    <div class="form-check form-switch">
        <input type="hidden" name="commison_status" value="0" />
        <input type="checkbox" class="form-check-input" name="commison_status" value="1" id="commissionCheckbox" />
        <label for="commissionCheckbox" class="switch-label">Seller Commission Activation</label>
    </div>
</div>
                        <div class="col-12 mt-4">
                          <label class="form-label w-100" for="modalAddCard">Fixed Commission Rate %
</label>
                          <div class="input-group input-group-merge">
                            <input
                              id="commsionsrate"
                              name="commison"
                              class="form-control credit-card-mask"
                              type="number"
                              placeholder="Commission Rate %
 "
                              aria-describedby="modalAddCard2" />
                           
                          </div>
                        </div>
                       
                        
                     
                        
                        <div class="col-12 text-center  mt-4">
                          <button type="submit" class="btn btn-primary me-3">Update</button>
                          <button
                            type="reset"
                            class="btn btn-label-secondary btn-reset"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                            Cancel
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>









<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>






<script type="text/javascript">
    $(document).on('click', '#addcommisonbutton', function(){
        var sellersid = $(this).data('id');
        var commsionstatus = $(this).data('status');
        var commsionsrate = $(this).data('commsionsrate');

        $('#commsionModal').modal('show'); 
        $('#seller_id_input').val(sellersid);
        $('#commsionsrate').val(commsionsrate);
        
        if (commsionstatus == 1) {
            $('#commissionCheckbox').prop('checked', true);
        } else {
            $('#commissionCheckbox').prop('checked', false);
        }
    });

    // Form submission validation
    $('form').on('submit', function(event) {
        // Clear previous error messages
        $('.error-message').remove();

        // Get input values
        var commissionRate = $('input[name="commison"]').val();
        var isValid = true;

        // Check if the commission rate is filled
        if (!commissionRate || commissionRate === "") {
            isValid = false;
            // Display error message below the input field section
            $('input[name="commison"]').closest('.input-group').after('<div class="error-message" style="color:red; margin-top: 5px;">Please enter a valid commission rate.</div>');
        }

        // Prevent form submission if validation fails
        if (!isValid) {
            event.preventDefault();
        }
    });
</script>