@extends('layouts.passenger')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/style.default.css') }}" id="theme-stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        input::-webkit-calendar-picker-indicator {
            display: none;
        }

    </style>
@endsection
@section('content')
    <div class="slider-area ">
        <!-- Mobile Menu -->
        <div class="single-slider slider-height2 d-flex align-items-center"
            data-background="{{ asset('passenger-assets/img/hero/contact_hero.jpg') }}"
            style="background-image: url({{ asset('passenger-assets/img/hero/contact_hero.jpg') }});">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2> صفحة الشروط والاحكام</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('flash-message')

    <section class="contact-section">
        <div class="container">

            <div class="row mt-5">
                
                <div class="col-sm-12">

                    <div id="details" class="box ">
                        <div class="mb-5">
                            <h3>تفاصيل الشروط والاحكام</h3>
                        </div>
                        <div>
                            {!! \App\Setting::where('key', 'PRIVACY_PAGE_CONTENT')->first()->value !!}
                        </div>
                        <hr>
                    </div>
                </div>
                
            </div>

        </div>
    </section>
@endsection
