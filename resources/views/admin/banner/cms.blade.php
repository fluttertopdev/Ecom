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
                CMS</h4>
            </div>
       

            <div class="col-md-6 ">
                <div class="table-btn-css">
     <a href="{{url('admin/add-cms')}}"><button type="button" class="btn btn-primary waves-effect waves-light">
                        <span class="ti-xs ti ti-plus me-1"></span>Add New
                    </button></a>
                </div>
            </div>
        
        </div>

      <div class="card">



<div class="card-body">
    <div class="table-responsive text-nowrap">
        <table class="table" >
            <thead class="table-light">
                <tr class="text-nowrap">
                    <th>{{__('lang.admin_id')}}</th>
                  
                    <th> Title</th>
                  
                 
               
                    <th>{{__('lang.admin_status')}}</th>
                
                    <th> User Type</th>
                    <th>{{__('lang.admin_action')}}</th>
            
                </tr>
            </thead>
            <tbody id="coustomsection_table">
                @if(count($result) > 0)
                @foreach($result as $row)
                <tr class="row1" data-id="{{ $row->id }}">
                    <td>{{$row->id}}</td>
                  
                    <td>{{$row->title}}</td>
                   
                    
                  
                  
             
                    <td>
                        @if($row->status == 1)
                        <a href="{{ url('admin/update-cms-column/'.$row->id) }}">
                            <span class="badge bg-success">{{__('lang.admin_active')}}</span></a>
                        @else
                        <a href="{{ url('admin/update-cms-column/'.$row->id) }}">
                            <span class="badge bg-warning">{{__('lang.admin_deactive')}}</span></a>
                        @endif
                    </td>

                    <td>
                       {{$row->type}}
                    </td>
                   
              
                    <td>
                        <div class="inline_action_btn">
                                
                             <a href="{{ url('admin/edit-cms/'.$row->slug.'/'.$row->id) }}" class="edit_icon" title="{{ __('lang.admin_edit') }}">
                      <i class="ti ti-pencil me-1"></i>
                             </a>
                               @if($row->id != 1 && $row->id != 2)
    <a class="delete_icon" href="javascript:void(0);"
       onclick="showDeleteConfirmation('cms', {{ $row->id }})">
        <i class="ti ti-trash me-1"></i>
    </a>
@endif

                              <a class="edit_icon" href="{{ url('admin/cms/translation/'.$row->id) }}"
                          title="Translation">
                          <i class="ti ti-language me-1 margin-top-negative-4"></i>
                            </a>
                              
                            
                        </div>
                    </td>
                


                  
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

</div>

       

    </div>
    <!-- / Content -->
</div>




@endsection
