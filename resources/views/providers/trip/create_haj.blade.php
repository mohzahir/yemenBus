@extends('layouts.providerDashboard')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
  <meta name="_token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
            integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('select/dist/css/select2.min.css')}}" />
    <link rel="stylesheet" href="{{asset('select/dist/css/select2.css')}}" /> 

    <style type="text/css">
        .dropdown-toggle{
            height: 40px;
            width: 400px !important;
        }
input[type="time"]
{align-items: center;
    display: -webkit-inline-flex;
    font-family: monospace;
    padding-inline-start: 1px;
    cursor: default;
    overflow: hidden;
    padding: 0px;
}
 
h1,h2,h3{
font-family: 'Cairo', sans-serif;
}
p{
    font-family: 'Cairo', sans-serif;
    font-size:20px;

}
label{
    font-family: 'Cairo', sans-serif;
    font-size:16px;
 
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
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
     <nav aria-label="breadcrumb" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.provider.showAccountInfo')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page"> اضافة رحلة </li>
  </ol>
</nav>
<h1 style="text-align:center"> اضافة رحلة حج و عمرة </h1>
@include('flash-message')

    <form action="{{ route('provider.trip.store_haj') }}" class="pb-4 @if ($errors->any()) was-validated @endif" method="post" style="margin-bottom:40px;">
        @csrf
   <input type="hidden" name="provider_id" value="{{Auth::guard('provider')->user()->id}}">
   <input type="hidden" name="haj" value="1">
        
   <div class="row">
    <div class="col-md-12 mt-2">
        <label for="from">من مدينة </label>
        <select  class="form-control" name="from" required>
        @php $cities= App\City::all(); @endphp

            @foreach ($cities as $city)
            <option value="{{$city->id}}" >{{$city->name}}  </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12 mt-2">
        <label for="to">الى  مدينة </label>
        <select  class="form-control" name="to" required>
        @php $cities= App\City::all(); @endphp

            @foreach ($cities as $city)
            <option value="{{$city->id}}" >{{$city->name}}  </option>
            @endforeach
        </select>
    </div>
</div>

   <div class="form-group mt-2">
            <label for="order_id">اتجاه الرحله </label>
        <select  class="form-control" name="direcation" required>
            <option value="sty" >من السعودية الى اليمن  </option>
            <option value="yts">من اليمن الى  السعودية </option>
            <option value="byc" >بين المدن  اليمنيه</option>
        </select>
    <div class="form-group mt-2">
            <label for="order_url">سعر الرحلة </label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
           
        </div>
       
<div class="form-group mt-10"  style="margin-top:10px;">
            <label for="order_url">خط سير الرحلة بالمدن التالية: </label>
            <input type="text" name="lines_trip" id="lines_trip"  data-role="tagsinput"  placeholder="خط السير" class="tm-input form-control tm-input-info"/>

        </div>
        
        <div class="form-group mt-2">
            <label for="date">  من تاريخ  </label>
            <input type="date" class="form-control" id="from_date" name="from_date" required >
        </div>
        <div class="form-group mt-2">
            <label for="date">  الى تاريخ  </label>
            <input type="date" class="form-control" id="to_date" name="to_date"  required>
        </div>
        
        
               <div class="form-group mt-2">
            <label for="days">اليوم</label>

<select name="day[]" class=" form-control " data-live-search="true"  id="select2"   multiple required>
                <option  id="all" value="all">كل  يوم </option>
                <option id="sat" value="sat">السبت</option>
                <option  id="sun"value="sun">الاحد </option>
                <option  id="mon" value="mon">الاثنين </option>
                <option id="tue" value="tue">الثلاثاء </option>
                <option id="wed" value="wed">الاربعاء </option>
                <option id="thu" value="thu">الخميس </option>
                <option id="fri" value="fri">الجمعة </option>
               
            </select> 

     </div>

         
        
        <div class="form-group mt-2">
            <label for="no_ticket"> عدد التذاكر  </label>
        <input type="number" class="form-control" id="number" name="no_ticket" >
        </div>
        <div class="md-form mx-5 my-5">
         <label for="inputMDEx1">حدد ساعة الحضور</label>

            <input type="time" id="inputMDEx1" class="form-control" name="coming_time">
        </div>
                <span style="color:red;font-size:16px;margin-right:10px">ملاحظه://ساعة الحضور قبل موعد الحركة بساعتين</span>

        <div class="md-form mx-5 my-5">
          <label for="inputMDEx2">حدد ساعة  الحركة</label>

            <input type="time" id="inputMDEx2" class="form-control" name="leave_time">
        </div>
        
       
      
        <div class="form-group mt-2">
            <label for="trip_no"> رقم الرحلة </label>
            <input type="text"  class="form-control" name="trip_no">
        </div>
        <div class="form-group mt-2">
            <label for="note">ملاحظة </label>
            <input type="text"  class="form-control" name="note">
        </div>
        <button type="submit" class="btn btn-success btn-lg">اضافة </button>
        
  <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a><a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.provider.showAccountInfo') }}">اغلاق</a>
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
        $('#select3').select2({
            data:  ["1","2","3","4"],
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
$('#date').on('change',function(e){
  e.preventDefault();
$date=$('#date').val();
$.ajax({
type : 'get',
url : '{{route('date')}}',
data:{
  'date':$date,
 
  '_token':'{{csrf_token()}}',


},
success:function(data){
$('#'+data).attr('selected','true');
}
});
})
</script>
<script type="text/javascript">
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
@endsection