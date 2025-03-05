@extends('admin.layouts.app')
@section('content')


   
 <div class="coustomcontainer container mt-2">
    <div>
        <h3>Home Page</h3>
        <form id="home-page-form" action="{{url('admin/store-coustom-section')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Main Selection -->

                <div class="col-md-12">
                    <label class="form-label" for="">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Title"required>
                   
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="main-select">Please Select</label>
                    <select id="main-select" name="section_type" class="form-control"required>
                        <option value="">Please Select</option>
                        <option value="Banner">Banner</option>
                        <option value="Visibilities">Visibilities</option>
                        <option value="category">Category</option>
                    </select>
                </div>

                <!-- Visibilities Section (Hidden by Default) -->
                <div class="col-md-12 mt-3 visibilities-section-container" style="display: none;">
                    <label class="form-label" for="visibilities-select">Please Select</label>
                    <select id="visibilities-select" name="visibilitieid" class="form-control">
                        <option value="">Please Select</option>
                        @foreach($visibilitie as $each)
                        <option value="{{ $each->id }}">{{ $each->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Category Section (Hidden by Default) -->
                <div class="col-md-12 mt-3 category-section-container" style="display: none;">
                    <label class="form-label" for="category-select">Category</label>
                    <select id="category-select" name="categoryid" class="form-control">
                        <option value="">Please Select</option>
                        @foreach($categories as $each)
                        <option value="{{ $each->id }}">{{ $each->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12 mt-3 category-section-container" style="display: none;">
                    <label class="form-label" for="subcategory-select">Subcategory</label>
                    <select id="subcategory-select" name="subcategoryid" class="form-control">
                        <option value="">Please Select</option>
                        @foreach($subcategory as $each)
                        <option value="{{ $each->id }}">{{ $each->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Banner Section (Hidden by Default) -->
                <div class="banner-section-container" style="display: none;">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="form-label" for="banner-select">Please Select</label>
                            <select class="form-control banner-type-select" name="banner_type">
                                <option value="">Please Select</option>
                                <option value="single">Single Banner</option>
                                <option value="combo">Combo Banner</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3 banner-container"></div>
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

    document.addEventListener("DOMContentLoaded", function () {
        const mainSelect = document.getElementById("main-select");
        const bannerTypeSelect = document.querySelector(".banner-type-select");
        const visibilitiesSectionContainer = document.querySelector(".visibilities-section-container");
        const categorySectionContainer = document.querySelectorAll(".category-section-container");
        const bannerSectionContainer = document.querySelector(".banner-section-container");
        const bannerContainer = document.querySelector(".banner-container");

        // Main select change handler
        mainSelect.addEventListener("change", function () {
            const selectedValue = this.value;

            visibilitiesSectionContainer.style.display = "none";
            categorySectionContainer.forEach((section) => section.style.display = "none");
            bannerSectionContainer.style.display = "none";

            if (selectedValue === "Visibilities") {
                visibilitiesSectionContainer.style.display = "block";
            } else if (selectedValue === "category") {
                categorySectionContainer.forEach((section) => section.style.display = "block");
            } else if (selectedValue === "Banner") {
                bannerSectionContainer.style.display = "block";
            }
        });

        // Banner type select change handler
        document.addEventListener("change", function (e) {
            if (e.target.classList.contains("banner-type-select")) {
                const selectedValue = e.target.value;

                // Clear the container before adding new content
                bannerContainer.innerHTML = "";

                if (selectedValue === "single") {
                    renderSingleBanner();
                } else if (selectedValue === "combo") {
                    renderComboBanner();
                }
            }
        });

        function renderSingleBanner() {
            bannerContainer.innerHTML = `
                <div class="col-md-12">
                    <label class="form-label" for="single-banner-image">Single Banner URL</label>
                    <input type="url" class="form-control" name="singlebanner_url" placeholder="URL">
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="single-banner-image">Upload Single Banner</label>
                    <input type="file" class="form-control single-banner-image" name="single_bannerimg" accept="image/*">
                    <div class="mt-3">
                        <img class="single-preview-image" src="${noImageUrl}" alt="Single Banner Preview" style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;">
                    </div>
                </div>
            `;

            attachImagePreview(".single-banner-image", ".single-preview-image");
        }

        function renderComboBanner() {
            bannerContainer.innerHTML = `
                <div class="col-md-6">
                    <label class="form-label" for="combo-banner-image-1">Upload First Banner</label>
                    <input type="file" class="form-control combo-banner-image-1" name="combo_bannerimg1" accept="image/*">
                    <label class="form-label" for="combo-banner-url-1">URL</label>
                    <input type="url" class="form-control" name="combobanner_url1" placeholder="URL">
                    <div class="mt-3">
                        <img class="combo-preview-image-1" src="${noImageUrl}" alt="First Banner Preview" style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="combo-banner-image-2">Upload Second Banner</label>
                    <input type="file" class="form-control combo-banner-image-2" name="combo_bannerimg2" accept="image/*">
                    <label class="form-label" for="combo-banner-url-2">URL</label>
                    <input type="url" class="form-control" name="combobanner_url2" placeholder="URL">
                    <div class="mt-3">
                        <img class="combo-preview-image-2" src="${noImageUrl}" alt="Second Banner Preview" style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;">
                    </div>
                </div>
            `;

            attachImagePreview(".combo-banner-image-1", ".combo-preview-image-1");
            attachImagePreview(".combo-banner-image-2", ".combo-preview-image-2");
        }

        function attachImagePreview(inputSelector, previewSelector) {
            const inputElement = document.querySelector(inputSelector);
            const previewElement = document.querySelector(previewSelector);

            inputElement.addEventListener("change", function (event) {
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewElement.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewElement.src = noImageUrl;
                }
            });
        }
    });
</script>

@endsection