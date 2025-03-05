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
                  {{__('lang.admin_push_notification_list')}}</h4>
            </div>
            @can('add-push-notification')
            <div class="col-md-6">
                <div class="table-btn-css">
                    <a href="{{url('admin/add-push-notification')}}">
                    <button type="button" class="btn btn-primary waves-effect waves-light">
                        <span class="ti-xs ti ti-plus me-1"></span>{{__('lang.admin_add_push_notification')}}
                    </button>
                    </a>
                </div>
            </div>
            @endcan
        </div>

        <div class="card margin-bottom-20">
            <div class="card-header">
                <form method="get">
                    <div class="row">
                        <h5 class="card-title display-inline-block">{{__('lang.admin_filters')}}</h5>
                        <div class="form-group col-sm-3 display-inline-block">
                            <input type="text" class="form-control dt-full-name" placeholder="{{__('lang.admin_search_title')}}" name="title" value="@if(isset($_GET['title']) && $_GET['title']!=''){{$_GET['title']}}@endif">
                        </div>
                        <div class="col-sm-3 display-inline-block">
                            <button type="submit" class="btn btn-primary data-submit">{{__('lang.admin_search')}}</button>
                            <a type="reset" class="btn btn-outline-secondary" href="{{url('admin/items')}}">{{__('lang.admin_reset')}}</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <!-- Bordered Table -->
        @include('admin/push-notification/table')
        <!--/ Bordered Table -->

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

@endsection
