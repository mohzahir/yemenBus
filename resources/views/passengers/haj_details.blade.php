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
                            <h2> تفاصيل رحله حج وعمره</h2>
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
                <div class="col-sm-3">
                    <div>
                        <div id="order-summary" class="box">
                            <div class="box-header">
                                <h3 class="mb-0">تفاصيل البرنامج</h3>
                            </div>
                            <p class="text-muted">هنا يمكنك تتبع مختصر تفاصيل البرنامج</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>رقم الرحله</td>
                                            <th>{{ $trip->id }}</th>
                                        </tr>
                                        <tr>
                                            <td>نوع البرنامج</td>
                                            <th>{{ $trip->sub_service_id == '1' ? 'عمرة' : 'حج' }}</th>
                                        </tr>
                                        <!-- <tr>
                                            <td>التنظيم</td>
                                            <th>{{ $trip->name_company }}</th>
                                        </tr> -->
                                        <tr>
                                            <td>جهة الصعود</td>
                                            <th>{{ $trip->air_river == 'air' ? 'جوا' : 'برا' }}</th>
                                        </tr>
                                        <tr>
                                            <td>مكان التجمع</td>
                                            <th>{{ $trip->takeoff_city->name }}</th>
                                        </tr>
                                        <tr>
                                            <td>اليوم</td>
                                            <th><?php $days = json_decode($trip->day, true); ?>
                                                @foreach($days as $day)
                                                @switch($day)
                                                @case('all')يوميا @break
                                                @case('sat')السبت @break
                                                @case('all') كل الايام@break
                                                @case('sun') الاحد@break
                                                @case('mon') الاثنين @break
                                                @case('tue') الثلاثاء @break
                                                @case('wed') الاربعاء @break
                                                @case('thu') الخميس @break
                                                @case('fri') الجمعة @break
                                                @default
                                                @endswitch
                                                @endforeach</th>
                                        </tr>
                                        <tr>
                                            <td>الساعة</td>
                                            <th>{{ $trip->coming_time }}</th>
                                        </tr>
                                        <tr>
                                            <td>بداية البرنامج</td>
                                            <th>{{ $trip->from_date }}</th>
                                        </tr>
                                        <tr>
                                            <td>عدد الايام </td>
                                            <th>{{ $trip->days_count }}</th>
                                        </tr>
                                        <tr>
                                            <td>السعر </td>
                                            <th>SAR {{ $trip->price }}</th>
                                        </tr>
                                        <tr>
                                            <td> العربون</td>
                                            <th>{{ $trip->deposit_price ? $trip->deposit_price : ($trip->sub_service_id == 2 ? $haj_deposit_value : $omra_deposit_value) }}</th>
                                        </tr>
                                        
                                        <tr>
                                            <td>تاريخ العودة</td>
                                            <th>{{ $trip->to_date }}</th>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">

                    <div id="details" class="box ">
                        <div class="mb-5">
                            <h3>برنامج شركه {{ $trip->provider->name_company }} </h3>
                        </div>
                        <div>
                            {!! $trip->program_details_page_content ?? 'لايوجد تفاصيل لهذا البرنامج' !!}
                        </div>
                        <hr>
                        <div class="social">
                            <div class="row">
                                <div class="col-sm-6">
                                    @if($trip->program_details_file)
                                    <a href="{{ url($trip->program_details_file ?? '') }}" download>
                                        <h4>تحميل ملف البرنامج <i class="fa fa-download mx-3"></i></h4>
                                    </a>
                                    @endif
                                </div>
                                <div class="col-sm-6 text-left">
                                    <a href="{{ route('passengers.hajCheckout', ['id' => $trip->id]) }}"
                                        class="btn btn-warning">
                                        <h4>حجز</h4>
                                    </a>
                                </div>
                            </div>
                            {{-- <p><a href="#" class="external facebook"><i class="fa fa-facebook"></i></a><a href="#"
                                    class="external gplus"><i class="fa fa-google-plus"></i></a><a href="#"
                                    class="external twitter"><i class="fa fa-twitter"></i></a><a href="#"
                                    class="email"><i class="fa fa-envelope"></i></a></p> --}}
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
    </section>
@endsection
