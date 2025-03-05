@extends('admin.layouts.app')
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="app-ecommerce">
            <!-- Add Product -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1">Coustom section Translation</h4>
                </div>
            </div>

            <div class="row">
                <form id="productform" action="{{ route('coustomsectionupdate.update.coustomsectionupdate', $Homepage->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- First column -->
                    <div class="col-12 col-lg-12">
                        <!-- Product Information -->
                        <div class="card mb-4">
                            <div class="card-body">
                                @foreach ($languages as $language)
                                <div class="form-group mb-4">
                                    <label for="translated-name-{{ $language->language_code }}" class="form-label">
                                      Title ({{ $language->name }})
                                    </label>
                                    <input type="hidden" name="translation_id[]" value="{{ $language->details->id ?? null }}">
                                    <input type="hidden" name="language_code[]" value="{{ $language->code }}">
                                    <input type="text" class="form-control" id="translated-name-{{ $language->language_code }}" name="name[]" required value="{{ $language->details->name ?? '' }}">
                                </div>
                                @endforeach
                                
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save Translation</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
