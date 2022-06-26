@extends('layouts.labDashboard')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

<!-- Optional theme -->
<!-- Latest compiled and minified CSS -->


<!-- Optional theme -->


<script src="{{asset('js/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="{{asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.css')}}">
  <link rel="stylesheet" href="{{asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">


  <style>
 
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
</style>
@endsection
@section('content_header')
    <h1>طلب تأجيل حجز</h1>
@stop

@section('content')

<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px">
              <nav aria-label="breadcrumb" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.lab.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">  تحديد موعد الفحص  </li>
  </ol>
</nav>
<h1 style="text-align:center">تحديد موعد الفحص</h1>
@include('flash-message')
  

<form id="myForm" class="pb-4 @if ($errors->any()) was-validated @endif" action="{{route('dashboard.lab.checkedDate',$id)}}" style="margin-bottom:40px;">
    @csrf

 <div class="form-group mt-2">
            <label for="day">اليوم</label>
            <select name="day" class="form-control" id="day" required>
                <option value=""  selected  >-- اختر -- </option>
                 <option id="sat"  value="sat" selected  >السبت</option>
                <option  id="sun"value="sun" selected >الاحد </option>
                <option  id="mon" value="mon" selected >الاثنين </option>
                <option id="tue" value="tue" selected >الثلاثاء </option>
                <option id="wed" value="wed" selected >الاربعاء </option>
                <option id="thu" value="thu" selected >الخميس </option>
                <option id="fri" value="fri" selected >الجمعة </option>>
                
            </select>        </div>



        <div class="form-group mt-2">
            <label for="date"> تحديد الموعد </label>
            <input type="text" class="form-control" name="date_at"   id="date_at" required  >
                
        </div>
        <button class="btn btn-success btn-lg" type="submit">حفظ</button>
        
  <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a><a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.lab.pcrsSuspend') }}">اغلاق</a>

    </form>
    </div>
@stop
@section('script')

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script  src="{{asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>

<script  src="{{asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>


    <script>
jQuery(document).ready(function(){

    $('#date_at').datetimepicker({
        useCurrent: false,
                stepping: 60,
                format: 'yyyy-mm-dd hh:ii',
                timeZone: 'Asia/Aden',
            });
   
    $("#date_at").on("dp.change", function(e) {
      $('#finish_at').data("DateTimePicker").minDate(e.date);
    });
    
  });
</script>
@endsection

