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

@include('incs.headerFormTrip')








<div class="whole-wrap">
    <div class="container box_1170">
        @php $yCurrency= 'ريال يمني'; @endphp
        <div class="section-top-border">

            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-12">
                                <h1 class="text-center">جميع الرحلات بشركة نقل الركاب بالباصات</h1>
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
                                <a href="{{ route('passengers.home', ['slug' => 'bus']) }}" class="btn btn-sm btn-danger pull-left"><i class="fa fa-times-circle"></i>
                                    تفريغ</a>
                            </h3>
                        </div>
                        <div class="card-body">
                            <form method="GET">
                                @csrf
                                <table class="table">
                                    <tr>
                                        <td style="width: 110px;">اتجاه الرحلة </td>
                                        <th>
                                            <label class="mx-3">
                                                <input value="sty" @if (request('direcation')=='sty' ) checked @endif type="radio" name="direcation" class="radio"> من السعودية لليمن
                                            </label>
                                            <!-- <br> -->
                                            <label class="mx-3" for="">
                                                <input value="yts" @if (request('direcation')=='yts' ) checked @endif type="radio" name="direcation" class="radio">
                                                من اليمن للسعودية
                                            </label>
                                            <label class="mx-3" for="">
                                                <input value="loc" @if (request('direcation')=='loc' ) checked @endif type="radio" name="direcation" class="radio">
                                                بين المدن اليمنية
                                            </label>
                                        </th>
                                    </tr>
                                </table>
                                <div class="form-group">
                                    <label for="">بدايه الرحله</label>
                                    <select class="form-control w-100" name="takeoff_city_id" id="">
                                        <option value="">-- المدن اليمنية --</option>
                                        <option value="">كل المدن اليمنية</option>
                                        @foreach ($yamen_cities as $city)
                                        <option value="{{ $city->id }}" @if (request('takeoff_city_id')==$city->id) selected @endif>{{ $city->name }}
                                        </option>
                                        @endforeach
                                        <option value="">-- المدن السعودية --</option>
                                        <option value="">كل المدن السعودية</option>
                                        @foreach ($saudi_cities as $city)
                                        <option value="{{ $city->id }}" @if (request('takeoff_city_id')==$city->id) selected @endif>{{ $city->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">السعر اقل من</label>
                                    <input type="text" name="price" value="{{ request('price') }}" class="form-control">
                                </div>
                                <button class="btn btn-default btn-sm btn-primary"><i class="fa fa-pencil"></i>
                                    بحث</button>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="col-md-9">
                    <div class="row">
                        @if(count($trips) > 0)
                        @foreach ($trips as $trip)
                
                        <div class="col-md-6">
                            <div id="order-summary" class="box">
                                <div class="box-header">
                                    <h3 class="mb-0"> <strong>المنظم شركة</strong> {{ $trip->provider->name_company }} </h3>
                                </div>
                                <!-- <p class="text-muted">هنا يمكنك تتبع مختصر تفاصيل البرنامج</p> -->
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>عنوان البرنامج</td>
                                                <th>{{ $trip->title ?? '-'}}</th>
                                            </tr>
                                            <tr>
                                                <td>المغادرة من مدينة</td>
                                                <th>{{ $trip->takeoff_city->name }}</th>
                                            </tr>
                                            <tr>
                                                <td>الوصول الى مدينة</td>
                                                <th>{{ $trip->arrival_city->name }}</th>
                                            </tr>
                                            <tr>
                                                <td>رقم الرحله</td>
                                                <th>{{ $trip->id }}</th>
                                            </tr>
                                            
                                            <tr>
                                                <td>التاريخ</td>
                                                <th>{{ $trip->from_date }}</th>
                                            </tr>
                                            <tr>
                                                <td>متاحة يوم</td>
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
                                                <td>سعر التزكرة </td>
                                                <th> <span class="text-warning"> {{ $trip->price }} {{ $trip->direcation == 'sty' ? 'ر.س' : 'ر.ي' }}</span></th>
                                            </tr>
                                            <tr>
                                                <td> عربون التأكيد الحجز</td>
                                                <th>{{ $trip->deposit_price ? $trip->deposit_price : ($trip->direcation == 'sty' ? $BUS_RS_DEPOSIT_VALUE : $BUS_RY_DEPOSIT_VALUE) }}  {{ $trip->direcation == 'sty' ? 'ر.س' : 'ر.ي' }}</th>
                                            </tr>
                                            <!-- <tr>
                                                <td>نوع البرنامج</td>
                                                <th>{{ $trip->sub_service_id == '1' ? 'عمرة' : 'حج' }}</th>
                                            </tr> -->
                                            <!-- <tr>
                                            <td>التنظيم</td>
                                            <th>{{ $trip->name_company }}</th>
                                        </tr> -->
                                            <!-- <tr>
                                                <td>جهة الصعود</td>
                                                <th>{{ $trip->air_river == 'air' ? 'جوا' : 'برا' }}</th>
                                            </tr> -->
                                            <!-- <tr>
                                                <td>مكان التجمع</td>
                                                <th>{{ $trip->takeoff_city->name }}</th>
                                            </tr> -->
                                            <!-- <tr>
                                                <td>خط السير</td>
                                                <th>{{ $trip->lines_trip }}</th>
                                            </tr> -->
                                            <tr>
                                                <td>وقت الحركة</td>
                                                <th>{{ date('h:i', strtotime($trip->leave_time)) }} {{ $trip->time_zone }}</th>
                                            </tr>
                                            <tr>
                                                <td>وقت الحضور</td>
                                                <th>{{ date('h:i', strtotime($trip->coming_time)) }}</th>
                                            </tr>
                                            <tr>
                                                <td>وزن العفش </td>
                                                <th>{{ $trip->weight }} كجم</th>
                                            </tr>
                                            <!-- <tr>
                                                <td>تاريخ العودة</td>
                                                <th>{{ $trip->to_date }}</th>
                                            </tr> -->
                                            <tr>
                                                <td>
                                                    <a href="{{ route('passengers.busDetails', ['id' => $trip->id]) }}" class="btn btn-outline-secondary">التفاصيل</a>
                                                </td>
                                                <th>
                                                    <a href="{{ route('passengers.reserveTrips', ['id' => $trip->id]) }}" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>حجز</a>
                                                </th>
                                            </tr>
                
                                        </tbody>
                                    </table>
                
                                </div>
                            </div>
                            
                            
                        </div>
                        @endforeach
                        @else
                        <div class="col-md-12">
                            <div class="box">
                                <p class="text-danger text-center">لايوجد رحلات لهذه الفئة</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    {{ $trips->links() }}




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