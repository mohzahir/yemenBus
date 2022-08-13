@extends('layouts.passenger')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/style.default.css') }}" id="theme-stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        input::-webkit-calendar-picker-indicator {
            display: none;
        }

    </style>
    <style>
        #telr {
            width: 100%;
            /* min-width: 600px; */
            height: 600px;
            frameborder: 0;
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
                    <div x-data="{showBankPayment: false}" class="box">
                        <form method="POST"
                            action="{{ route('passengers.storeHajBankPayment', ['reservationId' => $reservation->id]) }}" enctype="multipart/form-data">
                            @csrf
                            <h1>الحجز - بوابة الدفع</h1>
                            <div class="nav flex-column flex-md-row nav-pills text-center">
                                <a href="#" class="nav-link flex-sm-fill text-sm-center disabled"> <i
                                        class="fa fa-user">
                                    </i><br>البيانات الشخصية</a>
                                <!-- <a href="#" class="nav-link flex-sm-fill text-sm-center disabled"> <i
                                        class="fa fa-truck"> </i>Delivery Method</a> -->
                                <a href="#" class="nav-link flex-sm-fill text-sm-center disabled"> <i
                                        class="fa fa-money-bill-alt"></i><br>طرق الدفع</a>
                                <a href="#" class="nav-link flex-sm-fill text-sm-center active">
                                    <i class="fa fa-eye"> </i><br>بوابة الدفع</a>
                            </div>
                            <div class="content py-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="box payment-method" style="background-image: url({{ asset('img/payment.png') }})">
                                            <h4>تيلر</h4>
                                            <p>الحجز عبر بطاقات الدفع الالكتروني</p>
                                            <div class="box-footer text-center">
                                                <input @click="showBankPayment = false" type="radio" checked
                                                    name="payment_method" value="telr" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="box payment-method" style="background-image: url({{ asset('img/banl-logo.jpg') }})">
                                            <h4>تحويل بنكي</h4>
                                            <p>الدفع عن طريق التحويل البنكي وارسال اشعار الدفع</p>
                                            <div class="box-footer text-center">
                                                <input @click="showBankPayment = true" type="radio"
                                                    name="payment_method" value="bank" placeholder="placeholder">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.row-->
                                <div x-show="showBankPayment" class="row" x-transition>
                                    <div class="col-md-12">
                                        <div class="box payment-method">
                                            <div class="form-group">
                                                <label class="text-danger">الرجاء تحويل المبلغ على رقم الحساب (<b>{{ \App\Setting::where('key', 'BANK_ACCOUNT')->first()->value }}</b>) وارفاق صورة التحويل</label>
                                                <input type="file" class="form-control" name="payment_image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer d-flex justify-content-between">
                                <!-- <a
                                    href="{{ route('passengers.hajCheckout', ['id' => $reservation->trip->id]) }}"
                                    class="btn btn-outline-secondary"><i class="fa fa-chevron-right"></i>العودة للبيانات
                                    الشخصية</a> -->
                                <template x-if="showBankPayment == false">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">ادفع الان<i
                                            class="fa fa-chevron-left"></i></button>
                                </template>
                                <template x-if="showBankPayment == true">
                                    <button type="submit" class="btn btn-primary">ادفع الان<i
                                            class="fa fa-chevron-left"></i></button>
                                </template>
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
                                            <td>عدد الايام</td>
                                            <th>{{ $reservation->trip->days_count }}</th>
                                        </tr>
                                        <tr class="total">
                                            <td>السعر الكلي</td>
                                            <th> {{ $reservation->trip->price }} SAR</th>
                                        </tr>
                                        <!-- <tr>
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
                                        </tr> -->
                                        <tr>
                                            <td> العربون</td>
                                            <th>{{ $reservation->trip->deposit_price ? $reservation->trip->deposit_price : ($reservation->trip->sub_service_id == 2 ? $haj_deposit_value : $omra_deposit_value) }}</th>
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
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-3-->
            </div>

        </div>


        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <!-- <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">تيلر</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div> -->
                <div class="modal-body">
                    <iframe id= "telr" src= " {{ $url }} " sandbox="allow-forms allow-modals allow-popups-to-escape-sandbox allow-popups allow-scripts allow-top-navigation allow-same-origin" ></iframe>
                </div>
                <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
            </div>
        </div>




    </section>
@endsection
