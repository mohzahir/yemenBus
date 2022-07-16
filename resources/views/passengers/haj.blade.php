@extends('layouts.passenger')
@section('content')
@section('css')
    <script src="{{ asset('js/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js">
    </script>
    <link rel="stylesheet" href="{{ asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.default.css') }}" id="theme-stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection




<main>

    <!-- slider Area Start-->
    <div class="slider-area ">
        <!-- Mobile Menu -->
        <div class="slider-active">
            <div class="single-slider hero-overly  slider-height d-flex align-items-center" 
            data-background="{{asset('passenger-assets/img/hero/haj.jpg')}}">
                <div class="container bus-slider">
                    <div class="row">
                        <!-- <div class="col-xl-5">
                            <form action="{{route('passengers.searchTrips')}}" method="get" class="search-box">
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
                        </div> -->
                        <div class="col-xl-6 col-lg-6 col-md-9 caption-div">
                            <div class="hero__caption">
                                <h1>احجز رحلة مع <span> يمن باص</span> </h1>
                                <p>احجز رحلتك بأقل من دقيقتين</p>
                            </div>
                        </div>
                    </div>
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
        @php $yCurrency= 'ريال يمني'; @endphp
        <div class="section-top-border">

            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-12">
                                <h1 class="text-center">جميع رحلات الحج والعمره</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="card sidebar-menu mb-4">
                        <div class="card-header">
                            <h3 class="h4 card-title d-flex justify-content-between">الخيارات
                                <a href="{{ route('passengers.home', ['slug' => 'haj']) }}"
                                    class="btn btn-sm btn-danger pull-left"><i class="fa fa-times-circle"></i>
                                    تفريغ</a>
                            </h3>
                        </div>
                        <div class="card-body">
                            <form method="GET">
                                @csrf
                                <table class="table">
                                    <tr>
                                        <td style="width: 110px;">نوع البرنامج </td>
                                        <th>
                                            <label class="mx-3">
                                                <input value="1" @if (request('sub_service_id') == '1') checked @endif
                                                    type="radio" name="sub_service_id" class="radio"> عمرة
                                            </label>
                                            <!-- <br> -->
                                            <label class="mx-3" for="">
                                                <input value="2" @if (request('sub_service_id') == '2') checked @endif
                                                    type="radio" name="sub_service_id" class="radio">
                                                حج
                                            </label>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td style="width: 110px;">طريقه القدوم</td>
                                        <th>
                                            <label class="mx-3">
                                                <input value="air" @if (request('air_river') == 'air') checked @endif
                                                    type="radio" name="air_river" class="radio"> جوا
                                            </label>
                                            <!-- <br> -->
                                            <label class="mx-3" for="">
                                                <input value="river" @if (request('air_river') == 'river') checked @endif
                                                    type="radio" name="air_river" class="radio">
                                                برا
                                            </label>
                                        </th>
                                    </tr>
                                </table>
                                <div class="form-group">
                                    <label for="">بدايه الرحله</label>
                                    <select class="form-control w-100" name="takeoff_city_id" id="">
                                        <option value="">----</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                @if (request('takeoff_city_id') == $city->id) selected @endif>{{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">السعر اقل من</label>
                                    <input type="text" name="price" value="{{ request('price') }}"
                                        class="form-control">
                                </div>
                                <button class="btn btn-default btn-sm btn-primary"><i class="fa fa-pencil"></i>
                                    بحث</button>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="col-md-9">
                    <!-- <div class="box">
                        <table class="table table-hover table-strip table-responsive">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 5%">نوع البرنامح</th>
                                    <th style="width: 20%">الجهة المنظمة</th>
                                    <th style="width: 5%">مدينة البدايه</th>
                                    <th style="width: 5%">عدد الايام </th>
                                    <th style="width: 5%">سعر البرنامج</th>
                                    <th style="width: 5%">قيمه العربون</th>
                                    <th style="width: 15%">تاريخ المغادره</th>
                                    <th style="width: 15%">تاريخ العوده</th>
                                    <th style="width: 30%">الخيارات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($trips) > 0)
                                    @foreach ($trips as $trip)
                                        <tr class="text-center">
                                            <td>{{ $trip->sub_service_id == '1' ? 'عمرة' : 'حج' }}</td>
                                            <td>{{ $trip->name_company }}</td>
                                            <td>{{ $trip->takeoff_city }}</td>
                                            <td>{{ $trip->days_count }}</td>
                                            <td>{{ $trip->price }} SAR</td>
                                            <td>{{ $trip->sub_service_id == 2 ? $haj_deposit_value : $omra_deposit_value }}
                                            </td>
                                            <td>{{ $trip->from_date }}</td>
                                            <td>{{ $trip->to_date }}</td>
                                            <td>
                                                <a href="{{ route('passengers.hajDetails', ['id' => $trip->trip_id]) }}"
                                                    class="btn btn-secondary btn-sm">التفاصيل</a>
                                                <a href="{{ route('passengers.hajCheckout', ['id' => $trip->trip_id]) }}"
                                                    class="btn btn-warning btn-sm">حجز</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div> -->


                    <div class="row">
                        @if(count($trips) > 0)
                        @foreach ($trips as $trip)

                        <div class="col-md-6">
                            <div id="order-summary" class="box">
                                <div class="box-header">
                                    <h3 class="mb-0"> <strong>المنظم شركة</strong> {{ $trip->name_company }} </h3>
                                </div>
                                <!-- <p class="text-muted">هنا يمكنك تتبع مختصر تفاصيل البرنامج</p> -->
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            @if($trip->title)
                                            <tr>
                                                <td>العنوان</td>
                                                <th>{{ $trip->title}}</th>
                                            </tr>
                                            @endif
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
                                                <th>{{ $trip->takeoff_city }}</th>
                                            </tr>
                                            <tr>
                                                <td>خط السير</td>
                                                <th>{{ $trip->lines_trip }}</th>
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
                                            <tr>
                                                <td>
                                                    <a href="{{ route('passengers.hajDetails', ['id' => $trip->trip_id]) }}" class="btn btn-outline-secondary">التفاصيل</a>
                                                </td>
                                                <th>
                                                    <a href="{{ route('passengers.hajCheckout', ['id' => $trip->trip_id]) }}" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>حجز</a>
                                                </th>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            
                        </div>
                        @endforeach
                        @endif
                    </div>




                </div>
            </div>

        </div>

    </div>
</div>

@endsection

@section('js')
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="{{ asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>


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
