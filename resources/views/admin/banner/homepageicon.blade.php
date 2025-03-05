    

@extends('admin.layouts.app')
@section('content')
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 99%;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h2 {
            font-size: 22px;
            font-weight: 600;
        }

        .header .icons {
            font-size: 20px;
        }

        .header .icons i {
            margin-left: 15px;
            cursor: pointer;
        }

        .content {
            display: flex;
            justify-content: space-between;
        }

        .order-info, .account-info {
            width: 48%;
        }

        .order-info h3, .account-info h3 {
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .order-info ul, .account-info ul {
            list-style: none;
        }

        .order-info ul li, .account-info ul li {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .order-info ul li strong, .account-info ul li strong {
            width: 150px;
            display: inline-block;
        }

        .order-info ul li select, .order-info ul li input[type="text"] {
            padding: 5px;
            width: auto;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .address-info {
            margin-top: 40px;
        }

        .billing-shipping {
            display: flex;
            justify-content: space-between;
        }

        .billing-address, .shipping-address {
            width: 48%;
        }

        .items-ordered {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table thead th {
            background-color: #f4f4f4;
            font-weight: 600;
        }

        tfoot tr td {
            font-weight: 600;
            text-align: right;
        }
    </style>




 <div class="container mt-2">
    <form action="{{ url('admin/homepageupdateIcons') }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- Include CSRF token for Laravel forms -->
        <h3>Home Page Icon</h3>
        
        @foreach($iconsresult as $row)
        <div class="row">
            <!-- Icon Upload Section -->
            <div class="col-md-6 mt-3">
                <label class="form-label" for="icon-{{ $row->id }}">Icon</label>
                <div class="d-flex align-items-center">
                    <!-- New Image Preview -->
                    <img src="{{ url('uploads/banner/icon/'.$row->icon)}}" 
                         class="rounded me-3 new-icon-preview" 
                         id="new-site-logo-preview-{{ $row->id }}" 
                         alt="logo" height="80" width="80" 
                         onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`" />
                    <div>
                        <label class="btn btn-primary mb-0" for="new-icon-{{ $row->id }}">
                            <span class="d-none d-sm-block">Upload</span>
                            <input class="form-control" type="file" 
                                   id="new-icon-{{ $row->id }}" 
                                   name="icon[{{ $row->id }}][icon]" hidden accept="image/*" 
                                   onchange="showNewImagePreview('new-icon-{{ $row->id }}', 'new-site-logo-preview-{{ $row->id }}', 80, 80);" />
                            <span class="d-block d-sm-none">
                                <i class="me-0" data-feather="edit"></i>
                            </span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Headings in One Row -->
            <div class="col-md-6 mt-3">
                <div class="row">
                    <!-- Heading First Input -->
                    <div class="col-md-6">
                        <label class="form-label" for="heading-first-{{ $row->id }}">Heading First</label>
                        <input type="text" id="heading-first-{{ $row->id }}" value="{{ $row->textfield1 }}" 
                               name="icons[{{ $row->id }}][textfield1]" class="form-control" 
                               placeholder="Enter first heading" />
                    </div>
                    <!-- Heading Second Input -->
                    <div class="col-md-6">
                        <label class="form-label" for="heading-second-{{ $row->id }}">Heading Second</label>
                        <input type="text" id="heading-second-{{ $row->id }}" value="{{ $row->textfield2 }}" 
                               name="icons[{{ $row->id }}][textfield2]" class="form-control" 
                               placeholder="Enter second heading" />
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Submit Button -->
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>

<script>
    // Function to display the new image preview
    function showNewImagePreview(inputId, previewId, maxWidth, maxHeight) {
        var input = document.getElementById(inputId);
        var preview = document.getElementById(previewId);

        var reader = new FileReader();

        reader.onload = function (e) {
            var img = new Image();
            img.src = e.target.result;
            img.onload = function() {
                var width = img.width;
                var height = img.height;

                // Resize image if needed
                if (width > maxWidth || height > maxHeight) {
                    var ratio = Math.min(maxWidth / width, maxHeight / height);
                    width = width * ratio;
                    height = height * ratio;
                }

                // Set preview image source
                preview.src = e.target.result;
                preview.width = width;
                preview.height = height;
            };
        };
        
        // Read the selected file as a Data URL
        reader.readAsDataURL(input.files[0]);
    }
</script>
@endsection