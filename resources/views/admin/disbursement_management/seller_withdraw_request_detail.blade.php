@extends('admin.layouts.app')
@section('content')

<style>
    .fixed-height-card {
        min-height: 100px; /* Adjust the height as needed */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card p-4 bg-white shadow">
            <h4 class="mb-4">General Info</h4>

            <div class="row">
                <div class="col-md-6">
                    <div class="card p-3 bg-white shadow-sm fixed-height-card">
                        <p>Name: {{$result->name }}</p>
                        <p>Email: {{$result->email }}</p>
                        <p>Phone: {{$result->phone }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3 bg-white shadow-sm fixed-height-card">
                        <p>Shop Name: {{$result->shopname }}</p>
                        <p>Address: {{$result->address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-4 bg-white shadow mt-4">
            <h4 class="mb-4">Account Information</h4>

            <div class="row">
                <div class="col-md-6">
                    <div class="card p-3 bg-white shadow-sm fixed-height-card">
                        <p>Account Holder Name: {{$result->holdername }}</p>
                        <p>Bank Name: {{$result->bank_name }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3 bg-white shadow-sm fixed-height-card">
                        <p>IFSC Code: {{$result->ifsccode }}</p>
                        <p>Account Number: {{$result->accountno }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-4 bg-white shadow mt-4">
            <h4 class="mb-4">Withdraw Request</h4>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ url('admin/withdraw-request-approved') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ Request::segment(3) }}">
                                
                                <div class="col-md-12">
                                    <label class="form-label">Note</label>
                                    <textarea class="form-control" name="message">{{ $withdrawid->message }}</textarea>
                                </div>

                                @if ($withdrawid->status == 'pending')
                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="submit" name="status" value="completed" class="btn btn-success">Completed</button>
                                        <button type="submit" name="status" value="cancelled" class="btn btn-danger ms-2">Cancelled</button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>

@endsection
