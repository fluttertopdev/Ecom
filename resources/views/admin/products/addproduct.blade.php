@extends('admin.layouts.app')
@section('content')

<?php


$unique_id = rand(10000000, 99999999);
$adminid = Auth::user()->id;


?>





<!-- Content wrapper -->
<div class="content-wrapper">
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
<div class="app-ecommerce">
<!-- Add Product -->
<div
class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
<div class="d-flex flex-column justify-content-center">
<h4 class="mb-1">Add a new Product</h4>

</div>

</div>

<div class="row">
<form id="productform"action="{{url('admin/product-store')}}" method="POST"
enctype="multipart/form-data">
@csrf

<!-- First column-->
<div class="col-12 col-lg-12">
<!-- Product Information -->
<div class="card mb-6 mt-4">
<div class="card-header">
<h5 class="card-tile mb-0">Product information</h5>
</div>
<div class="card-body">
<div class="mb-6">
<label class="form-label" for="ecommerce-product-name">Name <span class="required">*</span></label>
<input
type="text"
class="form-control"
id="ecommerce-product-name"
placeholder="Product title"
name="name"
aria-label="Product title" required />
</div>


<input type="hidden" name="producttype" value="admin">
<input type="hidden" name="created_by" value="{{$adminid}}">


<div class="row mb-6 mt-4">
<div class="col">
<label class="form-label" for="ecommerce-product-sku">Main Category <span class="required">*</span></label>

<select id="category-select" class="select2 form-select" name="categories_id" data-placeholder="Select Category" required>
<option value="">Select Category</option>
@foreach($categories as $category)
<option value="{{ $category->id }}">{{ $category->name }}</option>
@endforeach
</select >
</div>
<div class="col">
<label class="form-label" for="ecommerce-product-barcode">Subcategory <span class="required">*</span></label>
<select id="subcategory-select" name="subcategories_id" class=" select2 form-select form-select"  required>
<option value="">Select Subcategory</option>

</select>
</div>






<div class="col">
<label class="form-label" for="ecommerce-product-sku">Brand <span class="required">*</span></label>

<select id="brand-select" class="select2 form-select" name="brand_id" data-placeholder="Select Brand" required>
<option value="">Select Brand</option>
@foreach($brand as $list)
<option value="{{ $list->id }}">{{ $list->name }}</option>
@endforeach
</select>
</div>


</div>



<div class="row mb-2 mt-4">

<div class="col">
<label class="form-label" for="ecommerce-product-barcode">Discount(%)</label>
<input
type="number"
class="form-control"
id=""
name="discount"
placeholder="Discount"
max="99"
oninput="this.value = this.value.slice(0, 2)"
aria-label="Discount"
/>
</div>

<div class="col">
<label class="form-label" for="ecommerce-product-barcode">Tags</label>
<select id="brand-select" class="select2 form-select" name="visibilityid" data-placeholder="Select Tag" >
<option value="">Select Tags</option>
@foreach($product_tag as $list)
<option value="{{ $list->id }}">{{ $list->name }}</option>
@endforeach
</select>
</div>
</div>

<div class="row mb-6" id="productDetailsSection">
<div class="col">
<label class="form-label" for="ecommerce-product-sku">Quantity<span class="required">*</span></label>
<input
type="text"
class="form-control"
id="quantityInput"
name="qty"
placeholder="Quantity"
aria-label="Quantity"
required

/>
</div>
<div class="col">
<label class="form-label" for="ecommerce-product-barcode">Price<span class="required">*</span></label>
<input
type="text"
class="form-control"
id="priceInput"
name="price"
placeholder="Price"
aria-label="Price"required

/>
<input type="hidden" class="Uniqueid" value="{{$unique_id}}" name="unique_id">
</div>







</div>





@foreach($taxes as $tax)
<div class="row mb-2 mt-4">
<div class="col">
<label class="form-label" for="tax_{{ $loop->index }}">{{ $tax->name }}<span class="required">*</span></label>
<input
type="hidden"
name="tax_id[]"
value="{{ $tax->id }}" />
<input
type="number"
class="form-control"
id=""
name="rate[]"
placeholder=""
value="0" 
aria-label="" required />
</div>
<div class="col">
<label class="form-label" for="rate_{{ $loop->index }}">Rate<span class="required">*</span></label>
<select id="" class="select2 form-select" name="ratetype[]" data-placeholder="Please Select" required>
<option value="">Select Rate</option>

<option value="flat">flat</option>
<option value="percentage">Percentage</option>

</select>

</div>
</div>
@endforeach




<!-- Description -->
<div>
<label class="mb-1"> Short Description</label>

<textarea 
class="form-control"
id="shorteditor"
placeholder="Short Description"
name="short_des"
></textarea required>

</div>






<!-- Description -->
<div>
<label class="mb-1">Description</label>

<textarea 
class="form-control"
id="editor"
placeholder="Description"
name="description"
></textarea required>

</div>


</div>
</div>
</div>
<div class="card mb-12 mt-4" style="padding: 30px;">
<div class="card-header d-flex justify-content-between align-items-center">
<h3 class="mb-0 card-title">Product Images <span class="required">*</span></h3>
</div>
<h5 class="mb-0 card-title">Upload Product Images</h5>
<div class="field" align="left">
<input type="file" id="files" name="" multiple style="display: none;" />
<label for="files" class="upload-label">Upload Images</label>
</div>



</div>

<div class="card mb-6 mt-4">
<div class="card-header">
<h5 class="card-title mb-0">Attributes <span class="required">*</span></h5>
</div>
<div class="card-body">

<div data-repeater-list="group-a">
<div data-repeater-item>
<div class="row">
<div class="mb-6 col-4">
<label class="form-label" for="form-repeater-1-1">Options <span class="required">*</span></label>
<select id="form-repeater-1-1" name="attributes_id[]" class="select2 form-select" data-placeholder="Size" required>
<option value="">Select Options</option>
@foreach($attribute as $list)
<option value="{{ $list->id }}">{{ $list->name }}</option>
@endforeach
</select>
</div>

<div class="mb-6 col-8">
<label class="form-label invisible" for="form-repeater-1-2">Not visible</label>
<input type="text" name="attributes_value[]"id="form-repeater-1-2" class="form-control" placeholder="Enter Value" />
</div>
</div>
</div>
</div>
<div>
<button type="button" class="btn btn-primary mt-4" id="add-option">
<i class="ti ti-plus ti-xs me-2"></i>
Add another option
</button>

</div>


<div class="d-flex justify-content-end">
<button type="submit" style="background-color: #7367f0;" class="custom-button  mt-4 save-product-btn" id="saveProductSection">
Save Product
</button>
</div>


</div>
</div>


<div class="card mb-6 mt-4">
<div class="card-header d-flex align-items-center">
<input type="checkbox" id="addVariantCheckbox" class="me-2">
<h5 class="card-title mb-0">If you want to add variant</h5>
</div>
<div class="card-body">
<!-- Content for the card body -->
</div>

</div>













<div class="card mb-6 mt-4"  id="variantSection" style="display: none;">
<div class="card-header">
<h5 class="card-title mb-0">Variant </h5>
</div>
<div class="card-body">
<div id="variant-container">
<!-- Initial Variant Row -->
<div class="variant-row">
<div class="row">
<div class="mb-6 col-6">
<label class="form-label" for="form-name">Name</label>
<input type="text" class="form-control name-input" placeholder="Enter Name" />
</div>

<div class="mb-6 col-6">
<label class="form-label" for="form-repeater">Type</label>
<select class="form-control type-selector">

<option value="Text">Text</option>
<option value="Colors">Colors</option>
</select>
</div>
</div>
<div class="dynamic-fields row"></div>
<div>
<button type="button" class="btn btn-primary mt-4 add-row" style="display:none;">
<i class="ti ti-plus ti-xs me-2"></i>
Add Row
</button>
</div>
</div>
</div>

<hr style="margin-top: 20px;">
<div class="">
<h5 class="card-title mb-0">Add New Variant</h5>
</div>

<div>
<button type="button" class="btn btn-primary mt-4" id="add-variant">
<i class="ti ti-plus ti-xs me-2"></i>
Add Variant
</button>
</div>

<div class="d-flex align-content-center flex-wrap gap-4 mt-4">
<div class="d-flex gap-4 ms-auto">
<!-- Other elements go here -->
</div>
<button data-unique-id ="{{$unique_id}}" type="button" class="btn btn-primary mt-4" id="generate-variant">
Generate Variant
</button>
<input type="hidden" class="unique_id" value="{{$unique_id}}" name="">
</div>



<div class="variant-container mt-4">
<div class="variant-header">
<label for="default-variant">Variant</label>
<select id="default-variant" class="variant-select">
<!-- Options will be dynamically populated here -->
</select>
</div>
<!-- Variant boxes will be dynamically appended here -->
</div>

<div class="d-flex align-content-center flex-wrap gap-4">
<div class="d-flex gap-4 ms-auto">
<!-- Other elements go here -->
</div>
<button type="button" class=" custom-button mt-4" id="save-variants-button" style="display: none;">Save Product</button>

</div>
</div>
</div>




<!--         <div class="d-flex align-content-center flex-wrap gap-4">
<div class="d-flex gap-4 ms-auto">

</div>
<button type="submit" class="btn btn-primary mt-4">Submit</button>
</div> -->
</form>
</div>
</div>


</div>

</div>
</div>
</div>


@endsection
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script type="text/javascript">
$(document).ready(function() {
// Define the attribute options once
var attributeOptions = `
<option value="">Select Options</option>
@foreach($attribute as $list)
<option value="{{ $list->id }}">{{ $list->name }}</option>
@endforeach
`;

// Add new option dynamically
$('#add-option').click(function(e) {
e.preventDefault();

// Define the HTML structure for the new option fields
var newOption = `
<div data-repeater-item>
<div class="row mb-2">
<div class="mb-6 col-4">
<label class="form-label" for="form-repeater-1-1">Options</label>
<select class="select2 form-select" name="attributes_id[]" data-placeholder="">
${attributeOptions}
</select>
</div>

<div class="mb-6 col-6">
<label class="form-label invisible">Not visible</label>
<input type="text"  name="attributes_value[]" class="form-control" placeholder="Enter Value" />
</div>

<!-- Remove button -->
<div class="col-2 text-end mt-4">
<button type="button" class="btn btn-danger btn-sm remove-option">
<i class="ti ti-minus ti-xs"></i> Remove
</button>
</div>
</div>
</div>
`;

// Append the new option fields to the repeater list
$('[data-repeater-list="group-a"]').append(newOption);

// Initialize the select2 for dynamically added select elements
$('.select2').select2();
});

// Handle remove button click
$(document).on('click', '.remove-option', function(e) {
e.preventDefault();
$(this).closest('[data-repeater-item]').remove();
});
});
</script>






 <script type="text/javascript">
    $(document).ready(function() {
    if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    var unique_id = $('.Uniqueid').val();


    var files = e.target.files,
    filesLength = files.length;
    var formData = new FormData();

    // Append unique_id to FormData
    formData.append("unique_id", unique_id);

    for (var i = 0; i < filesLength; i++) {
    var f = files[i];
    formData.append("image[]", f); // Append the file to the FormData
    }

    // Send files to server
    $.ajax({
    url: "{{ url('admin/upload-product-images') }}", // Your endpoint for handling the upload
    type: 'POST',
    headers: {
    'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
    },
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
    console.log('Upload successful! Response:', response);
    },
    error: function(jqXHR, textStatus, errorThrown) {
    console.error('Upload failed: ', textStatus, errorThrown);
    }
    });

    // Display selected images
    for (var i = 0; i < filesLength; i++) {
    var fileReader = new FileReader();
    fileReader.onload = (function(e) {
    var file = e.target;
    $("<span class=\"pip\">" +
    "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
    "<br/><span class=\"remove\ remove-existing-image\">Remove image</span>" +
    "</span>").insertAfter("#files");
    $(".remove").click(function() {
    $(this).parent(".pip").remove();
    });
    });
    fileReader.readAsDataURL(files[i]);
    }
    });
    } else {
    alert("Your browser doesn't support the File API");
    }
    });
    </script>




    <script>
    $(document).ready(function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Handle type selection for existing variant rows
    $(document).on('change', '.type-selector', function() {
    var $dynamicFields = $(this).closest('.variant-row').find('.dynamic-fields');
    var selectedType = $(this).val();
    var $addRowButton = $(this).closest('.variant-row').find('.add-row');

    // Clear previous dynamic fields
    $dynamicFields.empty();

    if (selectedType === 'Text') {
    $dynamicFields.append(
    `<div class="dynamic-row">
    <div class="col-md-8 mt-2">
    <label class="form-label">Additional Input</label>
    <input type="text" class="form-control text-input" placeholder="Enter Additional Value" style="max-width:100% "/>
    </div>
    </div>`
    );
    $addRowButton.hide();
    } else if (selectedType === 'Colors') {
    $dynamicFields.append(
    `<div class="dynamic-row mt-2">
    <div class="col-md-4">
    <label class="form-label">Additional Input</label>
    <input type="text" class="form-control text-input" placeholder="Enter Additional Value" style="max-width:100%"/>
    </div>
    <div class="col-md-4">
    <label class="form-label">Color Picker</label>
    <input type="text" class="form-control color-code" placeholder="Color Code" readonly style="max-width:100%"/>
    </div>
    <input type="color" class="color-picker" />
    </div>`
    );

    // Add event listener for the color picker input to update the color code
    $dynamicFields.on('input', '.color-picker', function() {
    // Find the closest .dynamic-row and update the corresponding .color-code
    $(this).closest('.dynamic-row').find('.color-code').val(this.value);
    });


    $addRowButton.show();
    }
    });

    // Handle 'Add Row' button click
    $(document).on('click', '.add-row', function() {
    var selectedType = $(this).closest('.variant-row').find('.type-selector').val();
    var $dynamicFields = $(this).closest('.variant-row').find('.dynamic-fields');

    if (selectedType === 'Text') {
    $dynamicFields.append(
    `<div class="dynamic-row">
    <div class="col-md-8 mt-2">
    <label class="form-label">Additional Input</label>
    <input type="text" class="form-control text-input" placeholder="Enter Additional Value" style="max-width:100% "/>
    </div>
    <button type="button" class="remove-row mt-4">Remove</button>
    </div>`
    );
    } else if (selectedType === 'Colors') {
    $dynamicFields.append(
    `<div class="dynamic-row mt-2">
    <div class="col-md-4">
    <label class="form-label">Additional Input</label>
    <input type="text" class="form-control text-input additional_input" placeholder="Enter Additional Value" style="max-width:100%"/>
    </div>
    <div class="col-md-4">
    <label class="form-label">Color Picker</label>
    <input type="text" class="form-control color-code" placeholder="Color Code" readonly style="max-width:100%"/>
    </div>
    <input type="color" class="color-picker" />
    <button type="button" class="remove-row mt-4">Remove</button>
    </div>`
    );

    // Add event listener for the color picker input to update the color code
    $dynamicFields.on('input', '.color-picker', function() {
    // Find the closest .dynamic-row and update the corresponding .color-code
    $(this).closest('.dynamic-row').find('.color-code').val(this.value);
    });

    }
    });

    // Handle row removal
    $(document).on('click', '.remove-row', function() {
    $(this).closest('.dynamic-row').remove();
    });

    // Handle 'Remove Variant' button click
    $(document).on('click', '.remove-variant', function() {
    $(this).closest('.variant-row').remove();
    });

    // Handle 'Add Variant' button click
    $('#add-variant').click(function() {
    $('#variant-container').append(
    `<div class="variant-row">
    <div class="row align-items-end">
    <div class="mb-6 col-5">
    <label class="form-label" for="form-name">Name</label>
    <input type="text" class="form-control name-input" placeholder="Enter Name" />
    </div>
    <div class="mb-6 col-5">
    <label class="form-label" for="form-repeater">Type</label>
    <select class="form-control type-selector">
    <option value="">Please Select</option>
    <option value="Text">Text</option>
    <option value="Colors">Colors</option>
    </select>
    </div>
    <div class="mb-6 col-2">
    <button type="button" class="btn btn-danger remove-variant">
    Remove 
    </button>
    </div>
    </div>
    <div class="dynamic-fields row"></div>
    <div>
    <button type="button" class="btn btn-primary mt-4 add-row" style="display:none;">
    <i class="ti ti-plus ti-xs me-2"></i>
    Add Row
    </button>
    </div>
    </div>`
    );
    });

    // Handle 'Generate Variant' button click
    $('#generate-variant').click(function() {
    var variants = [];
    var unique_id = $(this).attr('data-unique-id');
    var isValid = true; // Flag to track validation

    $('.variant-row').each(function() {
    var name = $(this).find('.name-input').val(); 
    var type = $(this).find('.type-selector').val();
    var textInputs = [];
    var colorInputs = [];

    // Check if name or type is blank
    if (!name) {
    alert('Variant name cannot be blank!');
    isValid = false;
    return false; // Exit the each loop
    }

    if (!type) {
    alert('Variant type cannot be blank!');
    isValid = false;
    return false; // Exit the each loop
    }

    // Validate dynamic fields
    $(this).find('.dynamic-fields .dynamic-row').each(function() {
    var additionalInput = $(this).find('.text-input').val();
    var colorCode = $(this).find('.color-code').val();

    if (type === 'Text' && !additionalInput) {
    alert('Text input cannot be blank!');
    isValid = false;
    return false; // Exit the inner each loop
    }

    if (type === 'Colors' && (!additionalInput || !colorCode)) {
    alert('Both color name and color code are required!');
    isValid = false;
    return false; // Exit the inner each loop
    }

    if (type === 'Text') {
    textInputs.push(additionalInput);
    } else if (type === 'Colors') {
    colorInputs.push({
    additionalInput: additionalInput,
    colorCode: colorCode
    });
    }
    });

    // Stop further processing if validation failed
    if (!isValid) return false;

    variants.push({
    unique_id: unique_id,
    name: name,
    type: type,
    textInputs: textInputs,
    colorInputs: colorInputs
    });
    });

    // Stop the request if validation failed
    if (!isValid) {
    return;
    }

    // Send the variants data to the server
    $.ajax({
    url: "{{ url('admin/genrate-vriant') }}", // Update with your server endpoint
    type: 'POST',
    contentType: 'application/json',
    headers: {
    'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
    },
    data: JSON.stringify({ variants: variants }),
    success: function(response) {
    alert('Variants generated successfully!');
    generateVariant();
    },
    error: function(xhr, status, error) {
    alert('An error occurred: ' + error);
    }
    });
    });

    });
    </script>




    <script type="text/javascript">

    $(document).ready(function() {


    // Initially hide the variant container and save button
    $('.variant-container').hide();
    $('#save-variants-button').hide();

    // Listen for changes in the variant select dropdown
    $('#default-variant').on('change', function() {
    updateDefaultTag($(this).val());
    });

    // Listen for submit button click
    $('#save-variants-button').on('click', function() {
    submitVariantData();
    });

    // Handle inventory management dropdown change event
    $(document).on('change', '.InventoryManagement', function() {
    var $container = $(this).closest('.variant-box');
    var showQty = $(this).val() === 'Track inventory';
    $container.find('.qty-container').toggle(showQty);
    });

    $(document).on('change', '.status-toggle', function() {
    if ($(this).is(':checked')) {
    $('.status-toggle').not(this).prop('checked', false);
    $('.status-text').text('0');  // Update all status-text to '0'
    $(this).siblings('.status-text').text('1'); // Set only the current status to '1'
    } else {
    $(this).siblings('.status-text').text('0'); // If unchecked, set its status to '0'
    }
    });
    });

    function generateVariant() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var unique_id = $('.unique_id').val();

    $.ajax({
    url: "{{ url('admin/feach-vriant') }}",
    type: 'POST',
    headers: {
    'X-CSRF-TOKEN': csrfToken
    },
    data: {
    unique_id: unique_id
    },
    success: function(response) {
    if (response.variants) {
    var $select = $('#default-variant');
    var $container = $('.variant-container');
    var $button = $('#save-variants-button');

    $select.empty(); // Clear existing options
    $container.find('.variant-box').remove(); // Remove existing variant boxes

    response.variants.forEach(function(variant, index) {
    // Create a new variant box container
    var variantBox = 
    `<div class="variant-box" data-variant="${variant}">
    <div class="variant-title">
    <span id="variant-title-${index}">${variant}</span>

    <label class="switch" style="display:none;">
    <input type="checkbox" ${index === 0 ? 'checked' : ''} class="default-checkbox" data-variant="${variant}">
    <span class="slider"></span>
    </label>

    <label class="switch">
    <input type="checkbox" class="status-toggle" data-variant="${variant}" ${index === 0 ? 'checked' : ''}>
    <span class="slider"></span>
    <span class="status-text">${index === 0 ? '1' : '0'}</span>
    </label>
    </div>

    <div class="variant-content">
    <div class="variant-image">
    <div class="image-upload-placeholder" onclick="triggerImageUpload(${index}); return false;">
    <img src="https://demo.fleetcart.envaysoft.com/build/assets/placeholder_image.png" alt="Click to upload images" class="upload-placeholder-image">
    <p>Click to upload images</p>
    </div>
    <div class="image-previews" id="image-previews-${index}">
    <!-- Preview multiple images here -->
    </div>
    <input type="file" class="variant-image-upload" data-index="${index}" id="variant-image-${index}" style="display:none;" multiple accept="image/*">
    </div>

    <div class="variant-details">
    <div class="form-row">

    <div class="form-group">
    <label for="price-${index}">Price <span class="required">*</span></label>
    <input type="number" id="price-${index}" class="form-control small-input">
    </div>

    <div class="form-group">
    <label for="stock-availability-${index}">Stock Availability <span class="required">*</span></label>
    <select id="stock-availability-${index}" class="form-control small-input">
    <option value="In-Stock">In-Stock</option>
    <option value="Out-of-Stock">Out-of-Stock</option>
    </select>
    </div>


    </div>




    <div class="form-row">
    <div class="form-group">
    <label for="InventoryManagement-${index}">Inventory Management <span class="required">*</span></label>
    <select id="InventoryManagement-${index}" class="form-control small-input InventoryManagement">
    <option value="Dont-track-inventory">Don't track inventory</option>
    <option>Track inventory</option>
    </select>
    </div>
    <div class="form-group qty-container" style="display:none;">
    <label for="QTY-${index}">QTY <span class="required">*</span></label>
    <input type="text" id="QTY-${index}" class="form-control small-input">
    </div>
    </div>
    </div>
    </div>
    </div>
    `;

    // Append the new variant box to the container
    $container.append(variantBox);

    // Add option to the select dropdown
    $select.append('<option value="' + variant + '">' + variant + '</option>');

    // Add event listener for image file upload
    handleMultipleImagePreviews(index);
    });

    // Show the variant container and Save Variant button after all variants are generated
    $container.show();
    $button.show();
    }
    },
    error: function(xhr, status, error) {
    alert('An error occurred: ' + error);
    }
    });
    }

    // Function to trigger the image upload input field
    function triggerImageUpload(index) {
    $('#variant-image-' + index).click();
    }

    // Store images for each variant using an object
    let variantImages = {};

    // Function to handle multiple image file previews and upload via AJAX
    function handleMultipleImagePreviews(index) {
    $('#variant-image-' + index).on('change', function() {
    var files = this.files;
    var $previewContainer = $('#image-previews-' + index);

    // Check if images for this variant index already exist, if not, initialize the array
    if (!variantImages[index]) {
    variantImages[index] = [];
    }

    // Append new files to the existing images array for this variant
    for (var i = 0; i < files.length; i++) {
    variantImages[index].push(files[i]);
    }

    // Clear previous previews (optional if you want to reset previews on each change)
    $previewContainer.empty();

    // Loop through all images and display them as previews
    variantImages[index].forEach(function(file, i) {
    var reader = new FileReader();
    reader.onload = function(e) {
    var imagePreview = `
    <div class="image-preview">
    <img src="${e.target.result}" alt="Variant Image" width="100">
    <button class="remove-image" onclick="removeImage(${index}, ${i}, this);">×</button>
    </div>`;
    $previewContainer.append(imagePreview); // Append each image preview
    };
    reader.readAsDataURL(file);
    });
    });
    }

    // Function to remove an image from both the preview and the stored images array
    function removeImage(variantIndex, imageIndex, button) {
    // Remove the image from the array
    variantImages[variantIndex].splice(imageIndex, 1);

    // Remove the image preview from the DOM
    $(button).closest('.image-preview').remove();
    }

    function updateDefaultTag(selectedVariant) {
    $('.default-tag').hide(); // Hide all default tags
    $('.default-checkbox').prop('checked', false); // Uncheck all checkboxes

    // Show the default tag for the selected variant and check the corresponding checkbox
    $('.variant-box').each(function() {
    var variant = $(this).data('variant');
    if (variant === selectedVariant) {
    $(this).find('.default-tag').show();
    $(this).find('.default-checkbox').prop('checked', true);
    }
    });
    }

    function submitVariantData() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var unique_id = $('.unique_id').val();
    var formData = new FormData(); // Use FormData to handle file uploads
    var hasErrors = false;

    formData.append('unique_id', unique_id);

    // Loop through each variant and collect data
    $('.variant-box').each(function(index) {
    var variant = $(this).data('variant');
    var price = $(this).find('input[id^="price-"]').val();
    var stockAvailability = $(this).find('select[id^="stock-availability-"]').val();
    var isDefault = $(this).find('.default-checkbox').is(':checked');
    var isActive = $(this).find('.status-toggle').is(':checked') ? '1' : '0';
    var inventoryManagement = $(this).find('select[id^="InventoryManagement-"]').val();
    var qtyContainer = $(this).find('.qty-container'); // Get the qty container
    var qty = $(this).find('input[id^="QTY-"]').val();

    if ( !price || !stockAvailability|| !inventoryManagement) {
    alert('Please fill all required fields');
    hasErrors = true;
    return false; // Exit the .each() loop
    }

    // Check if QTY field is visible, then it must be filled
    if (qtyContainer.is(':visible') && (!qty || qty.trim() === '')) {
    alert('Please enter QTY when inventory tracking is enabled.');
    hasErrors = true;
    return false;
    }

    // Add variant data to FormData
    formData.append('variants[' + index + '][variant]', variant);
    formData.append('variants[' + index + '][price]', price);
    formData.append('variants[' + index + '][stockAvailability]', stockAvailability);
    formData.append('variants[' + index + '][isDefault]', isDefault);
    formData.append('variants[' + index + '][status]', isActive);
    formData.append('variants[' + index + '][inventoryManagement]', inventoryManagement);
    formData.append('variants[' + index + '][qty]', qty);

    // Append all images stored for this variant to FormData
    if (variantImages[index] && variantImages[index].length > 0) {
    variantImages[index].forEach(function(file) {
    formData.append('variants[' + index + '][images][]', file); // Append images to FormData
    });
    }
    });

    if (hasErrors) {
    return; // Stop the function if there are validation errors
    }

    // Send the data including images via AJAX
    $.ajax({
    url: "{{ url('admin/save-variants') }}", // Update with your controller route
    type: 'POST',
    headers: {
    'X-CSRF-TOKEN': csrfToken
    },
    processData: false,
    contentType: false,
    data: formData,
    success: function(response) {
    alert('Variants Value Save successfully');
    $("#productform").submit();
    },
    error: function(xhr, status, error) {
    alert('An error occurred: ' + error);
    }
    });
    }
    </script>




    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const addVariantCheckbox = document.getElementById('addVariantCheckbox');
    const variantSection = document.getElementById('variantSection');
    const saveProductSection = document.getElementById('saveProductSection');
    const productDetailsSection = document.getElementById('productDetailsSection');
    const quantityInput = document.getElementById('quantityInput');
    const priceInput = document.getElementById('priceInput');


    // Function to set required attributes
    const setRequired = (input, isRequired) => {
    if (isRequired) {
    input.setAttribute('required', 'required');
    } else {
    input.removeAttribute('required');
    }
    };

    // Show/Hide the variant section based on checkbox state
    addVariantCheckbox.addEventListener('change', function() {
    if (this.checked) {
    variantSection.style.display = 'block'; // Show variant section
    saveProductSection.style.display = 'none'; // Hide save product section
    productDetailsSection.style.display = 'none'; // Hide product details section
    // Clear input values
    quantityInput.value = '';
    priceInput.value = '';

    // Remove required attribute
    setRequired(priceInput, false);
    setRequired(discountInput, false);
    } else {
    variantSection.style.display = 'none'; // Hide variant section
    saveProductSection.style.display = 'flex'; // Show save product section
    productDetailsSection.style.display = 'flex'; // Show product details section
    // Add required attribute
    setRequired(priceInput, true);
    setRequired(discountInput, true);
    }
    });

    // Initially show the save product section and hide the variant section
    variantSection.style.display = 'none';
    saveProductSection.style.display = 'flex';
    });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
    var saveButton = document.querySelector(".save-product-btn");

    if (saveButton) {
    saveButton.addEventListener("click", function(event) {
    var fileInput = document.getElementById("files");

    if (fileInput.files.length === 0) {
    alert("Please upload at least one product image before saving.");
    event.preventDefault(); // Prevent form submission
    }
    });
    }
    });

    </script>






    <script type="text/javascript">

    $(document).ready(function() {
    // Initialize select2 plugin if needed
    $('#category-select').select2({
    placeholder: 'Select Category',
    allowClear: true
    });

    // Trigger when category is selected
    $('#category-select').on('change', function() {
    var categoryId = $(this).val(); // Get the selected category ID

    // Check if a category is selected
    if (categoryId) {
    $.ajax({
    url: "{{url('admin/category-change')}}", // Route to handle the AJAX request
    type: 'POST',
    data: {
    category_id: categoryId,
    _token: '{{ csrf_token() }}' // Laravel CSRF token
    },
    success: function(response) {
    if (response.success) {
    var subcategories = response.category;

    // Clear and populate the subcategory select box
    $('#subcategory-select').empty();
    $('#subcategory-select').append('<option value="">Select Subcategory</option>');

    $.each(subcategories, function(key, subcategory) {
    $('#subcategory-select').append('<option value="'+subcategory.id+'">'+subcategory.name+'</option>');
    });
    }
    },
    error: function(xhr, status, error) {
    console.error(error);
    }
    });
    } else {
    // Clear subcategory select box if no category is selected
    $('#subcategory-select').empty();
    $('#subcategory-select').append('<option value="">Select Subcategory</option>');
    }
    });
    });


    </script>




<script>
    function confirmDelete() {
    const selectedReason = document.getElementById('deleteReason').value;

    if (selectedReason) {
         Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            customClass: {
                confirmButton: 'swal-confirm-button-class'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                var categoryIdToDelete = window.categoryToDelete;
                $.ajax({
                    url: '{{ url("admin/deletecategory") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        categoryid: selectedReason,
                        categoryIdToDelete: categoryIdToDelete
                    },
                    success: function(response) {
                        var deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                        deleteModal.hide();
                        // Swal.fire(
                        //     'Deleted!',
                        //     'Your category has been deleted.',
                        //     'success'
                        // )
                        location.reload();
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'An error occurred during deletion.',
                            'error'
                        );
                    }
                });
            }
        });
    } else {
       
          Swal.fire({
          title: 'warning',
          text: 'You need to select a category for deletion!',
          icon: 'warning',
          confirmButtonText: 'OK',
          buttonsStyling: false,
          customClass: {
          confirmButton: 'btn btn-warning' // Optional: Add a class for styling the button
         }
     });
    }
}
 </script>















