

@extends('admin.layouts.app')
@section('content')
<?php
$unique_id = $products->unique_id;

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
<h4 class="mb-1">Edit Product</h4>

</div>

</div>

<div class="row">
<form id="productform" action="{{url('admin/product-update')}}" method="POST"
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
<label class="form-label" for="ecommerce-product-name">Name<span class="required">*</span></label>
<input
type="text" value="{{$products->name}}"
class="form-control"
id="ecommerce-product-name"
placeholder="Product title"
name="name"
aria-label="Product title" required />
<input type="hidden"class="product-id" name="product_id" value="{{$products->id}}" >
<input type="hidden"class="product-id" name="producttype" value="{{ request('type') }}">


</div>
<div class="row mb-6  mt-4">
<div class="col">
<label class="form-label" for="ecommerce-product-sku">Main Category<span class="required">*</span></label>

<select id="category-select" class="select2 form-select" name="categories_id" data-placeholder="Select Category" required>
<option value="">Select Category</option>
@foreach($categories as $category)
<option value="{{ $category->id }}" 
@if($category->id == $products->categories_id) selected @endif>
{{ $category->name }}
</option>
@endforeach
</select>
</div>
<div class="col">
<label class="form-label" for="ecommerce-product-barcode">Subcategory<span class="required">*</span></label>
<select id="subcategory-select" name="subcategories_id" class=" form-select" data-placeholder="" required>
<option value="">Select Subcategory</option>
@foreach($subcategories as $subcategory)
<option value="{{ $subcategory->id }}" 
@if($subcategory->id == $products->subcategories_id) selected @endif>
{{ $subcategory->name }}
</option>
@endforeach
</select>
</div>


<div class="col">
<label class="form-label" for="ecommerce-product-sku">Brand<span class="required">*</span></label>

<select id="brand-select" class="select2 form-select" name="brand_id" data-placeholder="Select Brand" required>
<option value="">Select Brand</option>
@foreach($brand as $brandlist)
<option value="{{ $brandlist->id }}" 
@if($brandlist->id == $products->brand_id) selected @endif>
{{ $brandlist->name }}
</option>
@endforeach
</select>
</div>


</div>

<div class="row mb-6  mt-4">

<div class="col">
<label class="form-label" for="ecommerce-product-barcode">Discount(%)</label>
<input
type="number"
class="form-control"
id="" value="{{$products->discount}}"
placeholder=""
name="discount" max="99"
oninput="this.value = this.value.slice(0, 2)"
aria-label="Price"  />
</div>
<div class="col">
<label class="form-label" for="ecommerce-product-sku">Tag</label>

<select id="brand-select" class="select2 form-select" name="visibilityid" data-placeholder="Select Tag">
<option value="">Select Tags</option>
@foreach($product_tag as $list)
<option value="{{ $list->id }}" 
@if($list->id == $products->visibilityid) selected @endif>
{{ $list->name }}
</option>
@endforeach
</select>
</div>


</div>                  


@if(!isset($products->variant_id) || empty($products->variant_id))
<div class="row mb-6  mt-4">



<div class="col">
<label class="form-label" for="ecommerce-product-sku">Quantity<span class="required">*</span></label>
<input
type="text"
class="form-control"
id="" name="qty"
value="{{$products->qty}}"
placeholder="Quantity"
name=""
aria-label="Quantity" / >
</div>
<div class="col">
<label class="form-label" for="ecommerce-product-barcode">Price<span class="required">*</span></label>
<input
type="text"
class="form-control"
id="" value="{{$products->price}}"
placeholder="Price"
name="price"
aria-label="Price"  />
</div>








</div>

@endif




@foreach($taxes as $tax)
<div class="row mb-2 mt-4">
<div class="col">
<label class="form-label" for="tax_{{ $loop->index }}">{{ $tax->tax_name }}<span class="required">*</span></label>
<input type="hidden" name="tax_id[]" value="{{ $tax->tax_id }}" />
<input
type="number"
class="form-control"
name="rate[]"
value="{{ $taxRates[$tax->tax_id]->rate ?? '' }}" 
required />
</div>
<div class="col">
<label class="form-label" for="rate_{{ $loop->index }}">Rate Type<span class="required">*</span></label>
<select class="select2 form-select" name="ratetype[]" required>
<option value="">Select Rate</option>
<option value="flat" {{ isset($taxRates[$tax->tax_id]) && $taxRates[$tax->tax_id]->ratetype == 'flat' ? 'selected' : '' }}>Flat</option>
<option value="percentage" {{ isset($taxRates[$tax->tax_id]) && $taxRates[$tax->tax_id]->ratetype == 'percentage' ? 'selected' : '' }}>Percentage</option>
</select>
</div>
</div>
@endforeach

<!-- Description -->
<div>
<label class="mb-1"> Short Description</label>

<textarea 
class="form-control "
id="shorteditor" name="short_des" value="{{$products->short_des}}"
placeholder="Description"
name=""
>{{$products->short_des}}</textarea required>

</div>
<!-- Description -->
<div>
<label class="mb-1">Description</label>

<textarea 
class="form-control "
id="editor" name="description" value="{{$products->description}}"
placeholder="Description"
name=""
>{{$products->description}}</textarea required>

</div>
</div>
</div>
</div>
<div class="card mb-12 mt-4" style="padding: 30px;">
<div class="card-header d-flex justify-content-between align-items-center">
<h3 class="mb-0 card-title">Product Images<span class="required">*</span></h3>
</div>
<h5 class="mb-0 card-title">Upload Product Images</h5>
<div class="field" align="left">
<input type="file" id="files" name="image[]" multiple style="display: none;" />
<label for="files" class="upload-label">Upload Images</label>
</div>

<!-- Display existing images -->
<div class="existing-images">
@foreach($productsimages as $image)
<span class="pip">
<img class="imageThumb" src="{{ url('uploads/product/' . $image->image) }}" title="{{ $image->image }}" />
<br/><span class="remove-existing" style="cursor: pointer;" data-image-id="{{ $image->id }}" data-imageproductid="{{ $image->product_id }}">Remove image</span>
</span>
@endforeach
</div>
</div>

<div class="card mb-6 mt-4">
<div class="card-header">
<h5 class="card-title mb-0">Attributes<span class="required">*</span></h5>
</div>
<div class="card-body">

<div data-repeater-list="group-a">
@foreach($attributes as $attr)
<div data-repeater-item>
<div class="row">
<div class="mb-6 col-4">
<label class="form-label" for="form-repeater-1-1">Options</label>
<select id="form-repeater-1-1" name="attributes_id[]" class="select2 form-select" required>
<option value="">Select Options</option>
@foreach($attributeOptions as $option)
<option value="{{ $option->id }}" {{ $option->id == $attr->attributes_id ? 'selected' : '' }}>
{{ $option->name }}
</option>
@endforeach
</select>
</div>

<div class="mb-6 col-8">
<label class="form-label invisible" for="form-repeater-1-2">Not visible</label>
<input type="text" name="attributes_value[]" id="form-repeater-1-2" class="form-control" placeholder="Enter Value" value="{{ $attr->attributes_value }}" />
</div>

</div>
</div>
@endforeach
</div>

<!-- Add more options dynamically -->
<div>
<button type="button" class="btn btn-primary mt-4" id="add-option">
<i class="ti ti-plus ti-xs me-2"></i>
Add another option
</button>
</div>

@if(!isset($products->variant_id) || empty($products->variant_id))
<div class="d-flex justify-content-end">
<button type="submit" style="background-color: #7367f0;" class="custom-button  mt-4 update-product-btn" id="">
Update Product
</button>
</div>
@endif

@if($products->variant_id)
<div class="card mb-6 mt-4">
<div class="card-header">
<h5 class="card-title mb-0">Variant</h5>
</div>
<div class="card-body">

<div id="variant-container">
<!-- Initial Variant Row -->
<div class="variant-row">

<div class="dynamic-fields row"></div>

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
<input type="hidden" class="unique_id" value="{{$unique_id}}" name="unique_id">
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
<button type="button" class=" custom-button  mt-4  " id="save-variants-button" style="display: none;">Update Product</button>

</div>
</div>
</div>
@endif



<!--       <div class="d-flex align-content-center flex-wrap gap-4">
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
var attributeOptions = `
<option value="">Select Options</option>
@foreach($attributeOptions as $option)
<option value="{{ $option->id }}">{{ $option->name }}</option>
@endforeach
`;

// Add new option dynamically
$('#add-option').click(function(e) {
e.preventDefault();

var newOption = `
<div data-repeater-item>
<div class="row mb-2">
<div class="mb-6 col-4">
<label class="form-label" for="form-repeater-1-1">Options</label>
<select class="select2 form-select" name="attributes_id[]" required>
${attributeOptions}
</select>
</div>

<div class="mb-6 col-6">
<label class="form-label invisible">Not visible</label>
<input type="text" name="attributes_value[]" class="form-control" placeholder="Enter Value" />
</div>

<div class="col-2 text-end mt-4 ">
<button type="button" class="btn btn-danger btn-sm remove-option">
<i class="ti ti-minus ti-xs"></i> Remove
</button>
</div>
</div>
</div>
`;

$('[data-repeater-list="group-a"]').append(newOption);
$('.select2').select2(); // Initialize select2 for dynamically added select
});

// Handle remove option
$(document).on('click', '.remove-option', function(e) {
e.preventDefault();
$(this).closest('[data-repeater-item]').remove();
});
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
url: "{{ url('admin/category-change') }}", // Route to handle the AJAX request
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
$('#subcategory-select').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
});

// Automatically select the subcategory if it's set
var selectedSubcategoryId = '{{ $products->subcategories_id }}';
if (selectedSubcategoryId) {
$('#subcategory-select').val(selectedSubcategoryId);
}
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

// Trigger the change event on page load to populate the subcategories in edit mode
$('#category-select').trigger('change');
});

</script>


<script type="text/javascript">
$(document).ready(function() {
// Initialize select2 plugin if needed
$('#brand-select').select2({
placeholder: 'Select Brand',
allowClear: true
});
</script>






<script type="text/javascript">
$(document).ready(function() {
// Handle dynamic file upload preview
if (window.File && window.FileList && window.FileReader) {
$("#files").on("change", function(e) {
var files = e.target.files,
filesLength = files.length;
for (var i = 0; i < filesLength; i++) {
var f = files[i];
var fileReader = new FileReader();
fileReader.onload = (function(e) {
var file = e.target;
$("<span class=\"pip\">" +
"<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
"<br/><span class=\"remove\ remove-existing-image\">Remove image</span>" +
"</span>").insertAfter("#files");
$(".remove").click(function(){
$(this).parent(".pip").remove();
});
});
fileReader.readAsDataURL(f);
}
});
} else {
alert("Your browser doesn't support File API");
}

$(document).on("click", ".remove-existing", function() {
var imageId = $(this).data("image-id");
var imageproductid = $(this).data("imageproductid");


var $imageElement = $(this).parent(".pip");



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
$.ajax({
url: '/admin/delete-product-image', // Adjust URL as needed
type: 'POST',
data: {
_token: "{{ csrf_token() }}", // CSRF token for security
image_id: imageId,
imageproductid:imageproductid
},
success: function(response) {
if (response.success) {
$imageElement.remove();

Swal.fire({
title: 'Success',
text: 'Your image has been deleted!',
icon: 'success',
confirmButtonText: 'OK',
buttonsStyling: false,
customClass: {
confirmButton: 'btn btn-success' // Optional: Add a class for styling the button
}
});
} else {
Swal.fire(
"Error!",
"Failed to delete the image. Please try again.",
"error"
);
}
},
error: function() {
Swal.fire(
"Error!",
"An error occurred. Please try again.",
"error"
);
}
});
}
});
});
});
</script>



<script>
$(document).ready(function() {
var csrfToken = $('meta[name="csrf-token"]').attr('content');
var productId = $('.product-id').val(); // Assuming you have a hidden input for product ID

// Fetch existing variants on document ready
$.ajax({
url: `/admin/get-product-variants/${productId}`, // Update with your server endpoint
type: 'GET',
headers: {
'X-CSRF-TOKEN': csrfToken
},
success: function(response) {
if (response.variants) {
Object.values(response.variants).forEach(function(variant) {
appendVariantRow(variant);
});
}
},
// error: function(xhr, status, error) {
//     alert('An error occurred while fetching variants: ' + error);
// }
});

function appendVariantRow(variant) {
var $variantRow = $(`
<div class="variant-row mb-4 p-3 border rounded">
<div class="row">
<div class="mb-6 col-4">
<label class="form-label" for="form-name">Name</label>
<input type="text" class="form-control name-input" placeholder="Enter Name" value="${variant.name}" />
</div>
<div class="mb-6 col-4">
<label class="form-label" for="form-repeater">Type</label>
<select class="form-control type-selector">
<option value="Text" ${variant.type === 'Text' ? 'selected' : ''}>Text</option>
<option value="Colors" ${variant.type === 'Colors' ? 'selected' : ''}>Colors</option>
</select>
</div>
<div class="mb-6 col-4 d-flex align-items-end">
<button type="button" class="btn btn-danger remove-variant">Remove Variant</button>
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
`);

// Append dynamic fields based on the variant type
if (variant.type === 'Text') {
variant.textInputs.forEach(function(input) {
addTextInput($variantRow.find('.dynamic-fields'), input);
});
} else if (variant.type === 'Colors') {
variant.textInputs.forEach(function(input, index) {
var colorInput = variant.colorInputs[index] || '';
addColorInput($variantRow.find('.dynamic-fields'), input, colorInput);
});
}

// Append the new variant row to the variant container
$('#variant-container').append($variantRow);

// Handle type selection for existing variant rows
$variantRow.find('.type-selector').on('change', function() {
handleTypeChange($(this));
});
}

function addTextInput($dynamicFields, value) {
$dynamicFields.append(`
<div class="dynamic-row mb-3">
<div class="col-sm-8">
<label class="form-label">Additional Input</label>
<input type="text" class="form-control text-input" placeholder="Enter Additional Value" value="${value}" style="max-width:100%"/>
</div> 
<div class="col-sm-2"> 
<button type="button" class="remove-row mt-4">Remove</button>
</div>
</div>
`);
}

function addColorInput($dynamicFields, textValue, colorValue) {
$dynamicFields.append(`
<div class="dynamic-row mb-2 d-flex align-items-end mt-2" >
<div class="col-md-4">
<label class="form-label">Additional Input</label>
<input type="text" class="form-control text-input" placeholder="Enter Additional Value" value="${textValue}" />
</div>
<div class="col-md-4"> 
<label class="form-label">Color Picker</label>
<input type="text" class="form-control color-code" value="${colorValue}" readonly />
</div>
<input type="color" class="color-picker" value="${colorValue}" />
<button type="button" class="remove-row btn btn-danger ms-2">Remove</button>
</div>
`);

// Update color code when color picker changes
$dynamicFields.on('input', '.color-picker', function() {
// Find the closest .dynamic-row and update the corresponding .color-code
$(this).closest('.dynamic-row').find('.color-code').val(this.value);
});
}

function handleTypeChange($typeSelector) {
var $dynamicFields = $typeSelector.closest('.variant-row').find('.dynamic-fields');
var selectedType = $typeSelector.val();

// Get existing inputs
var existingTextInputs = $dynamicFields.find('.text-input').map(function() {
return $(this).val();
}).get();

var existingColorCodes = $dynamicFields.find('.color-picker').map(function() {
return $(this).val();
}).get();

// Clear previous dynamic fields
$dynamicFields.empty();

if (selectedType === 'Text') {
existingTextInputs.forEach(function(input) {
addTextInput($dynamicFields, input);
});
} else if (selectedType === 'Colors') {
existingTextInputs.forEach(function(input, index) {
var colorCode = existingColorCodes[index] || ''; // Use existing color codes
addColorInput($dynamicFields, input, colorCode);
});
}

// Show the add row button only if the current type is Colors
if (selectedType === 'Colors') {
$typeSelector.closest('.variant-row').find('.add-row').show();
} else {
$typeSelector.closest('.variant-row').find('.add-row').hide();
}
}

// Handle 'Add Row' button click
$(document).on('click', '.add-row', function() {
var selectedType = $(this).closest('.variant-row').find('.type-selector').val();
var $dynamicFields = $(this).closest('.variant-row').find('.dynamic-fields');

if (selectedType === 'Text') {
addTextInput($dynamicFields, '');
} else if (selectedType === 'Colors') {
addColorInput($dynamicFields, '', '');
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
appendVariantRow({ name: '', type: '', textInputs: [], colorInputs: [] });
});

// Handle 'Generate Variant' button click
$('#generate-variant').click(function() {
var variants = [];
var unique_id = $(this).attr('data-unique-id');
var productId = $('.product-id').val();

$('.variant-row').each(function() {
var name = $(this).find('.name-input').val();
var type = $(this).find('.type-selector').val();
var textInputs = [];
var colorInputs = [];

$(this).find('.dynamic-fields .dynamic-row').each(function() {
var additionalInput = $(this).find('.text-input').val();
var colorCode = $(this).find('.color-code').val();

if (type === 'Text') {
textInputs.push(additionalInput);
} else if (type === 'Colors') {
colorInputs.push({
additionalInput: additionalInput,
colorCode: colorCode
});
}
});

variants.push({
unique_id: unique_id,
name: name,
type: type,
productId:productId,
textInputs: textInputs,
colorInputs: colorInputs
});
});

// Send the variants data to the server
$.ajax({
url: "{{ url('admin/updategenratevriant') }}", // Update with your server endpoint
type: 'POST',
contentType: 'application/json',
headers: {
'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
},
data: JSON.stringify({ variants: variants }),
success: function(response) {
generateVariant();
alert('Variants generated successfully!');
// Optionally, you can refresh the variant list
},
// error: function(xhr, status, error) {
//     alert('An error occurred: ' + error);
// }
});
});
});
</script>







<script>
$(document).ready(function() {
generateVariant();

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

$select.empty();
$container.find('.variant-box').remove();

response.variants.forEach(function(variant, index) {
var variantValue = response.variantsValues[index] || {};
var images = variantValue.images ? variantValue.images.split(',') : [];

var variantBox = `<div class="variant-box" data-variant="${variant}">
<div class="variant-title">
<span id="variant-title-${index}">${variant}</span>

<label class="switch" style="display:none;">
<input type="checkbox" ${variantValue.isdefault ? 'checked' : ''} class="default-checkbox" data-variant="${variant}">
<span class="slider"></span>
</label>
<label class="switch">
<input type="checkbox" class="status-toggle" data-variant="${variant}" ${variantValue.status === '1' ? 'checked' : ''}>
<span class="slider"></span>
<span class="status-text">${variantValue.status === '1' ? '1' : '0'}</span>
</label>
</div>
<div class="variant-content">
<div class="variant-image">
<div class="image-upload-placeholder" onclick="triggerImageUpload(${index}); return false;">
<img src="https://demo.fleetcart.envaysoft.com/build/assets/placeholder_image.png" alt="Click to upload images" class="upload-placeholder-image">
<p>Click to upload images</p>
</div>
<div class="image-previews" id="image-previews-${index}">${images.map(img => `<div class="image-preview"><img src="${img}" alt="Variant Image" width="100"><button class="remove-image" onclick="removeImage(this);">×</button></div>`).join('')}</div>
<input type="file" class="variant-image-upload" data-index="${index}" id="variant-image-${index}" style="display:none;" multiple accept="image/*">
</div>
<div class="variant-details">
<div class="form-row">

<div class="form-group"><label for="price-${index}">Price <span class="required">*</span></label><input type="number" id="price-${index}" class="form-control small-input" value="${variantValue.price || ''}"></div>
<div class="form-group"><label for="stock-availability-${index}">Stock Availability <span class="required">*</span></label><select id="stock-availability-${index}" class="form-control small-input"><option ${variantValue.stock_availability === 'In-Stock' ? 'selected' : ''}>In-Stock</option><option ${variantValue.stock_availability === 'Out-of-Stock' ? 'selected' : ''}>Out-of-Stock</option></select></div>
</div>

<div class="form-row">
<div class="form-group"><label for="InventoryManagement-${index}">Inventory Management <span class="required">*</span></label><select id="InventoryManagement-${index}" class="form-control small-input InventoryManagement"><option ${variantValue.inventory_management === "Dont-track-inventory" ? 'selected' : ''}>Don't track inventory</option><option ${variantValue.inventory_management === 'Track inventory' ? 'selected' : ''}>Track inventory</option></select></div>
<div class="form-group qty-container" style="display:${variantValue.inventory_management === 'Track inventory' ? 'block' : 'none'};"><label for="QTY-${index}">QTY <span class="required">*</span></label><input type="text" id="QTY-${index}" class="form-control small-input" value="${variantValue.qty || ''}"></div>
</div>
</div>
</div>
</div>`;

$container.append(variantBox);
$select.append('<option value="' + variant + '">' + variant + '</option>');
handleMultipleImagePreviews(index);
});

$container.show();
$button.show();
}
},
// error: function(xhr, status, error) {
//     alert('An error occurred: ' + error);
// }
});
}


// Function to trigger the image upload input field
function triggerImageUpload(index) {
$('#variant-image-' + index).click();
}


let variantImages = {};

function handleMultipleImagePreviews(index) {
$('#variant-image-' + index).on('change', function () {
var files = this.files;
var $previewContainer = $('#image-previews-' + index);

// Check if images for this variant index already exist; if not, initialize the array
if (!variantImages[index]) {
variantImages[index] = [];
}

// Append new files to the existing images array for this variant
for (var i = 0; i < files.length; i++) {
variantImages[index].push(files[i]);
}

// Loop through only the new files and display them as previews
Array.from(files).forEach(function (file, i) {
var reader = new FileReader();
reader.onload = function (e) {
var imagePreview = `
<div class="image-preview" data-image-index="${variantImages[index].length - files.length + i}">
<img src="${e.target.result}" alt="Variant Image" width="100">
<button class="remove-image" data-variant-index="${index}" data-image-index="${variantImages[index].length - files.length + i}">×</button>
</div>`;
$previewContainer.append(imagePreview); // Append the new image preview
};
reader.readAsDataURL(file);
});
});

// Attach event listener for dynamically added "remove" buttons
$(document).on('click', '.remove-image', function (e) {
e.preventDefault();
var variantIndex = $(this).data('variant-index');
var imageIndex = $(this).data('image-index');
removeImage(variantIndex, imageIndex, this);
});
}

// Function to remove an image preview
function removeImage(variantIndex, imageIndex, button) {
// Check if the variantIndex exists in the variantImages array
if (variantImages[variantIndex]) {
// Remove the specific image from the array
variantImages[variantIndex].splice(imageIndex, 1);
}

// Remove the image preview from the DOM
$(button).closest('.image-preview').remove();

// Re-index the remaining previews
var $previewContainer = $('#image-previews-' + variantIndex);
$previewContainer.children('.image-preview').each(function (i) {
$(this).find('.remove-image')
.attr('data-image-index', i); // Update the image index dynamically
});
}

// Function to trigger the image upload input field
function triggerImageUpload(index) {
$('#variant-image-' + index).click();
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
var productId = $('.product-id').val();

var formData = new FormData();
var hasErrors = false;

formData.append('unique_id', unique_id);
formData.append('productId', productId);

$('.variant-box').each(function(index) {
var variant = $(this).data('variant');
var price = $(this).find('input[id^="price-"]').val();
var stockAvailability = $(this).find('select[id^="stock-availability-"]').val();
var isDefault = $(this).find('.default-checkbox').is(':checked');
var isActive = $(this).find('.status-toggle').is(':checked') ? '1' : '0';
var inventoryManagement = $(this).find('select[id^="InventoryManagement-"]').val();
var qtyContainer = $(this).find('.qty-container'); // Get the qty container
var qty = $(this).find('input[id^="QTY-"]').val();

if (!price || !stockAvailability || !inventoryManagement) {
alert('Please fill all required fields');
hasErrors = true;
return false;
}

// Check if QTY field is visible, then it must be filled
if (qtyContainer.is(':visible') && (!qty || qty.trim() === '')) {
alert('Please enter QTY when inventory tracking is enabled.');
hasErrors = true;
return false;
}

formData.append(`variants[${index}][variant]`, variant);
formData.append(`variants[${index}][price]`, price);
formData.append(`variants[${index}][stockAvailability]`, stockAvailability);
formData.append(`variants[${index}][isDefault]`, isDefault);
formData.append(`variants[${index}][status]`, isActive);
formData.append(`variants[${index}][inventoryManagement]`, inventoryManagement);
formData.append(`variants[${index}][qty]`, qty);

// Append existing images to FormData
var existingImages = $(this).find('.existing-images').data('images'); // Ensure this data is available in the HTML
if (existingImages) {
existingImages.split(',').forEach(function(image) {
formData.append(`variants[${index}][existingImages][]`, image);
});
}

// Append new images
if (variantImages[index] && variantImages[index].length > 0) {
variantImages[index].forEach(function(file) {
formData.append(`variants[${index}][images][]`, file);
});
}
});

if (hasErrors) {
return;
}

$.ajax({
url: "{{ url('admin/update-variants') }}",
type: 'POST',
headers: {
'X-CSRF-TOKEN': csrfToken
},
processData: false,
contentType: false,
data: formData,
success: function(response) {
$("#productform").submit();
},
error: function(xhr, status, error) {
alert('An error occurred: ' + error);
}
});
}




</script>


<script>
document.addEventListener("DOMContentLoaded", function() {
var saveButton = document.querySelector(".update-product-btn");

if (saveButton) {
saveButton.addEventListener("click", function(event) {
var fileInput = document.getElementById("files");
var existingImages = document.querySelectorAll(".existing-images .pip");

if (fileInput.files.length === 0 && existingImages.length === 0) {
alert("Please upload at least one product image before saving.");
event.preventDefault(); // Prevent form submission
}
});
}
});

</script>

