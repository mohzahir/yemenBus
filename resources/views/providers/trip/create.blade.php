@extends('layouts.providerDashboard')
@section('style')
    <meta name="_token" content="{{ csrf_token() }}" />
    <link href="{{ asset('css/ar.css') }}" rel="stylesheet" class="lang_css arabic">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap"
        rel="stylesheet">
    <meta name="_token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="{{ asset('plugin/ckeditor/ckeditor.js') }}"></script>


    <link rel="stylesheet" href="{{ asset('select/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('select/dist/css/select2.css') }}" />

    <style type="text/css">
        .dropdown-toggle {
            height: 40px;
            width: 400px !important;
        }

        input[type="time"] {
            align-items: center;
            display: -webkit-inline-flex;
            font-family: monospace;
            padding-inline-start: 1px;
            cursor: default;
            overflow: hidden;
            padding: 0px;
        }

        h1,
        h2,
        h3 {
            font-family: 'Cairo', sans-serif;
        }

        p {
            font-family: 'Cairo', sans-serif;
            font-size: 20px;

        }

        label {
            font-family: 'Cairo', sans-serif;
            font-size: 16px;

        }

        .tm-tag.tm-tag-info {
            color: #fff;
            background-color: #007bff;
            border-color: #194a82;
        }

        a.tm-tag-remove {
            color: #fff !important;
            opacity: 0.4;
        }

    </style>
@endsection
@section('content_header')
    <h1>تأكيد حجز</h1>
@endsection

@section('content')
    <div class="container col-md-12 col-md-8 col-sm-12 col-xs-" style="margin-left:70px;">
        <nav aria-label="breadcrumb" style="margin-top:-50px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.provider.showAccountInfo') }}"> <span
                            class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
                <li class="breadcrumb-item active" aria-current="page">اضافة رحلة</li>
            </ol>
        </nav>
        @include('flash-message')

        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">اضافة الرحلة </h1>
            </div>
            <div class="panel-body">
                <form action="{{ route('provider.trip.store') }}"
                    class="pb-4 @if ($errors->any()) was-validated @endif" method="post"
                    style="margin-top: 20px;margin-bottom:40px;" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-2" x-data="{
                        haj_is_active: {{ $service_id == 3 }},
                    }">
                        <div>
                            <input type="hidden" name="provider_id" value="{{ auth()->guard('provider')->user()->id }}">
                        </div>
                        <div class="form-group">
                            <label for="order_id"> الخدمة الفرعية </label>
                            <select class="form-control" name="sub_service_id" required>
                                <option value=""> -- اختر الخدمه الفرعيه -- </option>
                                @foreach ($sub_services as $sub_service)
                                    <option value="{{ $sub_service->id }}">{{ $sub_service->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div x-show="haj_is_active" class="row" x-transition>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""> نوع الرحله </label> <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="radio" id="" name="air_river" value="air"> جوا
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="radio" id="" name="air_river" value="river"> برا
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">عدد ايام البرنامج</label> <br>
                                    <input type="number" name="days_count" class="form-control">
                                </div>
                            </div>
                        </div>


                        <template x-if="!haj_is_active">
                            <div class="form-group mt-2">
                                <label for="order_id">اتجاه الرحله </label>
                                <select class="form-control direcation" name="direcation" required>
                                    <option value=""> -- اختر--</option>
                                    <option value="yts"> من اليمن للسعوديه </option>
                                    <option value="sty"> من السعوديه لليمن </option>
                                    <option value="loc">بين المدن اليمنيه</option>
                                </select>
                            </div>
                        </template>

                        <template x-if="haj_is_active">
                            <input type="hidden" name="direcation" value="sty">
                        </template>

                        <div class="row">
                            @php $cities= App\City::all(); @endphp

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="arrival_city_id">الى مدينة </label>
                                    <select name="arrival_city_id" id="arrival_city_id" class="form-control">
                                        <option value=""> -- اختر--</option>
                                        @foreach ($cities as $city)
                                            <option data-country="{{ $city->country }}" value="{{ $city->id }}">
                                                {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="takeoff_city_id">من مدينة </label>
                                    <select name="takeoff_city_id" id="takeoff_city_id" class="form-control">
                                        <option value=""> -- اختر--</option>
                                        @foreach ($cities as $city)
                                            <option data-country="{{ $city->country }}" value="{{ $city->id }}">
                                                {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="form-group mt-2">
                            <label for="price">سعر الرحلة </label> - <span class="currency"></span>
                            <input type="text" class="form-control" id="price" name="price" required>
                        </div>

                        <div class="form-group mt-10" style="margin-top:10px;">
                            <label for="order_url">خط سير الرحلة بالمدن التالية: </label>
                            <input type="text" name="lines_trip" id="lines_trip" data-role="tagsinput"
                                placeholder="خط السير" class="tm-input form-control tm-input-info" />

                        </div>

                        <div class="row">
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label for="date"> الى تاريخ </label>
                                    <input type="date" class="form-control" id="to_date" name="to_date" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date"> من تاريخ </label>
                                    <input type="date" class="form-control" id="from_date" name="from_date" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="days">اليوم</label>

                                    <select name="day[]" class=" form-control " id="select2" required>
                                        <option id="sat" value="sat">السبت</option>
                                        <option id="sun" value="sun">الاحد </option>
                                        <option id="mon" value="mon">الاثنين </option>
                                        <option id="tue" value="tue">الثلاثاء </option>
                                        <option id="wed" value="wed">الاربعاء </option>
                                        <option id="thu" value="thu">الخميس </option>
                                        <option id="fri" value="fri">الجمعة </option>

                                    </select>

                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group mx-5 my-5">
                                    <label for="inputMDEx1">حدد ساعة الحضور</label>

                                    <input type="time" id="inputMDEx1" class="form-control" name="coming_time">
                                    <span style="color:red;font-size:12px;margin-right:10px">ملاحظه://ساعة الحضور قبل موعد
                                        الحركة بساعتين</span>
                                </div>

                            </div>
                            <div class="col-sm-3">
                                <div class="form-group mx-5 my-5">
                                    <label for="inputMDEx2">حدد ساعة الحركة</label>

                                    <input type="time" id="inputMDEx2" class="form-control" name="leave_time">
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label for="no_ticket">عدد التذاكر </label>
                                    <input type="number" min="0" class="form-control" name="no_ticket">
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label for="weight">وزن العفش </label>
                                    <input type="number" min="1" class="form-control" name="weight">
                                </div>
                            </div>
                        </div>





                        <div class="form-group mt-2">
                            <label for="note">ملاحظة </label>
                            <textarea type="text" class="form-control" name="note"></textarea>
                        </div>
                        <div x-show="haj_is_active" class="form-group mt-2" x-transition>
                            <label for="program_details_page_content"> محتوى صفحه تفاصيل البرنامج </label>
                            <textarea x-init="CKEDITOR.replace($el)" type="file" class="form-control cke_rtl" name="program_details_page_content">

                            </textarea>
                        </div>
                        <div x-show="haj_is_active" class="form-group mt-2" x-transition>
                            <label for="program_details_file"> ملف تفاصيل البرنامج </label>
                            <input type="file" class="form-control" name="program_details_file">
                        </div>
                        <button type="submit" class="btn btn-success btn-lg">اضافه الرحلة </button>
                        {{-- <a class="btn btn-success btn-lg" href="{{route('provider.trip.create')}}">اضافه رحلة جديدة</a> --}}
                        {{-- <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a> --}}
                        <a class="btn btn-danger btn-close btn-lg" href="{{ route('provider.trip.index') }}">اغلاق</a>



                        <!-- TODO confirmation message after submission:
                                                سوف يتم خصم مبلغ الحجز () ريال. / سعودي. /يمني. من رصيدك ... -->
                </form>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script src="{{ asset('select/dist/js/select2.full.min.js') }}"></script>

    <script>
        $('#select2').select2({
            data: ["all", "sat", "sun", "mon", "tue", "tue", "wed", "thu", "fri"],
            tags: true,
            maximumSelectionLength: 10,
            tokenSeparators: [',', ' '],
            placeholder: "حدد الايام",
            dir: "rtl",

            //minimumInputLength: 1,
            //ajax: {
            //   url: "you url to data",
            //   dataType: 'json',
            //  quietMillis: 250,
            //  data: function (term, page) {
            //     return {
            //         q: term, // search term
            //    };
            //  },
            //  results: function (data, page) { 
            //  return { results: data.items };
            //   },
            //   cache: true
            // }
        });
        $('#select3').select2({
            data: ["1", "2", "3", "4"],
            tags: true,
            maximumSelectionLength: 10,
            tokenSeparators: [',', ' '],
            placeholder: "حدد النوع",
            dir: "rtl",

            //minimumInputLength: 1,
            //ajax: {
            //   url: "you url to data",
            //   dataType: 'json',
            //  quietMillis: 250,
            //  data: function (term, page) {
            //     return {
            //         q: term, // search term
            //    };
            //  },
            //  results: function (data, page) { 
            //  return { results: data.items };
            //   },
            //   cache: true
            // }
        });
    </script>



    <script type="text/javascript">
        $('#date').on('change', function(e) {
            e.preventDefault();
            $date = $('#date').val();
            $.ajax({
                type: 'get',
                url: '{{ route('date') }}',
                data: {
                    'date': $date,

                    '_token': '{{ csrf_token() }}',


                },
                success: function(data) {
                    $('#' + data).attr('selected', 'true');
                }
            });
        })
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'csrftoken': '{{ csrf_token() }}'
            }
        });
    </script>
@endsection
