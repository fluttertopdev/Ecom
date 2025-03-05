@extends('admin/layouts/app') @section('content') 
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" />
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4 display-inline-block">
    <span class="text-muted fw-light">
      <a href="{{url('admin/dashboard')}}">Dashboard</a> / </span>Translation List
  </h4>

  <button class="btn btn-secondary btn-primary float-right mt-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#add-new-record" aria-controls="add-new-record">
    <span>
      <i class="ti ti-plus me-md-1"></i>
      <span class="d-md-inline-block d-none">Add translation</span>
    </span>
  </button>
  
  <div class="card margin-bottom-20">
    <div class="card-header">
      <form method="get">
        <div class="row">
          <h5 class="card-title display-inline-block">Filter</h5>
          <div class="form-group col-sm-3 display-inline-block" >
              <input type="text" class="form-control" placeholder="Group Name" name="value" value="@if(isset($_GET['value']) && $_GET['value']!=''){{$_GET['value']}}@endif">
          </div>
          <div class="col-sm-3 display-inline-block">
              <select class="form-control" name="group">
                <option value="">Select Group</option> 
                <option value="frontend" @if(isset($_GET['group']) && $_GET['group']!='') @if($_GET['group'] == 'frontend') selected @endif @endif>Website</option> 
                <option value="admin" @if(isset($_GET['group']) && $_GET['group']!='') @if($_GET['group'] == 'admin') selected @endif @endif>Admin</option> 
                 <option value="seller" @if(isset($_GET['group']) && $_GET['group']!='') @if($_GET['group'] == 'seller') selected @endif @endif>Seller</option>
            
              </select>
          </div>
        
          <div class="col-sm-3 display-inline-block">
            <button type="submit" class="btn btn-primary data-submit">Search</button>
            <a type="reset" class="btn btn-outline-secondary" href="">Reset</a>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <h5 class="card-title display-inline-block">Translation List</h5>
      <h6 class="float-right"> <?php if ($result->firstItem() != null) {?> {{__('lang.admin_showing')}} {{ $result->firstItem() }}-{{ $result->lastItem() }} {{__('lang.admin_of')}} {{ $result->total() }} <?php }?> </h6>
    </div>
    <div class="table-responsive text-nowrap"> @include('admin/translation/table') </div>
    <div class="card-footer">
      <div class="pagination" style="float: right;">
        {{$result->withQueryString()->links('pagination::bootstrap-4')}}
      </div>
    </div>
  </div>
  <div class="offcanvas offcanvas-end" id="add-new-record">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title" id="exampleModalLabel">Translation List</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
      <form class="add-new-record pt-0 row g-2" id="add-record" onsubmit="return validateTranslation('add-record');" action="{{url('admin/add-translation')}}" method="POST"> @csrf 
        <div class="col-sm-12">
          <div class="mb-1">
            <label class="form-label" for="group">Group <span class="required">*</span></label>
              <select class="form-control" name="group" required>
                <option value="">Group</option> 
                <option value="frontend">Website</option> 
                <option value="admin">Admin</option> 
                <option value="seller">Seller</option> 
            
              </select>
          </div>
        </div>
        <input type="hidden" name="transid" value="{{ Request::segment(3) }}">
        <div class="col-sm-12">
          <div class="mb-1">
            <label class="form-label" for="keyword">Keyword<span class="required">*</span></label>
            <input class="form-control" id="keyword" name="keyword" placeholder="Keyword" required />
          </div>
        </div>
        <div class="col-sm-12">
          <div class="mb-1">
            <label class="form-label" for="value">Value<span class="required">*</span></label>
            <input class="form-control" id="value" name="value" placeholder="Value" required />
          </div>
        </div>
        
        <div class="col-sm-12">
          <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">Save</button>
          <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div> @endsection