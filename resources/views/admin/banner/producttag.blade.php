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
                Home Page </h4>
            </div>
       

            <div class="col-md-6 ">
                <div class="table-btn-css">
     <a href="{{url('admin/create-coustom-section')}}"><button type="button" class="btn btn-primary waves-effect waves-light">
                        <span class="ti-xs ti ti-plus me-1"></span>Add New
                    </button></a>
                </div>
            </div>
        
        </div>

      <div class="card">

<div class="offcanvas offcanvas-end" id="add-new-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title"
            id="exampleModalLabel">Add Tags</h5>
        <button type="button" class="btn-close text-reset"
            data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form action="{{url('admin/save-banner')}}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="col-sm-12">
                <label class="form-label" for="name">Name<span class="required">*</span></label>
                <div class="input-group input-group-merge">
                    <input type="text" id="basicFullname"
                        class="form-control dt-full-name" name="name"
                        placeholder="Name"
                        aria-label="John Doe"
                        aria-describedby="basicFullname2" required />
                        <input type="hidden" value="product_tag" name="type">
                </div>
            </div>
          
            <div class="col-sm-12 mt-2">
                <button type="submit"
                    class="btn btn-primary data-submit me-sm-3 me-1">{{__('lang.admin_save_changes')}}</button>
                <button type="reset" class="btn btn-outline-secondary"
                    data-bs-dismiss="offcanvas">{{__('lang.admin_cancel')}}</button>
            </div>
        </form>
    </div>
</div>

<div class="card-body">
    <div class="table-responsive text-nowrap">
        <table class="table" >
            <thead class="table-light">
                <tr class="text-nowrap">
                    <th>{{__('lang.admin_id')}}</th>
                  
                    <th>Title</th>
                  
                   <th>Type</th>
               
                    <th>{{__('lang.admin_status')}}</th>
                
               
                    <th>{{__('lang.admin_action')}}</th>
            
                </tr>
            </thead>
            <tbody id="coustomsection_table">
                @if(count($result) > 0)
                @foreach($result as $row)
                <tr class="row1" data-id="{{ $row->id }}">
                    <td>{{$row->id}}</td>
                  
                    <td>{{$row->title}}</td>
                     <td>{{$row->section_type}}</td>
                    
                  
                  
             
                    <td>
                        @if($row->status == 1)
                        <a href="{{ url('admin/update-coustom-column/'.$row->id) }}">
                            <span class="badge bg-success">{{__('lang.admin_active')}}</span></a>
                        @else
                        <a href="{{ url('admin/update-coustom-column/'.$row->id) }}">
                            <span class="badge bg-warning">{{__('lang.admin_deactive')}}</span></a>
                        @endif
                    </td>
                   
              
                    <td>
                        <div class="inline_action_btn">
                                
                                <a href="{{url('admin/edit-coustom-section/'.$row->id) }}"class="edit_icon" href="javascript:void(0);"
                                   
                                   
                                 
                                    title="{{__('lang.admin_edit')}}"><i
                                        class="ti ti-pencil me-1"></i></a>


                                          <a class="delete_icon" href="javascript:void(0);"
                                onclick="showDeleteConfirmation('coustomsection' , {{ $row->id }})"
                                ><i class="ti ti-trash me-1"></i>
                            </a>
                                 <a class="edit_icon" href="{{ url('admin/coustom-section/translation/'.$row->id) }}"
                          title="Translation">
                          <i class="ti ti-language me-1 margin-top-negative-4"></i>
                            </a>
                            
                        </div>
                    </td>
                

                    <!-- Modal to edit new record -->
                    <div class="offcanvas offcanvas-end" id="edit-new-record_{{$row->id}}">
                        <div class="offcanvas-header border-bottom">
                            <h5 class="offcanvas-title"
                                id="exampleModalLabel">Edit Tags</h5>
                            <button type="button" class="btn-close text-reset"
                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body flex-grow-1">
                            <form action="{{url('admin/update-banner')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$row->id}}">
                                <div class="col-sm-12">
                                    <label class="form-label"
                                        for="name">Name<span class="required">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="basicFullname"
                                            class="form-control dt-full-name" name="name"
                                            value="{{$row->name}}"
                                            placeholder="Name"
                                            aria-label="John Doe"
                                            aria-describedby="basicFullname2" required />
                                    </div>
                                      <input type="hidden" value="product_tag" name="type">
                                </div>
                               
                                <div class="col-sm-12 mt-2" >
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tableBody = document.getElementById("coustomsection_table");

    // Initialize SortableJS for the table body
    const sortable = new Sortable(tableBody, {
        animation: 150, // Smooth animation
        handle: ".row1", // Make the whole row draggable
        ghostClass: "sortable-ghost", // Class for the dragged element
        onEnd: function (evt) {
            saveNewOrder();
        }
    });

    // Function to save the new order via AJAX
    function saveNewOrder() {
        const rows = tableBody.querySelectorAll("tr");
        const orderData = Array.from(rows).map((row, index) => ({
            id: row.dataset.id,
            position: index + 1
        }));

        // AJAX request to save the order
        fetch("{{ url('admin/coustom-section-sortable') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ order: orderData })
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status) {
                    console.log("Order updated successfully!");
                } else {
                    console.error("Failed to update order:", data.message);
                }
            })
            .catch((error) => {
                console.error("Error saving order:", error);
            });
    }
});
</script>

@endsection
