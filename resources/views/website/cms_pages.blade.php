@extends('website.layout.app')
@section('content')

    <main class="main">
     
      <section class="section-box shop-template mt-2">
        <div class="container">
          <div class="row">
            <div class="col-lg-10 mx-auto page-content">
              <h2 class="text-center mb-20">{{ $cms_translation->title ?? $cms_data->title }}</h2>

              <p> {!! $cms_translation->description ?? $cms_data->des !!}</p> 
            
            </div>
          </div>
        </div>
      </section>
     
     
    </main>
 @endsection
