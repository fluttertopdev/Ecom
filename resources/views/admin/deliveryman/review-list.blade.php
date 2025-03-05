@extends('admin.layouts.app')
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-12">
                <h4 class="py-3 mb-4">
                  <span class="text-muted fw-light">
                    <a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> /
                  </span>
                  {{__('lang.admin_deliveryman_review_list')}}</h4>
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
                            <button type="submit" class="btn btn-primary data-submit">{{__('lang.admin_search')}}</button>
                            <a type="reset" class="btn btn-outline-secondary" href="{{url('admin/item-reviews')}}">{{__('lang.admin_reset')}}</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <!-- Bordered Table -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5>{{__('lang.admin_deliveryman_reviews')}}</h5>
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
                                <th>{{__('lang.admin_sl')}}</th>
                                <th>{{__('lang.admin_order_id')}}</th>
                                <th>{{__('lang.admin_name')}}</th>
                                <th>{{__('lang.admin_reviewer_info')}}</th>
                                <th>{{__('lang.admin_reviewer_review')}}</th>
                                <th>{{__('lang.admin_date')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($result) > 0)
                            @foreach($result as $review)
                                <tr>
                                    <td>{{ $loop->iteration }}</td> 
                                    <td>{{ $review->order->order_unique_id }}</td>
                                     <td>{{ $review->deliveryman->name }}</td>
                                    <td>
                                        {{ $review->user->name }} <br>
                                        Rating: {{ $review->star_rating }}/5
                                    </td>
                                    <td>{{ \Helpers::getReviewLimit($review->review) }}</td>
                                    <td>{{ \Helpers::commonDateFormateWithTime($review->created_at) }}</td>
                                </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="10" class="record-not-found">
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
        <!--/ Bordered Table -->

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

@endsection
