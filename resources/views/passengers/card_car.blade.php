@extends('layouts.passenger')
@section('content')
@section('css')

<script src="{{asset('js/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="{{asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.css')}}">
@endsection

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
@php $yCurrency= 'ريال يمني'; @endphp

<div class="whole-wrap">
  <div class="container box_1170">
    <div class="section-top-border">
    <h1 style="text-align: center">نقل ركاب عالماشي بسيارة خاصة</h1>

      <h3 class="mb-30">جميع الرحلات (من السعودية إلى اليمن)</h3>
      @php $yCurrency= 'ريال يمني'; @endphp

      <div class="progress-table-wrap">
        <div>
          <table class="table mt-3 trip-dep">
            <tr>
              <th>{{__('للحجز')}}</th>
              <th>{{__('النوع')}}</th>
              <th>{{__('السعر')}}</th>
              <th>{{__('صعود')}}</th>
              <th>{{__('نزول')}}</th>


              <th>{{__('الشركة الناقلة')}}</th>
              <th>{{__('المغادرة')}}</th>
              <th>{{__('الايام')}}</th>

            </tr>
            @foreach($tripsToYemen as $key => $tripYemen)
            <tr>


              <td><a href="{{ route('passengers.reserveTrips',[$tripYemen->id, 1])}}" class="btn btn-info trip-btn">احجز</a></td>
              <td>
                @if ($tripYemen->trip_type == 'car')
                سيارة خاصة
                @else
                شركة نقل
                @endif

              </td>
              <td>{{(integer)$tripYemen->price}} {{$yCurrency}}</td>
              <td>
                <div class="city-arrow"> <i class="fas fa-arrow-up fa-xs"></i> {{$tripYemen->depCity}}</div>

              </td>
              <td>
                <div class="city-arrow"> <i class="fas fa-arrow-down fa-xs"></i> {{$tripYemen->comCity}} </div>
              </td>
              <td>{{$tripYemen->provider}}</td>

              <td>{{$tripYemen->leave_time}}</td>

              <td>{{App\Trip::replaceDays($tripYemen->day)}}</td>



            </tr>
            @endforeach

          </table>
        </div>
      <h3 class="mb-30">جميع الرحلات (من اليمن إلى السعودية)</h3>
      @php $sCurrency= 'ريال سعودي'; @endphp

        <div>
          <table class="table mt-3 trip-dep">
            <tr>
              <th>{{__('للحجز')}}</th>
              <th>{{__('النوع')}}</th>
              <th>{{__('السعر')}}</th>
              <th>{{__('صعود')}}</th>
              <th>{{__('نزول')}}</th>


              <th>{{__('الشركة الناقلة')}}</th>
              <th>{{__('المغادرة')}}</th>
              <th>{{__('الايام')}}</th>

            </tr>
            @foreach($tripsToSa as $key => $tripYemen)
            <tr>


              <td><a href="{{ route('passengers.reserveTrips',[$tripYemen->id, 1])}}" class="btn btn-info trip-btn">احجز</a></td>
              <td>
                @if ($tripYemen->trip_type == 'car')
                سيارة خاصة
                @else
                شركة نقل
                @endif

              </td>
              <td>{{(integer)$tripYemen->price}} {{$sCurrency}}</td>
              <td>
                <div class="city-arrow"> <i class="fas fa-arrow-up fa-xs"></i> {{$tripYemen->depCity}}</div>

              </td>
              <td>
                <div class="city-arrow"> <i class="fas fa-arrow-down fa-xs"></i> {{$tripYemen->comCity}} </div>
              </td>
              <td>{{$tripYemen->provider}}</td>

              <td>{{$tripYemen->leave_time}}</td>

              <td>{{App\Trip::replaceDays($tripYemen->day)}}</td>



            </tr>
            @endforeach

          </table>
        </div>
      <h3 class="mb-30">جميع الرحلات (بين المدن اليمنية )</h3>
      @php $yCurrency= 'ريال يمني'; @endphp

        <div>
  <table class="table mt-3 trip-dep">
    <tr>
      <th>{{__('للحجز')}}</th>
      <th>{{__('النوع')}}</th>
      <th>{{__('السعر')}}</th>
      <th>{{__('صعود')}}</th>
      <th>{{__('نزول')}}</th>


      <th>{{__('الشركة الناقلة')}}</th>
      <th>{{__('المغادرة')}}</th>
      <th>{{__('الايام')}}</th>

    </tr>
    @foreach($tripsBtYemen as $key => $tripYemen) 
    <tr>
      
    
      <td><a href="{{ route('passengers.reserveTrips',[$tripYemen->id, 1])}}" class="btn btn-info trip-btn">احجز</a></td>
      <td>
      @if ($tripYemen->trip_type == 'car')
      سيارة خاصة        
      @else
      شركة نقل
      @endif
      
      </td>
      <td>{{(integer)$tripYemen->price}} {{$yCurrency}}</td>
      <td>
        <div class="city-arrow"> <i class="fas fa-arrow-up fa-xs"></i> {{$tripYemen->depCity}}</div>
        
        </td> 
        <td><div class="city-arrow"> <i class="fas fa-arrow-down fa-xs"></i> {{$tripYemen->comCity}} </div></td>
      <td>{{$tripYemen->provider}}</td>

      <td>{{$tripYemen->leave_time}}</td>

      <td>{{App\Trip::replaceDays($tripYemen->day)}}</td>



    </tr>
    @endforeach

  </table>
</div>
      </div>
    </div>

  </div>
</div>

@endsection

@section('js')

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="{{asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>


<script>
  jQuery(document).ready(function() {

    /* $('.tripDate').datetimepicker({
         useCurrent: false,
                 stepping: 60,
                 format: 'mm-dd',
                 timeZone: 'Asia/Aden',
             });
    */

  });
</script>
@endsection