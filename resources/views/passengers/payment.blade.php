@extends('layouts.passenger')
@section('content')

<div class="slider-area ">
    <!-- Mobile Menu -->
    <div class="single-slider slider-height2 d-flex align-items-center" 
    data-background="{{asset('passenger-assets/img/hero/contact_hero.jpg')}}" 
    style="background-image: url({{asset('passenger-assets/img/hero/contact_hero.jpg')}});">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2> تأكيد الحجز</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('flash-message')

@php
   $currency = App\Trip::getCurrency($trip->takeoff_city_id); 
   $country  =  App\Trip::getCityCountry($trip->takeoff_city_id); 
   $takeoff_city  =  App\Trip::getCityName($trip->takeoff_city_id); 
   $arrival_city  =  App\Trip::getCityName($trip->arrival_city_id); 

@endphp
<section class="contact-section">
    <div class="container">

        <div class="row mt-5">
            <div class="col-12">
                <h2 class="contact-title"> دفع قيمة الحجز #{{$order->id}}</h2>

            </div>
            <div class="col-lg-8">
                <form class="form-contact contact_form" action="{{ route('passengers.tripCheckout',[$order->id])}}"
                     method="post" enctype="multipart/form-data">
                     @csrf
                    <div class="row">
                        <div class="col-sm-12 amount-pay">
                            <h3 style="margin-bottom: 20px">  </h3>

                            <div class="form-group d-flex">
                                <div class="form-check amount-check">
                                    <input class="form-check-input" type="radio" name="payment_type" id="part" 
                                    value="deposit_payment" >
                                    <label class="form-check-label" for="part">
                                       دفع عربون (حجز مضمون)
                                    </label>
                                  </div>
                                  <div class="form-check amount-check">
                                    <input class="form-check-input" type="radio" name="payment_type" id="full" 
                                    value="total_payment">
                                    <label class="form-check-label" for="full">
                                        دفع كامل المبلغ (حجز مضمون)
                                    </label>
                                  </div>
                                  <div class="form-check amount-check">
                                    <input class="form-check-input" type="radio" name="payment_type" id="nopay"
                                     value="later_payment">
                                    <label class="form-check-label" for="nopay">
                                         دفع عند الاستلام (حجز انتظار)
                                    </label>
                                  </div>
                                  <div class="form-check amount-check">
                                    <input class="form-check-input" type="radio" name="payment_type" id="friend"
                                     value="later_payment" id="friend">
                                    <label class="form-check-label" for="friend">
                                         الدفع عبر صديق (حجز انتظار)
                                    </label>
                                  </div>

                               
                            </div>
                        </div>
                        <!-- to choose payment method  -->
                        <div class="col-sm-12 pay-div" style="display: none">
                            <div class="form-group payment-method">
                                <h4 class="form-group"> اختر وسيلة الدفع</h4>
                            </div>

                            <div class="form-group d-flex">
                                @if($country == 1)
                                    <!-- <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentType" id="telr" 
                                        value="telr" id="telr">
                                        <label class="form-check-label" for="telr">
                                        بوابة تيلر
                                        </label>
                                    </div> -->
                                    <div class="text-center ml-2" style="border: 1px solid #ccc;
                                    height: fit-content;">
                                        <div style="height: 100px">
                                            <img src="{{ asset('img/payment.png') }}" class="w-100 h-100"  alt="">
                                        </div>
                                        <div class="text-center p-2" style="background-color: #ccc;">
                                            <input class="" type="radio" name="paymentType" id="telr" 
                                            value="telr" id="telr">
                                            <label class="form-check-label" for="telr">
                                            بطاقات الدفع الالكتروني
                                            </label>
                                        </div>
                                    </div>
                                @endif

                                <div class="text-center ml-2" style="border: 1px solid #ccc;
                                    height: fit-content;">
                                        <div style="height: 100px">
                                        <img src="{{ asset('img/banl-logo.jpg') }}" class="w-100 h-100" alt="">
                                    </div>
                                    <div class="text-center p-2" style="background-color: #ccc;">
                                        <input class="" type="radio" name="paymentType" id="bank" 
                                        value="bank" id="bank">
                                        <label class="form-check-label" for="bank">
                                        التحويل البنكي
                                        </label>
                                    </div>
                                </div>
                                  
                                  <!-- <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentType" id="bank" 
                                    value="bank" id="bank">
                                    <label class="form-check-label" for="exampleRadios2">
                                      تحويل بنكي
                                    </label>
                                  </div> -->
                               
                            </div>
                        </div>

                        <!-- For bank method  --> 

                        <div class="col-sm-12 bank-trans" style="display: none">
                            <div class="form-group">
                                <h4 class="form-group"> تحويل بنكي الى {{($country == 1) ? 'السعودية' : 'اليمن'}}</h4>
                                <p>يرجى التحويل الى رقم الحساب ({{ \App\Setting::where('key', 'BANK_ACCOUNT')->first()->value }}) وارفاق صورة التحويل </p>
                                <input type="file" class="form-contol" name="payment_image" value="{{ old('payment_image') }}">
                            </div>

                        </div>
                        <div class="col-sm-12 url-div" style="display: none">
                            <div class="form-group">
                                <h4 class="form-group"> رابط الحجز</h4>
                                <p>تمكنك هذه الخدمة من ارسال رابط الحجز ادناه الى صديق ليقوم بسداد رسوم الحجز عنك, قم بنسخ الرابط عبر الضغط على الحقل وارساله يدويا او مشاركة الرابط عبر الواتساب عن طريق ضغط الزر المخصص ادناه </p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control mb-2" onclick="this.select();
                                        document.execCommand('copy');" readonly name="link" value="{{ request()->fullUrl() }}">
                                        <a href="https://api.whatsapp.com/send?text={{ request()->fullUrl() }}" class="p-1  btn-success">ارسال الرابط عبر واتساب</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-12 on_delivery-div" style="display: none">
                            <div class="form-group">
                                <h4 class="form-group"> خدمة الدفع عند الاستلام</h4>
                                <p>عبر هذا الخيار يمكنك الدفع لاحقا عند استلام التزكرة في الباص, الا ان حجزك الان لايعتبر حجز مؤكد الا بعد دفع رسوم التزكرة </p>
                                <!-- <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control mb-2" onclick="this.select();
                                        document.execCommand('copy');" readonly name="link" value="{{ request()->fullUrl() }}">
                                        <a href="https://api.whatsapp.com/send?text={{ request()->fullUrl() }}" class="p-1  btn-success">ارسال الرابط عبر واتساب</a>
                                    </div>
                                </div> -->
                            </div>

                        </div>

                    </div>
                    <div class="form-group pay-btn" style="margin-top: 150px;text-align:center">
                        <button type="submit" class="button button-contactForm boxed-btn"> تأكيد</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 offset-lg-1" style="">
                <div class="media contact-info">
                    <div class="row media-body">
                        <div class="col-12"><h3 class="mb-30 trip-direction">  رحلة من  {{  $takeoff_city }} الى  {{  $arrival_city }} </h3></div>
                        <div class="col-6"> <h3>عدد التذاكر</h3></div>
                        <div class="col-6"><p>{{$order->ticket_no}}</p></div>
                        <div class="col-6"><h3>تاريخ الرحلة</h3></div>
                        <div class="col-6"><p>{{ $trip->from_date}}</p></div>
                        <div class="col-6"><h3>سعر التذكرة</h3></div>
                        <div class="col-6"><p>{{ $trip->price}} {{$currency}}</p></div>
                        <div class="col-6"><h3>السعر الاجمالي</h3></div>
                        <div class="col-6"><p>{{ $order->total_price}} {{$currency}}</p></div>

                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>



@endsection
