@extends('layouts.dashboard')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
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
@section('style')

<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
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
    <h1>اراسال رسالة الى عميل </h1>
@stop

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;margin-top:30px;">
                  <nav aria-label="breadcrumb" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.marketer.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">  ارسال  رسالة</li>
  </ol>
</nav>
<h1 style="text-align:center">ارسال رسالة الى عميل</h1>

@include('flash-message')
<span style="width:100%;color:red;font-size:18px;">ملاحظة ::</span>
<span style="width:100%;color:black;font-size:14px;">  رقم  الجوال بلارقام التالية :1234567890  </span>

    <form method="post" action="{{route('dashboard.marketer.storeSms')}}" class="pb-4 @if ($errors->any()) was-validated @endif" style="margin-bottom:40px;">
        @csrf
                    <input type="hidden" class="form-control" id="order_id" name="user_id"  value="{{Auth::guard('marketer')->user()->id}}"  >
        
        <div class="form-group mt-2">
            <label for="passenger_phone">جوال المسافر</label>
            <input type="text" class="form-control" id="passenger_phone" name="passenger_phone" placeholder="مثال +9661231313131" @if($reservation) value="{{$reservation->passenger->phone}}" @endif >
        </div>
        <div class="form-group mt-2">
            <label for="passenger_phone_yem"> رقم الجوال اليمني</label>
            <input type="text" class="form-control" id="passenger_phone_yem" name="passenger_phone_yem" placeholder="مثال +9661231313131" @if($reservation) value="{{$reservation->passenger->y_phone}}" @endif >
        </div>
        <!-- @if($reservation)
        <div class="form-group mt-2">
            <label for="currency">العملة</label>
            <select name="currency" class="form-control" id="currency" >
                <option value="sar">ريال سعودي</option>
                <option value="yer">ريال يمني</option>
            </select>
        </div>
        <div class="form-group mt-2">
            <label for="amount">المبلغ</label>
            <input type="number" min="1" class="form-control" id="amount" name="amount" @if($reservation) value="{{$reservation->amount}}" required @endif  >
        </div>
        @endif -->
        
        <div class="form-group mt-2">
            <label for="message">الرسالة</label>
            <textarea class="form-control" id="message"  name="message"></textarea>
        </div>
        <button class="btn btn-success btn-lg" type="submit">أرسل الرسالة</button>
    
  <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a><a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.marketer.index') }}">اغلاق</a>

    </form>
    </div>
@stop

@section('script')
    <script>
        $('#postpone_to').attr('min', new Date().toISOString().split('T')[0]);
    </script>
<script type="text/javascript">
$('#passenger_phone').click(function () {
    document.getElementById('passenger_phone').type = 'number';
});
$('#passenger_phone_yem').click(function () {
    document.getElementById('passenger_phone_yem').type = 'number';
});
</script>
@endsection