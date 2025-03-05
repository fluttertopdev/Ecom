@extends('admin.layouts.app')
@section('content')



<?php
  if (Session()->has('admin_locale')) {
        $langCode = Session()->get('admin_locale');
    }
    else {
        $langCode = config('app.fallback_locale');
    }

?>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="app-ecommerce">
            <!-- Add Product -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1">Product Translation</h4>
                </div>
            </div>

   <div class="row">
    <form id="productform" action="{{ route('product.update.translate', $Product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Language Selector -->
        <div class="col-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                   <div class="form-group mb-4">
                        <label class="form-label" for="language-selector">Select a language</label>
                        <select class="form-control" id="language-selector">
                            <option value="" disabled>Select a language</option>
                            @foreach($languages as $row)
                                <option value="{{ $row->code }}" {{ $row->code == $langCode ? 'selected' : '' }}>
                                    {{ $row->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Translations -->
                    @foreach ($languages as $language)
                        <div class="translation-section border rounded p-4 mb-4 {{ $language->code == $langCode ? '' : 'd-none' }}" id="translation-{{ $language->code }}">
                            <!-- Title Section -->
                            <div class="form-group mb-4">
                                <label for="translated-name-{{ $language->code }}" class="form-label">
                                    Title ({{ $language->name }})
                                </label>
                                <input type="hidden" name="translation_id[]" value="{{ $language->details->id ?? null }}">
                                <input type="hidden" name="language_code[]" value="{{ $language->code }}">
                                <input type="text" class="form-control" id="translated-name-{{ $language->code }}" name="name[]" required value="{{ $language->details->name ?? '' }}">
                            </div>

                            <!-- Description Section -->
                            <div class="form-group mb-4">
                                <label for="translated-description-{{ $language->code }}" class="form-label">
                                    Description ({{ $language->name }})
                                </label>
                                <textarea class="form-control" id="translated-description-{{ $language->code }}" name="description[]" rows="4" required>{{ old('description.' . $loop->index, strip_tags($language->details->description ?? '')) }}</textarea>
                            </div>

                            <!-- Short Description Section -->
                            <div class="form-group mb-4">
                                <label for="translated-short-description-{{ $language->code }}" class="form-label">
                                    Short Description ({{ $language->name }})
                                </label>
                                <textarea class="form-control" id="translated-short-description-{{ $language->code }}" name="short_description[]" rows="4" required>{{ old('short_description.' . $loop->index, strip_tags($language->details->short_description ?? '')) }}</textarea>
                            </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const languageSelector = document.getElementById('language-selector');
        const translationSections = document.querySelectorAll('.translation-section');

        // Ensure the correct translation section is visible when the page loads
        const selectedLanguage = languageSelector.value;
        if (selectedLanguage) {
            translationSections.forEach(section => {
                if (section.id === 'translation-' + selectedLanguage) {
                    section.classList.remove('d-none');
                } else {
                    section.classList.add('d-none');
                }
            });
        }

        // Handle language change
        languageSelector.addEventListener('change', function () {
            const selectedLanguage = this.value;

            // Hide all translation sections
            translationSections.forEach(section => section.classList.add('d-none'));

            // Show the selected translation section
            const selectedSection = document.getElementById('translation-' + selectedLanguage);
            if (selectedSection) {
                selectedSection.classList.remove('d-none');
            }
        });
    });
</script>

@endsection
