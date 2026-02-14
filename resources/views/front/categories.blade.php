@extends('layouts.front.home')

<!-- title page -->
@section('title')
    <title>{{ __('products.categories_title') }}</title>
@endsection

<!-- custom page -->
@section('css')
@endsection

@section('content')

    <main>
        <section id="hero" class="hero-landing hero-home" style="background-image:url({{ asset('front/assets/images/men-girls-are-surfing.png') }});">
            <div class="container position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-xl-6">
                        <span class="eyebrow text-uppercase text-white-50"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up">{{ __('products.categories_eyebrow') }}</span>
                        <h1 class="display-5 fw-semibold mb-3 text-white"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="50">{{ __('products.categories_heading') }}</h1>
                        <p class="lead text-white-70 mb-4"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" data-aos-delay="100">
                            {{ __('products.categories_desc') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <nav class="hp-breadcrumb small mb-4">
                    <a href="{{ route('categories') }}" class="hp-crumb">{{ __('products.home') }}</a>
                    <i class="bi bi-chevron-right"></i>
                    <span class="hp-crumb text-body-secondary">{{ __('products.categories') }}</span>
                </nav>
                <div class="row g-4">
                    @isset($report['categories'])
                        @foreach ($report['categories'] as $g => $category)
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                <a class="hp-cat-card" href="{{ route('categoryProducts', [$category->id]) }}">
                                    <img src="{{ asset($category->img) }}" alt="{{ $category->name }}">
                                    <span>{{ $category->name }}</span>
                                </a>
                            </div>
                        @endforeach
                    @endisset
                </div>
            </div>
        </section>
    </main>
        
@endsection

<!-- custom js -->
@section('script')
<script>
    $(function(){
        $('#nav-categories').addClass('active');
    });
</script>
@endsection
