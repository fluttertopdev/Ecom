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
                  {{__('lang.admin_subcategory_list')}}</h4>
            </div>
            
            <div class="col-md-6">
                <div class="table-btn-css">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="offcanvas"
                        data-bs-target="#add-new-record" aria-controls="add-new-record">
                        <span class="ti-xs ti ti-plus me-1"></span>{{__('lang.admin_subcategory_add')}}
                    </button>
                </div>
            </div>
    
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
                            <select class="form-control select2 form-select" name="category_id">
                                <option value="">{{__('lang.admin_select_category')}}</option>
                                @if(count($category_data))
                                @foreach($category_data as $category)
                                    <option value="{{ $category->id }}" @if(isset($_GET['category_id']) && $_GET['category_id']!='' && $_GET['category_id']==$category->id) selected @endif>{{ $category->name }}</option>
                                @endforeach
                                @endif
                            </select>
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
                            <button type="submit" class="btn btn-primary data-submit">{{__('lang.admin_search')}}</button>
                            <a type="reset" class="btn btn-outline-secondary" href="{{url('admin/subcategory')}}">{{__('lang.admin_reset')}}</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <!-- Bordered Table -->
        @include('admin/subcategory/table')
        <!--/ Bordered Table -->

        <!-- Modal to add new record -->
        @include('admin/subcategory/add_modal')
        <!--/ Modal to add new record -->

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

@endsection
