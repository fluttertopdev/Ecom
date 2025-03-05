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
                    <h4 class="mb-1">Edit CMS</h4>
               
                  </div>
                 
                </div>

                <div class="row">
               <form id="productform"action="{{url('admin/update-cms')}}" method="POST"
            enctype="multipart/form-data">
             @csrf
                   
                  <!-- First column-->
                  <div class="col-12 col-lg-12">
                    <!-- Product Information -->
                    <div class="card mb-6 mt-4">
                      
                      <div class="card-body">
                        <div class="mb-6">
                          <label class="form-label" for="ecommerce-product-name">Title</label>
                          <input
                            type="text"
                            class="form-control"
                            id="ecommerce-product-name"
                            placeholder="Title"
                            name="title"
                             value="{{$result->title}}"
                            aria-label="" required />
                        </div>

                                           <div class="mb-6">
    <label class="form-label" for="ecommerce-product-name"> User Type</label>
    <select class="form-control" required name="type">
        <option value="" {{ $result->type == '' ? 'selected' : '' }}>Please Select</option>
        <option value="seller" {{ $result->type == 'seller' ? 'selected' : '' }}>Seller</option>
        <option value="user" {{ $result->type == 'user' ? 'selected' : '' }}>User</option>
    </select>
</div>
                  
                  <input type="hidden" value="{{$result->id}}" name="id">
               
                  
                      <div>
                          <label class="mb-1">Description</label>
                        
                             <textarea 
                              class="form-control"
                             id="shorteditor"
                              placeholder="Short Description"
                            name="des" value="{{$result->des}}"
                              >{{$result->des}}</textarea required>
                              
                          </div>


                        <div class="d-flex align-content-center flex-wrap gap-4">
  <div class="d-flex gap-4 ms-auto">
    
  </div>
  <button type="submit" class="btn btn-primary mt-4">Submit</button>
</div>



                     


                        </div>
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


@endsection

