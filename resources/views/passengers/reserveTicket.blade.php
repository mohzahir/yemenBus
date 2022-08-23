@extends('layouts.passenger')

@section('css')
<style>
    input::-webkit-calendar-picker-indicator {
        display: none;
    }

    body>section>div>div>div.col-lg-8>form>div.row>div.col-12>div>div>div>span {
        padding-left: 0;
    }
</style>

@endsection
@section('content')

<div class="slider-area ">
    <!-- Mobile Menu -->
    <div class="single-slider slider-height2 d-flex align-items-center" data-background="{{asset('passenger-assets/img/hero/contact_hero.jpg')}}" style="background-image: url({{asset('passenger-assets/img/hero/contact_hero.jpg')}});">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>حجز رحلة</h2>
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
                <h2 class="contact-title"> حجز رحلة</h2>
            </div>
            <div class="col-lg-3 offset-lg-1" style="">
                <div class="media contact-info">
                    <div class="row media-body">
                        <div class="col-12">
                            <h3 class="mb-30 trip-direction"> رحلة من {{ $trip->depCity }} الى {{ $trip->comCity }} </h3>
                        </div>
                        <div class="col-6">
                            <h3>عدد التذاكر</h3>
                        </div>
                        <div class="col-6">
                            <p>{{$ticketNo}}</p>
                        </div>
                        <div class="col-6">
                            <h3>تاريخ الرحلة</h3>
                        </div>
                        <div class="col-6">
                            <p>{{ $trip->from_date}}</p>
                        </div>
                        <div class="col-6">
                            <h3>مسار الرحلة</h3>
                        </div>
                        <div class="col-6">
                            <p>{{ $trip->lines_trip}}</p>
                        </div>
                        <div class="col-6">
                            <h3>سعر التذكرة</h3>
                        </div>
                        <div class="col-6">
                            <p>{{ $trip->price}} {{$currency}}</p>
                        </div>
                        <div class="col-6">
                            <h3>السعر الاجمالي</h3>
                        </div>
                        <div class="col-6">
                            <p>{{ $totalPrice}} {{$currency}}</p>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-lg-8">
                <form class="form-contact contact_form" action="{{ route('passengers.tripOrder',[$trip->id])}}" method="post" novalidate="novalidate" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group d-flex">
                                <input class="form-control valid" name="phone" id="phone" type="text" value="{{ old('phone') }}" placeholder="رقم الجوال (555566688)" required>

                                <div class="phone-intro">
                                    <select class="form-control" name="phoneCountry" id="phoneCountry">
                                        <option value="s" @if(old('phoneCountry')=='s' ) selected @endif>966+</option>
                                        <option value="y" @if(old('phoneCountry')=='y' ) selected @endif>967+</option>
                                        <option value="e" @if(old('phoneCountry')=='e' ) selected @endif>971+</option>

                                    </select>
                                </div>

                            </div>

                        </div>


                        <div class="col-sm-12 add-passenger-container">
                            <h3 style="margin-bottom: 20px"> بيانات الراكب</h3>

                            <div class="form-group d-flex passenger-row" id="passenger-row">
                                <input class="form-control valid" name="name[]" value="{{ old('name.0') }}" id="name" type="text" placeholder=" اسم الراكب" required>

                                <div style="margin-right: 3px"></div>
                                <select class="form-control" name="age[]" id="age" required>
                                    <option value="">الفئة العمرية للراكب</option>
                                    <option @if( old('age.0')=='adult' ) selected @endif value="adult">بالغ</option>
                                    <option @if( old('age.0')=='child' ) selected @endif value="child">طفل (من سنتين الى 12)</option>
                                    <option @if( old('age.0')=='baby' ) selected @endif value="baby">رضيع (تحت السنتين)</option>
                                </select>
                                <div style="margin-right: 3px"></div>
                                
                                <select class="form-control " name="gender[]" id="gender" required>
                                    <option value="">جنس الراكب</option>
                                    <option @if( old('gender.0')=='female' ) selected @endif value="female">انثى</option>
                                    <option @if( old('gender.0')=='male' ) selected @endif value="male">ذكر</option>
                                </select>
                                <div style="margin-right: 3px"></div>

                                <!-- <input class="form-control" name="dateofbirth[]" value="{{ old('dateofbirth.0') }}" id="dateofbirth" type="text" style="margin-right: 3px" onfocus="(this.type='date')" placeholder="تاريخ الميلاد(dd-mm-yyyy)" required> -->
                                <input class="form-control" name="dateofbirth[]" value="{{ old('dateofbirth.0') }}" type="text" style="margin-right: 3px" placeholder="تاريخ الميلاد(dd-mm-yyyy)" required>

                                <!-- <input  type="date" style=" display: inline-block;" name="dateofbirth[]" value="{{ old('dateofbirth.0') }}" placeholder="تاريخ الميلاد" class="form-control" required> -->
                                <!-- <input  type="text" style="width: 15%; display: inline-block;" name="dateofbirth[0][]" value="{{ old('dateofbirth.0.0') }}" placeholder="شهر" class="form-control" required>
                                <input  type="text" style="width: 17%; display: inline-block;" name="dateofbirth[0][]" value="{{ old('dateofbirth.0.0') }}" placeholder="سنة" class="form-control" required> -->

                                <input class="form-control" name="nid[]" id="nid" value="{{ old('nid.0') }}" type="text" style="margin-right: 3px" placeholder="رقم هوية الراكب" required>
                            </div>

                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <a href="#" class="ticket-form add-ticket"> اضافة راكب</a>
                                <a href="#" id="" class="ticket-form remove-ticket" style="display: none"> حذف راكب</a>

                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <input class="form-control valid" name="email" id="email" type="text" value="{{ old('email') }}" placeholder=" كتابة البريد (اختياري) example@domain.com">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input class="form-control valid" name="ride_place" id="ride_place" type="text" value="{{ old('ride_place') }}" placeholder="مدينة الصعود الى الباص (الطائف)">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input class="form-control valid" name="drop_place" id="drop_place" type="text" value="{{ old('drop_place') }}" placeholder="مدينة النزول من الباص(العبر)">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea class="form-control w-100" name="notes" id="notes" cols="30" rows="6" placeholder="الملاحظات. (. اريد كرسي. بالمقدمة ..)(اختياري)">{{ old('notes') }}</textarea>
                            </div>
                            <input type="hidden" name="ticketNo" value="{{$ticketNo}}">
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="passport_img">صورة الجواز او اثبات الهوية(اختياري)</label>
                                <input class="form-control valid" name="passport_img" id="passport_img" type="file" value="{{ old('passport_img') }}" placeholder="صورة الجواز او اثبات الهوية">
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-12">
                                <p> <a target="_blank" href="{{ route('passengers.privacy') }}" class="text-danger">- الشروط والاحكام  </a></p>
                                <div class="form-groub">
                                    <input class="ml-2" type="checkbox" value="1" name="privacy_check"  id="" required> بالضغط على هذا الزر أنت توافق على جميع ماورد في صفحة الشروط والاحكام
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group reserve-btn">
                        <button type="submit" class="button button-contactForm boxed-btn">توجه للدفع</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection