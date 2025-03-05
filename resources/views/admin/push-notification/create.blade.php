@extends('admin.layouts.app')
@section('content')
<style type="text/css">
  .mb-3 img .hide{
    height: 120px;
    width: 290px;
  }
  .banner_website_image_show{
    height: 120px;
    width: 290px;
  }
  .banner_upload_btn_parent{
     text-align: center;
     margin-top: 5px;
  }
  .banner_upload_btn{
    color: #7367f0;
    border-color: #7367f0;
    background: transparent;
    border: 1px solid;
    padding: 4px 6px;
    cursor: pointer;
    border-radius: 6px;
  }
</style>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">


    <form action="{{url('admin/send-push-notification')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-9">
                <h4 class="py-3 mb-4">
                  <span class="text-muted fw-light">
                    <a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> /
                  </span><span class="text-muted fw-light">
                    <a href="{{url('admin/push-notification')}}">{{__('lang.admin_push_notification_list')}}</a> /
                  </span>
                  {{__('lang.admin_add_push_notification')}}</h4>
            </div>
            <div class="col-md-3">
                <div class="table-btn-css">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        <span class="ti-xs ti ti-plus me-1"></span>{{__('lang.admin_submit')}}
                    </button>
                    <a type="reset" class="btn btn-outline-secondary" href="{{url('admin/push-notification')}}">{{__('lang.admin_back')}}</a>
                </div>
            </div>
        </div>
        

        <!-- add -->
          <div class="row">
            <div class="col-12 col-lg-8">
              <div class="card mb-4">
                <div class="card-body row">
                  <!-- title -->
                  <div class="mb-3 col-md-6">
                    <label class="form-label" for="">{{__('lang.admin_title')}} <span class="required">*</span></label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="{{__('lang.admin_title_placeholder')}}"
                      name="title"
                      aria-label="{{__('lang.admin_title')}}" required/>
                  </div>
                  <!-- Schedule date -->
                  <div class="col-md-6 col-12 mb-4">
                    <label for="flatpickr-datetime" class="form-label">{{__('lang.admin_schedule_date')}}</label>
                    <input
                      name="schedule_date"
                      type="text"
                      class="form-control"
                      placeholder="YYYY-MM-DD HH:MM"
                      id="flatpickr-datetime" />
                  </div>
                  <!-- Area -->
                  <div class="mb-3 col-md-6 col ecommerce-select2-dropdown">
                      <label class="form-label mb-1" for="status-org"> {{__('lang.admin_area')}} <span class="required">*</span></label>
                      <select class="select2 form-select area_id" name="area_id" required>
                        <option value="">{{__('lang.admin_select_area')}}</option>
                        @if(count($area_data))
                          @foreach($area_data as $row)
                              <option value="{{$row->id}}" {{ old('area_id') == $row->id ? 'selected' : '' }}>{{$row->name}}</option>
                          @endforeach
                        @endif
                      </select>
                  </div>
                  <!-- Send to -->
                  <div class="mb-3 col-md-6 col ecommerce-select2-dropdown">
                    <label class="form-label mb-1" for="send_to">{{__('lang.admin_send_to')}} <span class="required">*</span></label>
                    <select class="select2 form-select" name="send_to" id="send_to" required>
                      <option value="">{{__('lang.admin_select_send_to')}}</option>
                      @if(count($sendTo))
                        @foreach($sendTo as $value => $label)
                          <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                  <!-- Description -->
                  <div class="mb-3 col-md-12">
                    <label class="form-label" for="">{{__('lang.admin_description')}}</label>
                    <textarea
                      type="text"
                      class="form-control"
                      placeholder="{{__('lang.admin_description')}}"
                      name="description"
                      aria-label="{{__('lang.admin_description')}}"/></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-4">
              <div class="card mb-4">
                <div class="card-body">
                  <!-- banner -->
                    <div class="col-sm-12 mt-3">
                        <label class="form-label image_lable" for="ecommerce-category-image">{{__('lang.admin_banner')}}</label>
                        <div class="mb-3">
                          <img src="" class="rounded me-50 hide banner_website_image_show" id="image-preview-icon" alt="icon" onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                            <div class="banner_upload_btn_parent">
                                <label class="banner_upload_btn"
                                    for="change-picture-icon">
                                    <span class="d-none d-sm-block">{{__('lang.admin_upload')}}</span>
                                    <input name="banner" class="form-control" type="file"
                                        id="change-picture-icon" hidden
                                        accept="image/png, image/jpeg, image/jpg" name="icon"
                                        onclick="showImagePreview('change-picture-icon','image-preview-icon',512,512);">
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
          </div>
        <!-- end add -->

    </form>
       

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

@endsection
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $('#banner_type').on('change', function() {
      var selectedBannerType = $(this).val();
      if (selectedBannerType == 'restaurant_wise') {
         $('.item-select-wrapper').css('display','none');
         $('.restaurant-select-wrapper').css('display','block');
      } else if (selectedBannerType == 'item_wise') {
         $('.restaurant-select-wrapper').css('display','none');
         $('.item-select-wrapper').css('display','block');
      }
    });
  });
</script>
