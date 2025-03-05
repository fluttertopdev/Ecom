@extends('sellers.layouts.app')
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
                  Products List</h4>
            </div>
         
        @if (in_array('add-product', \Helpers::sellergetAssignedPermissions()))
            <div class="col-md-6">
                <div class="table-btn-css">
                    <a href="{{url('sellers-product-create')}}"><button type="button" class="btn btn-primary waves-effect waves-light" 
                         >
                        <span class="ti-xs ti ti-plus me-1"></span> Add Product
                    </button></a>
                </div>
            </div>
                @endif 
           
        </div>

        <div class="card margin-bottom-20">
            <div class="card-header">
                <form method="get">
                    <div class="row">
                        <h5 class="card-title display-inline-block">{{__('lang.admin_filters')}}</h5>
                        <div class="form-group col-sm-3 display-inline-block">
    <input type="text" class="form-control dt-full-name" placeholder="{{__('lang.admin_search_name')}}" name="name" value="@if(isset($_GET['name']) && $_GET['name']!=''){{$_GET['name']}}@endif">
                        </div>


                        <div class="col-sm-3 display-inline-block">
                            <select class="form-control select2 form-select" name="status">
                                <option value="">{{__('lang.admin_select_status')}}</option>
                                    @if(count($statusTypes))
                                    @foreach($statusTypes as $value => $label)
                                        <option value="{{$value}}" @if(isset($_GET['status']) && $_GET['status']!='') @if($_GET['status']==$value) selected @endif @endif>{{$label}}</option>
                                    @endforeach
                                    @endif
                            </select>
                        </div>

                        <div class="col-sm-3 display-inline-block">
    <select class="form-control select2 form-select" name="categories_id">
        <option value="">Select Category</option>
    
            @foreach($categories as $category)
                <option value="{{ $category->id }}" 
                    @if(isset($_GET['categories_id']) && $_GET['categories_id'] != '') 
                        @if($_GET['categories_id'] == $category->id) selected @endif 
                    @endif>
                    {{ $category->name }}
                </option>
            @endforeach
        
    </select>
</div>


                                <div class="col-sm-3 display-inline-block">
    <select class="form-control select2 form-select" name="brand_id">
        <option value="">Select Brand</option>
    
            @foreach($brand as $brands)
                <option value="{{ $brands->id }}" 
                    @if(isset($_GET['brand_id']) && $_GET['brand_id'] != '') 
                        @if($_GET['brand_id'] == $brands->id) selected @endif 
                    @endif>
                    {{ $brands->name }}
                </option>
            @endforeach
        
    </select>
</div>





                        <div class="col-sm-3 display-inline-block mt-4">
                            <button type="submit" class="btn btn-primary data-submit">{{__('lang.admin_search')}}</button>
                            <a type="reset" class="btn btn-outline-secondary"
                                href="{{url('sellersproducts')}}">{{__('lang.admin_reset')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    
        @include('sellers/sellersproduct/table')
        

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

@endsection
