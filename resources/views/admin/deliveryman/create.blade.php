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


    <form action="{{url('admin/save-deliveryman')}}" method="POST" enctype="multipart/form-data" id="identityForm">
        @csrf

        <div class="row">
            <div class="col-md-8">
                <h4 class="py-3 mb-4">
                  <span class="text-muted fw-light">
                    <a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> /
                  </span><span class="text-muted fw-light">
                    <a href="{{url('admin/deliveryman')}}">{{__('lang.admin_deliveryman_list')}}</a> /
                  </span>
                  {{__('lang.admin_add_deliveryman_form')}}</h4>
            </div>
            <div class="col-md-4">
                <div class="table-btn-css">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        <span class="ti-xs ti ti-plus me-1"></span>{{__('lang.admin_submit')}}
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
                            <!-- name -->
                            <div class="mb-3 col-md-4">
                              <label class="form-label" for="ecommerce-product-name">{{__('lang.admin_name')}} <span class="required">*</span></label>
                              <input
                                type="text"
                                class="form-control"
                                id="ecommerce-product-name"
                                placeholder="{{__('lang.admin_name_placeholder')}}"
                                name="name"
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
                                aria-label="{{__('lang.admin_email')}}" required/>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="form-label image_lable" for="ecommerce-category-image">{{__('lang.admin_image')}} <span class="required">*</span></label>
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                            <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="image" required/>
                                            <label for="imageUpload"><i class="ti ti-pencil me-1 pencil_for_img_upload"></i></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview" style='background-image: url("public/uploads/no-image.png");'>
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
                                <option value="">{{__('lang.admin_select_vehicle_type')}}</option>
                                @if(count($vehicleType))
                                @foreach($vehicleType as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
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
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="mb-3 col-md-4">
        <label class="form-label" for="identity_number">{{__('lang.admin_identity_number')}} <span class="required">*</span></label>
        <input
            type="text"
            class="form-control"
            id="identity_number"
            placeholder="Ex: DH-123"
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
                                     <img src="" class="rounded me-50 hide upload_identity_image_show" id="image-preview-icon"
                                    alt="icon" height="80" width="80"
                                    onerror="this.onerror=null;this.src=`https://demo.fleetcart.envaysoft.com/build/assets/placeholder_image.png`" />
                                    <div class="mb-0">
                                        <label class="identity_image_upload_btn"
                                            for="change-picture-icon">
                                            <span class="d-none d-sm-block text-center">{{__('lang.admin_upload')}}</span>
                                            <input class="form-control" type="file" name="identity_front_image"
                                                id="change-picture-icon" hidden
                                                accept="image/png, image/jpeg, image/jpg"
                                                onclick="showImagePreview('change-picture-icon','image-preview-icon',512,512);" required>
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
                                     <img src="" class="rounded me-50 hide upload_identity_image_show" id="image-preview-icon-1"
                                    alt="icon" height="80" width="80"
                                    onerror="this.onerror=null;this.src=`https://demo.fleetcart.envaysoft.com/build/assets/placeholder_image.png`" />
                                    <div class="mb-0">
                                        <label class="identity_image_upload_btn"
                                            for="change-picture-icon-1">
                                            <span class="d-none d-sm-block text-center">{{__('lang.admin_upload')}}</span>
                                            <input class="form-control" type="file" name="identity_back_image"
                                                id="change-picture-icon-1" hidden
                                                accept="image/png, image/jpeg, image/jpg"
                                                onclick="showImagePreview('change-picture-icon-1','image-preview-icon-1',512,512);" required>
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
                            <input type="date" class="form-control" name="birthdate" required>
                        </div>

                        <!--  Driving license -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="ecommerce-product-name">{{__('lang.admin_driving_license')}} <span class="required">*</span></label>
                            <input type="file" class="form-control" name="driving_license" required>
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

                        <!-- Phone -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label" for="ecommerce-product-name">{{__('lang.admin_phone')}} <span class="required">*</span></label>
                            <input type="tel" class="form-control" name="phone" placeholder="{{__('lang.admin_phone')}}" required value="{{ old('phone') }}" maxlength="10">
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
                              value="{{ old('password') }}">
                              <span class="text-danger-msg"> {{__('lang.admin_password_limit_msg')}}</span>
                          </div>
                         
                        <!--confirm password -->
                        <div class="mb-3 col-md-4">
                            <label for="password" class="form-label">{{__('lang.admin_confirm_password')}} <span class="required">*</span></label>
                            <input
                              class="form-control"
                              type="text"
                              id="confirm_password"
                              name="confirm_password"
                              required
                              placeholder="{{__('lang.admin_confirm_password')}}"
                              value="{{ old('confirm_password') }}">
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
