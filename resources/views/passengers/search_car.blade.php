@extends('layouts.passenger')
@section('content')
<main>

    <!-- slider Area Start-->
    <div class="slider-area ">
        <!-- Mobile Menu -->
        <div class="slider-active">
            <div class="single-slider hero-overly  slider-height d-flex align-items-center" 
            data-background="{{asset('passenger-assets/img/hero/car.jpg')}}">
                <div class="container bus-slider">
                    <div class="row">
                        <div class="col-xl-5">
                            <!-- form -->
                            <form action="{{route('passengers.searchTrips_car')}}" method="get" class="search-box">
                                @csrf
                                <div class="input-form mb-30" style="width: 100%">
                                <h3> احجز رحلة </h3>
                                </div>
                                @php $sCities= App\City::where('country',1)->get(); 
                                $yCities= App\City::where('country',2)->get(); 
                                @endphp

                                <div class="line-form select-form mb-30 from-trip" style="width: 49%">
                                    <label for="from-trip"> سفر من</label>
                                    <div class="select-itms">
                                        <select name="from" id="select1">
                                            <option value="">من</option>
                                            <option value="">--المدن السعودية--</option>
                                            @foreach($sCities as $city)
                                            <option data-country="{{$city->country}}"
                                                value="{{$city->id}}"> {{$city->name}}
                                            </option>
                                            @endforeach
                                            <option>-- المدن اليمنية --</option>
                                            @foreach($yCities as $city)
                                            <option data-country="{{$city->country}}"
                                                value="{{$city->id}}"> {{$city->name}}
                                            </option>
                                            @endforeach
                                
                                        </select>
                                    </div>                                    </div>
                                <div class="line-form select-form mb-30 to-trip" style="width: 49%">
                                    <label for="to-trip"> وصول الى</label>
                                    <div class="select-itms">
                                        <select name="to" id="select2">
                                            <option value="">الى</option>
                                            <option value="">--المدن السعودية--</option>
                                            @foreach($sCities as $city)
                                            <option data-country="{{$city->country}}"
                                                value="{{$city->id}}"> {{$city->name}}
                                            </option>
                                            @endforeach
                                            <option>-- المدن اليمنية --</option>
                                            @foreach($yCities as $city)
                                            <option data-country="{{$city->country}}"
                                                value="{{$city->id}}"> {{$city->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>                                    </div>
                                <div class="line-form input-form mb-30" style="width: 49%">
                                    <label for="to-trip"> تاريخ السفر </label>
                                    <input name="tripDate" class="tripDate" type="date" placeholder="">
                               <!--   <input class="form-control tripDate" name="tripDate" type="text"> -->

                                </div>
                                <div class="line-form-trip input-form mb-30 d-flex" style="width: 49%;padding: 45px 20px 0 0;">
                                        <div class="confirm-checkbox">
                                            <input type="checkbox" name="allTrip" id="confirm-checkbox" checked>
                                            <label for="confirm-checkbox"></label>
                                        </div>
                                        <label for="confirm-checkbox" style="margin: -7px 10px 0 0;cursor:pointer">رحلات كل يوم</label>

                                </div>
                                <div class="input-form mb-30" style="width: 30%">
                                    <label for="to-trip">  عدد التذاكر</label>
                                    <div class="d-flex">
                                        <a href="#" class="ticket-add btn-number" data-type="plus">+</a>
                                        <input type="text" class="ticketNo" name="ticketNo" readonly="readonly"  placeholder="" value="1" min="1" max="10">
                                        <a href="#" class="ticket-minus btn-number" disabled="disabled" data-type="minus">-</a>
                                    </div>

                                </div>
                                <div class="search-form mb-30" style="width: 100%">
                                    <button class="trip-show" type="submit">عرض  الرحلات</button>
                                </div>	
                            </form>	
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-9 caption-div">
                            <div class="hero__caption">
                            <h1>احجز رحلتك مع <span> سيارة خاصة</span> </h1>
                                <p>احجز رحلتك بأقل من دقيقتين</p>
                            </div>
                        </div>
                    </div>
                    <!-- Search Box -->
                    <div class="row">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->
    
   
</main>
<div class="whole-wrap">
    <div class="container box_1170">
        <div class="row"> 
            <div class="col-6">
            </div>
        </div>

    </div>
</div>

<div class="whole-wrap">
    <div class="container box_1170">
        <div class="section-top-border">
            @if($tripDetails['from'] && $tripDetails['to']) 
                <h3 class="mb-30"> الرحلات من مدينة {{  $tripDetails['from'] }} الى مدينة {{  $tripDetails['to'] }} </h3>
                <span>عدد التذاكر - {{  $tripDetails['ticketNo'] }}  </span>
             @endif
             @if(!$tripDetails['from'] && !$tripDetails['to'] && $tripDetails['all'])
                 <h3> رحلات كل يوم </h3>
             @endif
             @if($tripDetails['from'] && !$tripDetails['to']) 
                <h3 class="mb-30"> الرحلات من مدينة {{  $tripDetails['from'] }} </h3>
                <span>عدد التذاكر - {{  $tripDetails['ticketNo'] }}  </span>
             @endif
             @if(!$tripDetails['from'] && $tripDetails['to']) 
                <h3 class="mb-30"> الرحلات الى مدينة {{  $tripDetails['to'] }} </h3>
                <span>عدد التذاكر - {{  $tripDetails['ticketNo'] }}  </span>
             @endif
             <div class="progress-table-wrap">
                @include('incs.searchedTrips', ['trips' =>$searchedTrips ,
                                                //'currency' => $currency, 
                                                'ticketNo' => $tripDetails['ticketNo']])
            </div>
        </div>

    </div>
</div>

@endsection