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
                        <h2> معلومات التذكرة</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@php
   $currency = App\Trip::getCurrency($trip->from); 

@endphp
<section class="contact-section">
    <div class="container">

        <div class="row mt-5">
            <div class="col-12">
                <h2 class="contact-title">   معلومات التذكرة رقم #{{$order->id}}</h2>

            </div>
                       
            <div class="col-sm-6 offset-lg-1" style="">
                <div class="media contact-info">
                    <div class="row media-body">
                        <div class="col-6"> <h3> اتجاه الرحلة</h3></div>
                        <div class="col-6"><p>  رحلة من  {{  $trip->depCity }} الى  {{  $trip->comCity }} </p></div>

                        <div class="col-6"> <h3> الشركة الناقلة</h3></div>
                        <div class="col-6"><p>{{$trip->provider}}</p></div>

                        <div class="col-6"><h3>سعر التذكرة</h3></div>
                        <div class="col-6"><p>{{ $trip->price}} {{$currency}}</p></div>

                        <div class="col-6"> <h3>عدد التذاكر</h3></div>
                        <div class="col-6"><p>{{$order->ticket_no}}</p></div>

                        <div class="col-6"><h3>السعر الاجمالي</h3></div>
                        <div class="col-6"><p>{{ $order->total_price}} {{$currency}}</p></div>

                        <div class="col-6"><h3>الدفعة المقدمة </h3></div>
                        <div class="col-6"><p>{{ $order->paid}} {{$currency}}</p></div>

                        <div class="col-6"><h3>تاريخ السفر</h3></div>
                        <div class="col-6"><p>{{ $trip->from_date}}</p></div>
                       
                        <div class="col-6"><h3>وقت الحركة</h3></div>
                        <div class="col-6"><p>{{ $trip->leave_time}}</p></div>

                        <div class="col-6"><h3> فئة الباص</h3></div>
                        <div class="col-6"><p>استاندرز </p></div>

                        <div class="col-6"><h3> حالة الحجز</h3></div>
                        <div class="col-6"><p>@switch($order->status)
                            @case('created')
                                في انتظار الدفع
                                @break
                            @case('confirmed')
                                تم تأكيد الحجز
                                @break
                                @case('payed')
                                مدفوع @if($order->payment_type == 'deposit_payment') عربون @elseif($order->payment_type == 'total_payment') كامل المبلغ @endif
                                @break
                            @default
                                
                        @endswitch </p></div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>



@endsection