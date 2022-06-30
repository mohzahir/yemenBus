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
                                                <td>اليوم</td>
                                                <th>{{ $trip->day }}</th>
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
                                                <th>{{ $trip->sub_service_id == 2 ? $haj_deposit_value : $omra_deposit_value }}</th>
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
