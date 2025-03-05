



<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>Custom Notification</h5>
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
                    <th>{{__('lang.admin_image')}}</th>
                    <th>Title</th>
                     <th>Content</th>
                    <th>{{__('lang.admin_created_at')}}</th>
                   
                     <th>Send To</th>
                       <th>Link</th>
                   
                    <th>{{__('lang.admin_action')}}</th>
                    
                </tr>
            </thead>
            <tbody>
                @if(count($result) > 0)
                @foreach($result as $row)
                <tr>
                    <td>{{$row->id}}</td>
                    <td>
                        <img src="{{ url($row->image)}}" class="table_img"
                            onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                    </td>
                    <td>{{$row->title}}</td>
                     <td>{{$row->content}}</td>
                    <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                    <td>
                       
                        <a href="#">
                            <span data-id="{{$row->id}}" id="" class="badge bg-success checkuser">Check Name</span></a>
                        
                       
                        
                    </td>
                       <td>{{$row->link}}</td>
                   
                 
                    <td>
                        <div class="inline_action_btn">
                           
                              


                                          <a class="delete_icon" href="javascript:void(0);"
                                onclick="showDeleteConfirmation('coustonnotifications' , {{ $row->id }})"
                                ><i class="ti ti-trash me-1"></i>
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
<div class="card-footer">
    <div class="pagination" style="float: right;">
        {{$result->withQueryString()->links('pagination::bootstrap-4')}}
    </div>
</div>
</div>





 


<!-- this modal for add state  -->

 <div class="modal fade stateaddbutton" id="usercheckModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        <form action="" method="POST">
          @csrf
          <table id="exampleTable" class="table table-bordered exampleTable">
         
            <thead>
              <tr>
                <th>Sr No.</th>
                  <th>Name</th>
                <th>Email</th>
            
              </tr>
            </thead>
            <tbody>
             
                <tr>
                  <td>1</td>
                   <td>Arun Rajput</td>
                  <td>Arun@gmail.com</td>
                 
                </tr>
    
            </tbody>
          </table>
          
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    $('.exampleTable').DataTable();
  });
</script>

              <script type="text/javascript">
    
    $(document).on('click', '.checkuser', function(){
         
        $('#usercheckModal').modal('show'); 


    });



    
</script>




 




