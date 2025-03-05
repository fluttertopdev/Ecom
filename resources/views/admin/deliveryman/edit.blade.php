@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .identity_image_upload_btn {
        color: #ffffff;
        border-color: #7367f0;
        background: #7266ee;
        border: 1px solid;
        padding: 4px 6px;
        cursor: pointer;
        border-radius: 6px;
        width: 240px;
    }

    .upload_identity_image_show{
        height: 120px;
        width: 240px;
        margin-bottom: 5px;
    }
</style>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">


    <form action="{{url('admin/update-deliveryman')}}" method="POST" enctype="multipart/form-data" id="identityForm">
        @csrf

        <div class="row">
            <div class="col-md-8">
                <h4 class="py-3 mb-4">
                  <span class="text-muted fw-light">
                    <a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> /
                  </span><span class="text-muted fw-light">
                    <a href="{{url('admin/deliveryman')}}">{{__('lang.admin_deliveryman_list')}}</a> /
                  </span>
                  {{__('lang.admin_edit_deliveryman_form')}}</h4>
            </div>
            <div class="col-md-4">
                <div class="table-btn-css">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        <span class="ti-xs ti ti-plus me-1"></span>{{__('lang.admin_update')}}
                    </button>
                    <a type="reset" class="btn btn-outline-secondary" href="{{url('admin/deliveryman')}}">{{__('lang.admin_back')}}</a>
                </div>
            </div>
        </div>
        

        <!-- Add -->
          <div class="row">
                  <!-- First column-->
                  <div class="col-12 col-lg-12">

                    <!-- General Information -->
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-tile mb-0">{{__('lang.admin_general_info')}}</h5>
                      </div>
                      <div class="card-body row">

                          <div class="col-md-12 row">
                            <input type="hidden" name="id" value="{{$result->id}}">
                            <!-- name -->
                            <div class="mb-3 col-md-4">
                              <label class="form-label" for="ecommerce-product-name">{{__('lang.admin_name')}} <span class="required">*</span></label>
                              <input
                                type="text"
                                class="form-control"
                                id="ecommerce-product-name"
                                placeholder="{{__('lang.admin_name_placeholder')}}"
                                name="name"
                                value="{{$result->name}}"
                                aria-label="{{__('lang.admin_name')}}" required/>
                            </div>

                            <!-- email -->
                            <div class="mb-3 col-md-4">
                              <label class="form-label" for="ecommerce-product-name">{{__('lang.admin_email')}} <span class="required">*</span></label>
                              <input
                                type="text"
                                class="form-control"
                                id="ecommerce-product-name"
                                placeholder="{{__('lang.admin_email_placeholder')}}"
                                name="email"
                                value="{{$result->email}}"
                                aria-label="{{__('lang.admin_email')}}" required/>
                            </div>

                       


                            <!-- Image -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label image_lable" for="ecommerce-category-image">{{__('lang.admin_image')}} <span class="required">*</span></label>
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                            <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="image">
                                            <label for="imageUpload"><i class="ti ti-pencil me-1 pencil_for_img_upload"></i></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview" style='background-image: url("{{asset('/uploads/deliveryman/'.$result->image)}}");'>
                                            </div>
                                        </div>
                                </div>
                            </div>
                          </div>
                      </div>
                    </div>
                    <!-- /General Information -->

                    <!-- Identification Information -->
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-tile mb-0">{{__('lang.admin_identification_information')}}</h5>
                      </div>
                      <div class="card-body row">

                          <div class="col-md-12 row">

                            <!-- Vehicle Type -->
                            <div class="mb-3 col-md-4 col ecommerce-select2-dropdown">
                              <label class="form-label mb-1" for="vendor">{{__('lang.admin_vehicle_type')}} <span class="required">*</span></label>
                              <select class="select2 form-select" name="vehicle_type" required>
                                @if(count($vehicleType))
                                @foreach($vehicleType as $value => $label)
                                    <option <?=$result->vehicle_type == $value ? 'selected' : '';?> value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                                @endif
                              </select>
                            </div>
                            <!-- Identity Type -->
                           

            <div class="mb-3 col-md-4 col ecommerce-select2-dropdown">
        <label class="form-label mb-1" for="identity_type">{{__('lang.admin_identity_type')}} <span class="required">*</span></label>
        <select class="select2 form-select" name="identity_type" id="identity_type" required>
            <option value="">{{__('lang.admin_select_identity_type')}}</option>
              @if(count($identityType))
                 @foreach($identityType as $value => $label)
            <option <?=$result->identity_type == $value ? 'selected' : '';?> value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                                @endif
        </select>
    </div>

                            <!-- Identity Number -->
                         

                            <div class="mb-3 col-md-4">
        <label class="form-label" for="identity_number">{{__('lang.admin_identity_number')}} <span class="required">*</span></label>
        <input
            type="text"
            class="form-control"
            id="identity_number"
            placeholder="Ex: DH-123"
            value="{{$result->identity_number}}"
            name="identity_number"
            aria-label="{{__('lang.admin_identity_number')}}"
            required
        />
    </div>
                            
                            <!-- Identity front image -->
                            <div class="col-md-4 mt-3">
                                <label class="form-label image_lable"
                                    for="ecommerce-category-image">{{__('lang.admin_identity_front_image')}} <span class="required">*</span></label>
                                <div class="mb-3">
                                     <img src="{{asset('/uploads/identity_front_image/'.$result->identity_front_image)}}" class="rounded me-50 hide upload_identity_image_show" id="image-preview-icon"
                                    alt="icon" height="80" width="80"
                                    onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                                    <div class="mb-0">
                                        <label class="identity_image_upload_btn"
                                            for="change-picture-icon">
                                            <span class="d-none d-sm-block text-center">{{__('lang.admin_upload')}}</span>
                                            <input class="form-control" type="file" name="identity_front_image"
                                                id="change-picture-icon" hidden
                                                accept="image/png, image/jpeg, image/jpg"
                                                onclick="showImagePreview('change-picture-icon','image-preview-icon',512,512);">
                                            <span class="d-block d-sm-none">
                                                <i class="me-0" data-feather="edit"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <!-- Identity back image -->
                            <div class="col-md-4 mt-3">
                                <label class="form-label image_lable"
                                    for="ecommerce-category-image">{{__('lang.admin_identity_back_image')}} <span class="required">*</span></label>
                                <div class="mb-3">
                                     <img src="{{asset('/uploads/identity_back_image/'.$result->identity_back_image)}}" class="rounded me-50 hide upload_identity_image_show" id="image-preview-icon-1"
                                    alt="icon" height="80" width="80"
                                    onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                                    <div class="mb-0">
                                        <label class="identity_image_upload_btn"
                                            for="change-picture-icon-1">
                                            <span class="d-none d-sm-block text-center">{{__('lang.admin_upload')}}</span>
                                            <input class="form-control" type="file" name="identity_back_image"
                                                id="change-picture-icon-1" hidden
                                                accept="image/png, image/jpeg, image/jpg"
                                                onclick="showImagePreview('change-picture-icon-1','image-preview-icon-1',512,512);">
                                            <span class="d-block d-sm-none">
                                                <i class="me-0" data-feather="edit"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                          </div>

                      </div>
                    </div>
                    <!-- /Identification Information -->

                    <!-- Addional -->
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-title mb-0">{{__('lang.admin_additional_data')}}</h5>
                      </div>
                      <div class="card-body row">
                        <!-- age -->
                      
                         
                        <!--  birthdate -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="ecommerce-product-name">{{__('lang.admin_birthdate')}} <span class="required">*</span></label>
                            <input type="date" class="form-control" name="birthdate"  value="{{$result->birthdate}}" required>
                        </div>

                        <!--  Driving license -->
<div class="mb-3 col-md-6">
    <label class="form-label" for="ecommerce-product-name">
        {{ __('lang.admin_driving_license') }} <span class="required">*</span>
    </label>

    <!-- Display existing image if available -->
    <div id="existing-preview-container" class="mb-2" 
        @if(empty($result->driving_license)) style="display: none;" @endif>
        <img id="existing-preview-image" 
             src="{{ asset('uploads/driving_license/' . $result->driving_license) }}" 
             alt="Driving License Preview" 
             class="img-fluid rounded" 
             style="max-width: 200px; max-height: 150px;">
    </div>

    <!-- File input for uploading new image -->
    <input type="file" class="form-control" name="driving_license" id="driving_license">

    <!-- Preview selected image before uploading -->
    <div id="new-preview-container" class="mt-2" style="display: none;">
        <img id="new-preview-image" class="img-fluid rounded" 
             style="max-width: 200px; max-height: 150px;">
    </div>
</div>


                      </div>
                    </div>
                    <!-- /Addional -->

                    <!-- Account Info -->
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-title mb-0">{{__('lang.admin_account_information')}}</h5>
                      </div>
                      <div class="card-body row">

                        <!-- phone -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label" for="ecommerce-product-name">{{__('lang.admin_phone')}} <span class="required">*</span></label>
                            <input type="tel" class="form-control" name="phone" placeholder="{{__('lang.admin_phone')}}" required value="{{$result->phone}}" maxlength="10">
                        </div>

                        <!-- password -->
                        <div class="mb-3 col-md-4">
                            <label for="password" class="form-label">{{__('lang.admin_password')}} <span class="required">*</span></label>
                            <input
                              class="form-control"
                              type="text"
                              id="password"
                              name="password"
                              required
                              placeholder="{{__('lang.admin_password')}}"
                              value="{{$result->password}}">
                              <span class="text-danger-msg"> {{__('lang.admin_password_limit_msg')}}</span>
                          </div>
                         
                        <!--confirm password -->
                        <div class="mb-3 col-md-4">
                            <label for="password" class="form-label">{{__('lang.admin_confirm_password')}}</label>
                            <input
                              class="form-control"
                              type="text"
                              id="confirm_password"
                              name="confirm_password"
                              
                              placeholder="{{__('lang.admin_confirm_password')}}">
                              <span class="text-danger-msg"> {{__('lang.admin_password_limit_msg')}}</span>
                          </div>
                      </div>
                    </div>
                    <!-- /Account Info -->
  
                  </div>
                  <!-- /First column -->
                </div>
        <!-- end product add -->

    </form>
       

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->
<script>
document.getElementById('driving_license').addEventListener('change', function(event) {
    let file = event.target.files[0];

    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            // Hide the existing image preview
            document.getElementById('existing-preview-container').style.display = 'none';

            // Show the new preview image
            document.getElementById('new-preview-image').src = e.target.result;
            document.getElementById('new-preview-container').style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        // If no file is selected, revert to showing the existing image
        document.getElementById('new-preview-container').style.display = 'none';
        if ("{{ $result->driving_license }}") {
            document.getElementById('existing-preview-container').style.display = 'block';
        }
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const identityForm = document.getElementById("identityForm");
        const identityType = document.getElementById("identity_type");
        const identityNumber = document.getElementById("identity_number");

        identityForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent form submission initially

            const selectedType = identityType.value;
            const inputValue = identityNumber.value.trim();
            let regex, requiredLength, errorMessage;

            if (selectedType === "aadhar_card") {
                regex = /^[0-9]+$/;
                requiredLength = 12;
                errorMessage = "Aadhar Card must be exactly 12 digits and contain only numbers.";
            } else if (selectedType === "Passport") {
                regex = /^[a-zA-Z0-9]+$/;
                requiredLength = 8;
                errorMessage = "Passport must be exactly 8 characters and contain only letters and numbers.";
            } else if (selectedType === "driving_licence") {
                regex = /^[a-zA-Z0-9]+$/;
                requiredLength = 16;
                errorMessage = "Driving Licence must be exactly 16 characters and contain only letters and numbers.";
            } else if (selectedType === "voter_id_card") {
                regex = /^[a-zA-Z0-9]+$/;
                requiredLength = 10;
                errorMessage = "Voter ID Card must be exactly 10 characters and contain only letters and numbers.";
            } else {
                Swal.fire({
                    title: "Error",
                    text: "Please select an identity type.",
                    icon: "error",
                    confirmButtonText: "OK",
                });
                return;
            }

            // Validate input value
            if (!regex.test(inputValue) || inputValue.length !== requiredLength) {
                Swal.fire({
                    title: "Error",
                    text: errorMessage,
                    icon: "error",
                    confirmButtonText: "OK",
                });
                return;
            }

            // If validation passes, submit the form
            identityForm.submit();
        });
    });
</script>
@endsection
