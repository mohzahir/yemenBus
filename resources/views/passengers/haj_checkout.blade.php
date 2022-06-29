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
                        <form method="POST" action="{{ route('passengers.storeHajCheckout', ['id' => $trip->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <h1>الحجز - البيانات الشخصيه</h1>
                            <div class="nav flex-column flex-md-row nav-pills text-center">
                                <a href="#" class="nav-link flex-sm-fill text-sm-center active"> <i
                                        class="fa fa-user">
                                    </i><br>البيانات الشخصية</a>
                                {{-- <a href="#" class="nav-link flex-sm-fill text-sm-center disabled"> <i
                                        class="fa fa-truck"> </i>Delivery Method</a> --}}
                                <a href="#" class="nav-link flex-sm-fill text-sm-center disabled"> <i
                                        class="fa fa-money-bill-alt"></i><br>طرق الدفع</a>
                                <a href="#" class="nav-link flex-sm-fill text-sm-center disabled:">
                                    <i class="fa fa-eye"> </i><br>بوابة الدفع</a>
                            </div>
                            <div class="content py-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="firstname">الاسم الكامل <strong class=" text-danger">*</strong></label>
                                            <input id="firstname" type="text" class="form-control" name="name">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">رقم الهاتف <strong class=" text-danger">*</strong></label>
                                            <div class=" d-flex">
                                                <input class="form-control valid" name="phone" id="phone" type="text"
                                                    value="">

                                                <div class="phone-intro">
                                                    <select class="form-control" name="phoneCountry" id="phoneCountry">
                                                        <option value="s">966+</option>
                                                        <option value="y">967+</option>
                                                    </select>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="street">البريد الالكتروني</label>
                                            <input id="street" type="email" class="form-control" name="email">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row-->
                                <div class="row">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="street">جنس الراكب</label>
                                            <select class="form-control w-100" name="gender" id="gender">
                                                <option value="">--</option>
                                                <option value="male">ذكر</option>
                                                <option value="femal">انثى</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="zip">الفئة العمرية</label>
                                            <select class="form-control w-100" name="age" id="age">
                                                <option value="">--</option>
                                                <option value="adult">بالغ</option>
                                                <option value="child">طفل (من سنتين الى 12)</option>
                                                <option value="baby">رضيع (تحت السنتين)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="state">تاريخ الميلاد</label>
                                            <input class="form-control" name="dateofbirth" id="dateofbirth" type="date"
                                                style="margin-right: 3px">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="country">رقم الهوية</label>
                                            <input class="form-control" name="nid" id="nid" type="text"
                                                style="margin-right: 3px">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="passport">صوره الجواز</label>
                                            <input id="passport" type="file" class="form-control" name="passport_img">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row-->
                            </div>
                            <div class="box-footer d-flex justify-content-between">
                                <!-- <a
                                    href="{{ route('passengers.home', ['slug' => 'haj']) }}"
                                    class="btn btn-outline-secondary"><i class="fa fa-chevron-right"></i>العودة لقائمة
                                    الرحلات</a> -->
                                <button type="submit" class="btn btn-primary">المتابعه لطرق الدفع<i
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
                                            @if ($trip->sub_service_id == '1')
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
                                        <tr>
                                            <td>قيمه العربون</td>
                                            @if ($trip->sub_service_id == '1')
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
                                            @if ($trip->sub_service_id == '1')
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
    </section>
@endsection
