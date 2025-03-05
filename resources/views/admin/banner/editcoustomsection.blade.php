@extends('admin.layouts.app')
@section('content')





<div class="coustomcontainer mt-2">
<div>
<h3>Home Page</h3>
<form id="home-page-form" action="{{url('admin/update-coustom-section')}}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
<!-- Main Selection -->
<div class="col-md-12">
<label class="form-label" for="">Title</label>
<input type="text" name="title" class="form-control" placeholder="Title" value="{{ old('title', $result->title ?? '') }}">
</div>
<div class="col-md-12">
<label class="form-label" for="main-select">Please Select</label>
<select id="main-select" name="section_type" class="form-control">
<option value="">Please Select</option>
<option value="Banner" {{ old('section_type', $result->section_type ?? '') == 'Banner' ? 'selected' : '' }}>Banner</option>
<option value="Visibilities" {{ old('section_type', $result->section_type ?? '') == 'Visibilities' ? 'selected' : '' }}>Visibilities</option>
<option value="category" {{ old('section_type', $result->section_type ?? '') == 'category' ? 'selected' : '' }}>Category</option>
</select>
</div>
<input type="hidden" value="{{$result->id}}" name="id">
<!-- Visibilities Section -->
<div class="col-md-12 mt-3 visibilities-section-container" style="display: none;">
<label class="form-label" for="visibilities-select">Please Select</label>
<select id="visibilities-select" name="visibilitieid" class="form-control">
<option value="">Please Select</option>
@foreach($visibilitie as $each)
<option value="{{ $each->id }}" {{ old('visibilitieid', $result->visibilitieid ?? '') == $each->id ? 'selected' : '' }}>{{ $each->name }}</option>
@endforeach
</select>
</div>

<!-- Category Section -->
<div class="col-md-12 mt-3 category-section-container" style="display: none;">
<label class="form-label" for="category-select">Category</label>
<select id="category-select" name="categoryid" class="form-control">
<option value="">Please Select</option>
@foreach($categories as $each)
<option value="{{ $each->id }}" {{ old('categoryid', $result->categoryid ?? '') == $each->id ? 'selected' : '' }}>{{ $each->name }}</option>
@endforeach
</select>
</div>
<div class="col-md-12 mt-3 category-section-container" style="display: none;">
<label class="form-label" for="subcategory-select">Subcategory</label>
<select id="subcategory-select" name="subcategoryid" class="form-control">
<option value="">Please Select</option>
@foreach($subcategory as $each)
<option value="{{ $each->id }}" {{ old('subcategoryid', $result->subcategoryid ?? '') == $each->id ? 'selected' : '' }}>{{ $each->name }}</option>
@endforeach
</select>
</div>

<!-- Banner Section -->
<div class="banner-section-container" style="display: none;">
<div class="row mt-3">
<div class="col-md-12">
<label class="form-label" for="banner-select">Please Select</label>
<select class="form-control banner-type-select" name="banner_type">
<option value="">Please Select</option>
<option value="single" {{ old('banner_type', $result->banner_type ?? '') == 'single' ? 'selected' : '' }}>Single Banner</option>
<option value="combo" {{ old('banner_type', $result->banner_type ?? '') == 'combo' ? 'selected' : '' }}>Combo Banner</option>
</select>
</div>
</div>
<div class="row mt-3 banner-container">
<!-- Dynamically rendered banners -->
</div>
</div>
</div>

<!-- Submit Button -->
<div class="row mt-3">
<div class="col-md-12">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</div>
</form>
</div>
</div>
<script>
const noImageUrl = "https://st4.depositphotos.com/14953852/24787/v/450/depositphotos_247872612-stock-illustration-no-image-available-icon-vector.jpg";
const bannerPath = "{{ url('uploads/banner/website_banner/') }}/";

document.addEventListener("DOMContentLoaded", function () {
const mainSelect = document.getElementById("main-select");
const bannerTypeSelect = document.querySelector(".banner-type-select");
const visibilitiesSectionContainer = document.querySelector(".visibilities-section-container");
const categorySectionContainer = document.querySelectorAll(".category-section-container");
const bannerSectionContainer = document.querySelector(".banner-section-container");
const bannerContainer = document.querySelector(".banner-container");

const result = @json($result);

// Function to handle section visibility
function handleSectionVisibility(selectedValue) {
visibilitiesSectionContainer.style.display = "none";
categorySectionContainer.forEach((section) => section.style.display = "none");
bannerSectionContainer.style.display = "none";

if (selectedValue === "Visibilities") {
visibilitiesSectionContainer.style.display = "block";
} else if (selectedValue === "category") {
categorySectionContainer.forEach((section) => section.style.display = "block");
} else if (selectedValue === "Banner") {
bannerSectionContainer.style.display = "block";
if (result.banner_type === "single") renderSingleBanner();
else if (result.banner_type === "combo") renderComboBanner();
}
}

// Initial setup
handleSectionVisibility(result.section_type);

// Main select change handler
mainSelect.addEventListener("change", function () {
handleSectionVisibility(this.value);
});

// Banner type select change handler
document.addEventListener("change", function (e) {
if (e.target.classList.contains("banner-type-select")) {
const selectedValue = e.target.value;

bannerContainer.innerHTML = "";

if (selectedValue === "single") renderSingleBanner();
else if (selectedValue === "combo") renderComboBanner();
}
});

function renderSingleBanner() {
bannerContainer.innerHTML = `
<div class="col-md-12">
<label class="form-label">Single Banner URL</label>
<input type="text" class="form-control" name="singlebanner_url" value="${result.singlebanner_url || ''}" placeholder="URL">
</div>
<div class="col-md-12">
<label class="form-label">Upload Single Banner</label>
<input type="file" class="form-control single-banner-image" name="single_bannerimg" accept="image/*">
<div class="mt-3">
<img class="single-preview-image" src="${bannerPath + (result.single_bannerimg || noImageUrl)}" alt="Single Banner Preview" style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;">
</div>
</div>
`;

attachImagePreview(".single-banner-image", ".single-preview-image");
}

function renderComboBanner() {
bannerContainer.innerHTML = `
<div class="col-md-6">
<label class="form-label">Upload First Banner</label>
<input type="file" class="form-control combo-banner-image-1" name="combo_bannerimg1" accept="image/*">
<label class="form-label">URL</label>
<input type="text" class="form-control" name="combobanner_url1" value="${result.combobanner_url1 || ''}" placeholder="URL">
<div class="mt-3">
<img class="combo-preview-image-1" src="${bannerPath + (result.combo_bannerimg1 || noImageUrl)}" alt="First Banner Preview" style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;">
</div>
</div>
<div class="col-md-6">
<label class="form-label">Upload Second Banner</label>
<input type="file" class="form-control combo-banner-image-2" name="combo_bannerimg2" accept="image/*">
<label class="form-label">URL</label>
<input type="text" class="form-control" name="combobanner_url2" value="${result.combobanner_url2 || ''}" placeholder="URL">
<div class="mt-3">
<img class="combo-preview-image-2" src="${bannerPath + (result.combo_bannerimg2 || noImageUrl)}" alt="Second Banner Preview" style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;">
</div>
</div>
`;

attachImagePreview(".combo-banner-image-1", ".combo-preview-image-1");
attachImagePreview(".combo-banner-image-2", ".combo-preview-image-2");
}

function attachImagePreview(inputSelector, imageSelector) {
document.querySelector(inputSelector).addEventListener("change", function (e) {
const file = e.target.files[0];
const reader = new FileReader();

reader.onload = function (event) {
document.querySelector(imageSelector).src = event.target.result;
};

if (file) reader.readAsDataURL(file);
});
}
});
</script>

@endsection