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
                        <h2>رحلة حج وعمرة</h2>
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
            <div class="col-12">
                <h2 class="contact-title"> تسجيل الحجاج</h2>
            </div>
            <div class="col-lg-8">
                <form class="form-contact contact_form" action="{{ route('passengers.tripOrder',[$trip->id])}}"
                     method="post" novalidate="novalidate">
                     @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group d-flex">
                                <input class="form-control valid" name="phone" id="phone" type="text" value="{{ old('phone') }}"
                                placeholder=" * رقم الجوال ">

                                <div class="phone-intro">
                                    <select class="form-control" name="phoneCountry" id="phoneCountry">
                                        <option value="s" @if(old('phoneCountry') == 's') selected @endif>966+</option>
                                        <option value="y" @if(old('phoneCountry') == 'y') selected @endif>967+</option>

                                    </select>
                                </div>  

                            </div>
                            
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input class="form-control valid" name="email" id="email" type="text" value="{{ old('email') }}"
                                placeholder="البريد الالكتروني">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea class="form-control w-100" name="notes" id="notes" cols="30" rows="6" 
                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'ملاحظات'" placeholder=" ملاحظات">
                                {{ old('notes') }}
                            </textarea>
                            </div>
                            <input type="hidden" name="ticketNo" value="{{$ticketNo}}">
                        </div>
                        <hr>

                        <div class="col-sm-12 add-passenger-container">
                            <h3 style="margin-bottom: 20px"> بيانات الراكب</h3>

                            <div class="form-group d-flex passenger-row" id="passenger-row">
                                <input class="form-control valid" name="name[]" id="name" type="text"
                                placeholder=" اسم الراكب">
                                
                                <div style="margin-right: 3px"></div>
                                <select class="form-control" name="age[]" id="age">
                                    <option value="">الفئة العمرية للراكب</option>
                                    <option value="adult">بالغ</option>
                                    <option value="child">طفل (من سنتين الى 12)</option>
                                    <option value="baby">رضيع (تحت السنتين)</option>
                                </select>
                                <div style="margin-right: 3px"></div>

                                <select class="form-control" name="gender[]" id="gender">
                                    <option value="">جنس الراكب</option>
                                    <option value="femal">انثى</option>
                                    <option value="male">ذكر</option>
                                </select>
                          
                                <input class="form-control" name="nid[]" id="nid" type="text"
                                style="margin-right: 3px"
                                placeholder="رقم هوية الراكب">
                            </div>
                            
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <a href="#" class="ticket-form add-ticket"> اضافة راكب</a>
                                <a href="#" id="" class="ticket-form remove-ticket" style="display: none"> حذف راكب</a>

                            </div>
                        </div>

                    </div>
                    <div class="form-group reserve-btn">
                        <button type="submit" class="button button-contactForm boxed-btn">توجه للدفع</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 offset-lg-1" style="">
                <div class="media contact-info">
                    <div class="row media-body">
                        <div class="col-12"><h3 class="mb-30 trip-direction">  رحلة من  {{  $trip->depCity }} الى  {{  $trip->comCity }} </h3></div>
                        <div class="col-6"> <h3>عدد التذاكر</h3></div>
                        <div class="col-6"><p>{{$ticketNo}}</p></div>
                        <div class="col-6"><h3>تاريخ الرحلة</h3></div>
                        <div class="col-6"><p>{{ $trip->from_date}}</p></div>
                        <div class="col-6"><h3>سعر التذكرة</h3></div>
                        <div class="col-6"><p>{{ $trip->price}} {{$currency}}</p></div>
                        <div class="col-6"><h3>السعر الاجمالي</h3></div>
                        <div class="col-6"><p>{{ $totalPrice}} {{$currency}}</p></div>

                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

@endsection