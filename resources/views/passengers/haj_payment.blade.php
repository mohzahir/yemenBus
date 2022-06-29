@extends('layouts.passenger')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/style.default.css') }}" id="theme-stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        input::-webkit-calendar-picker-indicator {
            display: none;
        }

    </style>
    <script src="//unpkg.com/alpinejs" defer></script>
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
                            <h2> حجز رحلات حج وعمره</h2>
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
                {{-- <div class="col-lg-12">
                    <!-- breadcrumb-->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li aria-current="page" class="breadcrumb-item active">Checkout - Address</li>
                        </ol>
                    </nav>
                </div> --}}
                <div id="checkout" class="col-lg-9">
                    <div class="box">
                        <form method="POST"
                            action="{{ route('passengers.storeHajPayment', ['reservationId' => $reservation->id]) }}">
                            @csrf
                            <h1>الحجز - طرق الدفع</h1>
                            <div class="nav flex-column flex-md-row nav-pills text-center">
                                <a href="checkout1.html" class="nav-link flex-sm-fill text-sm-center disabled"> <i
                                        class="fa fa-user">
                                    </i><br>البيانات الشخصية</a>
                                {{-- <a href="#" class="nav-link flex-sm-fill text-sm-center disabled"> <i
                                        class="fa fa-truck"> </i>Delivery Method</a> --}}
                                <a href="#" class="nav-link flex-sm-fill text-sm-center active"> <i
                                        class="fa fa-money-bill-alt"></i><br>طرق الدفع</a>
                                <!-- <a href="#" class="nav-link flex-sm-fill text-sm-center disabled">
                                    <i class="fa fa-eye"> </i><br>معاينة الحجز</a> -->
                            </div>
                            <div class="content py-3" x-data="{ showPaymentMethods: false }">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="box payment-method">
                                            <h4>دفع كامل المبلغ</h4>
                                            <p>حجز مضمون</p>
                                            <div class="box-footer text-center">
                                                <input x-on:click="showPaymentMethods = true" type="radio"
                                                    name="payment_type" value="total_payment" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="box payment-method">
                                            <h4>دفع عربون</h4>
                                            <p>قيمه دخول الجواز للسفاره للتأشير</p>
                                            <div class="box-footer text-center">
                                                <input x-on:click="showPaymentMethods = true" type="radio"
                                                    name="payment_type" value="deposit_payment" placeholder="placeholder">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row-->
                                <div x-show="showPaymentMethods" class="row" x-transition>
                                    {{-- <div class="col-sm-12">
                                        <h3>طرق الدفع</h3>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="box payment-method">
                                            <input type="radio" name="payment_method" value="telr">
                                            <span class="mr-3">بوابه تيلر</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="box payment-method">
                                            <input type="radio" name="payment_method" value="bank">
                                            <span class="mr-3">تحويل بنكي</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer d-flex justify-content-between">
                                <!-- <a
                                    href="{{ route('passengers.hajCheckout', ['id' => $reservation->trip->id]) }}"
                                    class="btn btn-outline-secondary"><i class="fa fa-chevron-right"></i>العودة للبيانات
                                    الشخصية</a> -->
                                <button type="submit" class="btn btn-primary">ادفع الان<i
                                        class="fa fa-chevron-left"></i></button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-->
                </div>
                <!-- /.col-lg-9-->
                <div class="col-lg-3">
                    <div id="order-summary" class="card">
                        <div class="card-header">
                            <h3 class="mt-4 mb-4"> تفاصيل الحجز</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted"> من هنا يمكنك معاينه تفاصيل وبيانات الحجز</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>عدد التزاكر</td>
                                            <th>1</th>
                                        </tr>
                                        <tr>
                                            <td>نوع البرنامج</td>
                                            @if ($reservation->trip->sub_service_id == '1')
                                                <th>عمره
                                                </th>
                                            @else
                                                <th>حج
                                                </th>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>تاريخ السفر</td>
                                            <th>{{ $reservation->trip->from_date }}</th>
                                        </tr>
                                        <tr>
                                            <td>قيمه العربون</td>
                                            @if ($reservation->trip->sub_service_id == '1')
                                                <th>
                                                    {{ \App\Setting::where('key', 'OMRA_PROGRAM_RS_DEPOSIT')->first()->value }}
                                                    SAR
                                                </th>
                                            @else
                                                <th>
                                                    {{ \App\Setting::where('key', 'HAJ_PROGRAM_RS_DEPOSIT')->first()->value }}
                                                    SAR
                                                </th>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>خدمات اداريه</td>
                                            @if ($reservation->trip->sub_service_id == '1')
                                                <th>
                                                    {{ \App\Setting::where('key', 'OMRA_SERVICE_RS_PRICE')->first()->value }}
                                                    SAR
                                                </th>
                                            @else
                                                <th>
                                                    {{ \App\Setting::where('key', 'HAJ_SERVICE_RS_PRICE')->first()->value }}
                                                    SAR
                                                </th>
                                            @endif
                                        </tr>
                                        <tr class="total">
                                            <td>اجمالي الرسوم</td>
                                            <th> {{ $reservation->trip->price }} SAR</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-3-->
            </div>

        </div>
    </section>
@endsection
