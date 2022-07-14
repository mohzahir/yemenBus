@extends('layouts.admin')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link
    href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap"
    rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{asset('select/dist/css/select2.min.css')}}" />
<link rel="stylesheet" href="{{asset('select/dist/css/select2.css')}}" />

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
<h1>تعديل الرحلات </h1>
@endsection

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 ">
    <nav aria-label="breadcrumb" style="margin-top:-50px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span
                        class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
            <li class="breadcrumb-item active" aria-current="page">تعديل رحلة </li>
        </ol>
    </nav>
    @include('flash-message')
    <h1 style="text-align:center">تعديل الرحلة </h1>

    <form action="{{ route('dashboard.provider.trip.update',$trip->id) }}"
        class="pb-4 @if ($errors->any()) was-validated @endif" method="POST" style=" margin-bottom:40px;">
        @csrf
        @method('put')

        <div class="row">
            @php $cities= App\City::all(); @endphp

            <div class="col-md-12 mt-2">
                <label for="takeoff_city_id">العنوان </label>
                <input type="text" class="form-control" name="title" placeholder="عنوان البرنامخ (اختياري)" value="{{ $trip->title }}">
            </div>
            <div class="col-md-12 mt-2">
                <label for="takeoff_city_id">من مدينة </label>
                <select name="takeoff_city_id" id="takeoff_city_id" class="form-control">
                    <option value=""> -- اختر--</option>
                    @foreach($cities as $city)
                    <option data-country="{{$city->country}}" @if($trip->takeoff_city_id == $city->id) selected @endif
                        value="{{$city->id}}"> {{$city->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mt-2">
                <label for="arrival_city_id">الى مدينة </label>
                <select name="arrival_city_id" id="arrival_city_id" class="form-control to">
                    <option value=""> -- اختر--</option>
                    @foreach($cities as $city)
                    <option data-country="{{$city->country}}" @if($trip->arrival_city_id == $city->id) selected @endif
                        value="{{$city->id}}"> {{$city->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group mt-2">
            <label for="order_id">اتجاه الرحله </label>
            <select class="form-control direcation" name="direcation" required>

                <option value="yts" @if($trip->direcation=='yts')selected @endif> من اليمن للسعوديه </option>
                <option value="sty" @if($trip->direcation=='sty')selected @endif> من السعوديه لليمن </option>
                <option value="loc" @if($trip->direcation=='loc')selected @endif>بين المدن اليمنيه</option>
            </select>

        </div>
        <div class="form-group mt-2">
            <label for="price">سعر الرحلة </label> - <span class="currency"></span>
            <input type="text" class="form-control" id="price" name="price" value="{{$trip->price}}" required>
        </div>

        <div class="form-group mt-10" style="margin-top:10px;">
            <label for="order_url">خط سير الرحلة بالمدن التالية: </label>
            <input type="text" name="lines_trip" id="lines_trip" data-role="tagsinput"
                @if($trip->lines_trip)value="{{$trip->lines_trip}}"@endif placeholder="خط السير" class="tm-input
            form-control tm-input-info"/>

        </div>

        <div class="form-group mt-2">
            <label for="date"> من تاريخ </label>
            <input type="date" class="form-control" value="{{$trip->from_date}}" id="from_date" name="from_date"
                required>
        </div>
        <div class="form-group mt-2">
            <label for="date"> الى تاريخ </label>
            <input type="date" class="form-control" id="to_date" name="to_date" value="{{$trip->to_date}}" required>
        </div>


        <div class="form-group mt-2">
            <label for="days">اليوم</label>

            <select name="day" class=" form-control " required>
                <option @if($trip->day == 'sat') selected @endif id="sat" value="sat">السبت</option>
                <option @if($trip->day == 'sun') selected @endif id="sun" value="sun">الاحد </option>
                <option @if($trip->day == 'mon') selected @endif id="mon" value="mon">الاثنين </option>
                <option @if($trip->day == 'tue') selected @endif id="tue" value="tue">الثلاثاء </option>
                <option @if($trip->day == 'wed') selected @endif id="wed" value="wed">الاربعاء </option>
                <option @if($trip->day == 'thu') selected @endif id="thu" value="thu">الخميس </option>
                <option @if($trip->day == 'fri') selected @endif id="fri" value="fri">الجمعة </option>

            </select>

        </div>
        <div class="form-group mt-2">
            <label for="date"> عدد التذاكر </label>
            <input type="number" class="form-control" id="number" name="no_ticket"
                @if($trip->no_ticket)value="{{$trip->no_ticket}}"@endif>
        </div>

        <div class="md-form mx-5 my-5">
            <label for="inputMDEx1">حدد ساعة الحضور</label>

            <input type="time" id="inputMDEx1" class="form-control" name="coming_time"
                @if($trip->coming_time)value="{{$trip->coming_time}}"@endif>
        </div>
        <span style="color:red;font-size:16px;margin-right:10px">ملاحظه://ساعة الحضور قبل موعد الحركة بساعتين</span>

        <div class="md-form mx-5 my-5">
            <label for="inputMDEx2">حدد ساعة الحركة</label>

            <input type="time" id="inputMDEx2" class="form-control" name="leave_time"
                @if($trip->leave_time)value="{{$trip->leave_time}}"@endif>
        </div>


        <div class="form-group mt-2">
            <label for="no_ticket">عدد التذاكر </label>
            <input type="number" min="0" class="form-control" name="no_ticket"
                @if($trip->no_ticket)value="{{$trip->no_ticket}}"@endif>
        </div>

        <div class="form-group mt-2">
            <label for="weight">وزن العفش </label>
            <input type="number" min="1" class="form-control" name="weight"
                @if($trip->weight)value="{{$trip->weight}}"@endif>
        </div>
        {{-- <div class="form-group mt-2">
            <label for="trip_no"> رقم الرحلة </label>
            <input type="text" @if($trip->trip_no)value="{{$trip->trip_no}}"@endif class="form-control" name="trip_no">
        </div> --}}
        <div class="form-group mt-2">
            <label for="note">ملاحظة </label>
            <input type="text" @if($trip->note)value="{{$trip->note}}"@endif class="form-control" name="note">
        </div>
        <button type="submit" class="btn btn-success btn-lg">تعديل</button>
        <a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.providers.trips') }}">اغلاق</a>


        <!-- TODO confirmation message after submission: 
            سوف يتم خصم مبلغ الحجز () ريال. / سعودي. /يمني. من رصيدك ... -->
    </form>
</div>
@endsection
@section('script')
<script src="{{asset('select/dist/js/select2.full.min.js')}}"></script>

<script>
    $('#select2').select2({
            data:  ["all","sat","sun","mon","tue","tue","wed","thu","fri"],
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
</script>

<script type="text/javascript">
    $('#date').on('change',function(e){
        e.preventDefault();
        $date=$('#date').val();
        $.ajax({
            type : 'get',
            url : '{{route('dashboard.provider.trip.date')}}',
            data:{
            'date':$date,
            
            '_token':'{{csrf_token()}}',


            },
            success:function(data){
                $('#'+data).attr('selected','true');
            }
        });
    })

    
    $('#to').on('change', function(){
        let from =$('#from').find(':selected').data('country')
        let to = $(this).find(':selected').data('country')

        if(from == 1 && to == 2){
          $('.direcation').val('dep')
          $('.currency').text('ريال سعودي')

        }else if(from == 2 && to== 1){
         $('.direcation').val('com')
         $('.currency').text('ريال يمنى')

        }else if(from == 2 && to== 2){
            $('.direcation').val('loc')
            $('.currency').text('ريال يمنى')

        }


    })
</script>
<script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
@endsection