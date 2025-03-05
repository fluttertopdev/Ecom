<?php
$Symbol = \Helpers::getActiveCurrencySymbol();
?>


<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>Coupon List</h5>
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
                     <th>Code</th>
                     <th>Type</th>
                     <th>Start date</th>
                     <th>End Date</th>
                     <th>Value</th>
                <th>{{__('lang.admin_status')}}</th>
                    <th>{{__('lang.admin_created_at')}}</th>
              
                  
               
               
                 
                    <th>{{__('lang.admin_action')}}</th>
               
                </tr>
            </thead>
            <tbody>
                @if(count($result) > 0)
                @foreach($result as $row)
                <tr>
                    <td>{{$row->id}}</td>
                    
                    <td>{{$row->name}}</td>
                     <td>{{$row->type}}</td>
                     <td>{{$row->start_date}}</td>
                    <td>{{$row->expire_date}}</td>
                    <td>{{$Symbol}}{{$row->discount}}</td>
                        

               
                   
                
                  <td>
    @php
        $isExpired = isset($row->expire_date) && strtotime($row->expire_date) < time();
    @endphp

    @if($isExpired)
        <span class="badge bg-warning">{{ __('lang.admin_deactive') }}</span>
    @else
        @if($row->status == 1)
            <a href="{{ url('admin/update-coupon-column/'.$row->id) }}">
                <span class="badge bg-success">{{ __('lang.admin_active') }}</span>
            </a>
        @else
            <a href="{{ url('admin/update-coupon-column/'.$row->id) }}">
                <span class="badge bg-warning">{{ __('lang.admin_deactive') }}</span>
            </a>
        @endif
    @endif
</td>
               
                       <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                    <td>
                        <div class="inline_action_btn">
                           
                                <a class="edit_icon" href="javascript:void(0);"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#edit-new-record_{{$row->id}}"
                                    aria-controls="edit-new-record_{{$row->id}}"
                                    title="{{__('lang.admin_edit')}}"><i
                                        class="ti ti-pencil me-1"></i></a>


                                          <a class="delete_icon" href="javascript:void(0);"
                                onclick="showDeleteConfirmation('coupon' , {{ $row->id }})"
                                ><i class="ti ti-trash me-1"></i>
                            </a>
                        
                            
                        </div>
                    </td>
            

                    <!-- Modal to edit new record -->
                    <div class="offcanvas offcanvas-end" id="edit-new-record_{{$row->id}}">
                        <div class="offcanvas-header border-bottom">
                            <h5 class="offcanvas-title"
                                id="exampleModalLabel">Edit Coupon </h5>
                            <button type="button" class="btn-close text-reset"
                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body flex-grow-1">
                            <form action="{{url('admin/update-coupon')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$row->id}}">
                                <div class="col-sm-12">
                                    <label class="form-label"
                                        for="name"> Coupon Code<span class="required">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="basicFullname"
                                            class="form-control dt-full-name" name="name"
                                            value="{{$row->name}}"
                                            placeholder=" Coupon Code"
                                            aria-label="John Doe"
                                            aria-describedby="basicFullname2" required />
                                    </div>
                                </div>


                                <div class="col-sm-12">
                                    <label class="form-label"
                                        for="name">Start Date<span class="required">*</span></label>
                                    <div class="input-group  input-group-merge">
                                        <input type="date" id=""
                                            class="form-control dt-full-name" name="start_date"
                                            value="{{$row->start_date}}"
                                            placeholder=""
                                            aria-label="John Doe"
                                            aria-describedby="basicFullname2" required />
                                    </div>
                                </div>




                                       <div class="col-sm-12">
                                    <label class="form-label"
                                        for="name">End Date<span class="required">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="date" id=""
                                            class="form-control dt-full-name" name="expire_date"
                                            value="{{$row->expire_date}}"
                                            placeholder=""
                                            aria-label="John Doe"
                                            aria-describedby="basicFullname2" required />
                                    </div>
                                </div>
                                    

                                    <div class="col-sm-12">
    <label class="form-label" for="type">Type <span class="required">*</span></label>
    <div class="input-group input-group-merge">
        <select class="form-control" name="type" id="type" required>
            <option value="">Type</option>
            <option value="fixed" {{ isset($row->type) && $row->type == 'fixed' ? 'selected' : '' }}>Fixed</option>
            <option value="percent" {{ isset($row->type) && $row->type == 'percent' ? 'selected' : '' }}>Percent</option>
        </select>
    </div>
</div>

<div class="col-sm-12 mt-3">
    <label class="form-label" for="status">Status <span class="required">*</span></label>
    <div class="input-group input-group-merge">
        <select class="form-control" name="status" id="status" required>
            <option value="">Status</option>
            <option value="1" {{ isset($row->status) && $row->status == '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ isset($row->status) && $row->status == '0' ? 'selected' : '' }}>Deactive</option>
        </select>
    </div>
</div>

                                          <div class="col-sm-12">
                                    <label class="form-label"
                                        for="name">Value<span class="required">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="basicFullname"
                                            class="form-control dt-full-name" name="discount"
                                            value="{{$row->discount}}"
                                            placeholder=" Value"
                                            aria-label="John Doe"
                                            aria-describedby="basicFullname2" required />
                                    </div>
                                </div>





                                    


                                                              <div class="col-sm-12 mt-4">
                                    <button type="submit"
                                        class="btn btn-primary data-submit me-sm-3 me-1">{{__('lang.admin_save_changes')}}</button>
                                    <button type="reset" class="btn btn-outline-secondary"
                                        data-bs-dismiss="offcanvas">{{__('lang.admin_cancel')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--/ Modal to add new record -->
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







 




