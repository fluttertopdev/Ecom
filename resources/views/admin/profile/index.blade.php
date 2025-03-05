@extends('admin.layouts.app')
@section('content')

        <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              

              <div class="row">
                <div class="col-md-12">
               
                  <div class="card mb-4">
                    <h5 class="card-header">{{__('lang.admin_profile_details')}}</h5>
                    <!-- Account -->
                    <div class="card-body">
                      <form id="" method="POST" action="{{url('admin/update-profile')}}" enctype="multipart/form-data">
                        @csrf
                      <input type="hidden" name="id" value="{{$row->id}}">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img
                          src="{{ url('uploads/user/'.$row->image)}}"
                          alt="user-avatar"
                          class="d-block w-px-100 h-px-100 rounded"
                          id="uploadedAvatar" onerror="this.onerror=null;this.src=`{{ asset('uploads/no-admin.png') }}`"/>
                        <div class="button-wrapper">
                          <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                            <span class="d-none d-sm-block">{{__('lang.admin_upload_new_photo')}}</span>
                            <i class="ti ti-upload d-block d-sm-none"></i>
                            <input name="image"
                              type="file"
                              id="upload"
                              class="account-file-input d-none"
                              accept="image/png, image/jpeg"/>
                          </label>
                       

                        </div>
                      </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                     
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">{{__('lang.admin_name')}}</label>
                            <input
                              class="form-control"
                              type="text"
                              id="name"
                              name="name"
                              value="{{$row->name}}"
                              autofocus required/>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">{{__('lang.admin_email')}}</label>
                            <input
                              class="form-control"
                              type="text"
                              id="email"
                              name="email"
                              value="{{$row->email}}"
                              placeholder="john.doe@example.com" required/>
                          </div>

                          
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="phoneNumber">{{__('lang.admin_phone')}}</label>
                            <div class="input-group input-group-merge">
                              
                              <input
                                type="text"
                                id="phoneNumber"
                                name="phone"
                                class="form-control"
                                placeholder="202 555 0111" value="{{$row->phone}}" required/>
                            </div>
                          </div>


                          <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">{{__('lang.admin_password')}}</label>
                            <input
                              class="form-control"
                              type="text"
                              id="password"
                              name="password"
                               placeholder="{{__('lang.admin_password')}}">
                              
                          </div>

                        </div>
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2">{{__('lang.admin_save_changes')}}</button>
                          <button type="button" class="btn btn-label-secondary"><a href="{{url('admin/dashboard')}}">{{__('lang.admin_cancel')}}</a></button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
    
                </div>
              </div>
            </div>
            <!-- / Content -->

          </div>
        <!-- Content wrapper -->
@endsection
   