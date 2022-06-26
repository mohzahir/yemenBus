@extends('layouts.admin')
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



@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;margin-top:30px;">
<nav aria-label="breadcrumb"  >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">  ارسال رسالة</li>
  </ol>
</nav>

   <h1  style="display: inline-block">ارسال رسالة</h1>
@include('flash-message')

    <form method="post" action="{{route('dashboard.providers.sendPsms.store')}}" class="pb-4 @if ($errors->any()) was-validated @endif" >
        @csrf
 
<input  name="user_id" value="{{Auth::guard('admin')->user()->id}}" type="hidden">
        
        <div class="form-group mt-2">
            <label for="passenger_phone">اسم الشركة</label>
 <input   class="form-control" name="code"   value="{{$provider->name_company}}" disabled >
        </div>
        <div class="form-group mt-2">
            <label for="passenger_phone"> رقم جوال السعودي</label>
            <input   class="form-control" id="phone" name="phone" placeholder="مثال 0598745632" @if($provider->phone) value="{{$provider->phone}}" @endif >
        </div>
        <div class="form-group mt-2">
            <label for="y_phone"> رقم الجوال اليمني</label>
            <input type="text" class="form-control" id="y_phone" name="y_phone" placeholder="مثال 712313131"   @if($provider->y_phone) value="{{$provider->y_phone}}" @endif >
        </div>
        
        <div class="form-group mt-2">
            <label for="subject">موضوع الرسالة</label>
            <input type="text" class="form-control" name="subject" id="subject" required>
        </div>
        <div class="form-group mt-2">
            <label for="message">الرسالة</label>
            <textarea class="form-control" id="message"  name="message"></textarea>
        </div>
        <button  type="submit" class="btn btn-success btn-lg">أرسل الرسالة</button>
        
     
         
         <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a>
     <a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.providers.index') }}">اغلاق</a>
        
        </form>
    </div>
@stop

@section('script')
    <script>
        $('#postpone_to').attr('min', new Date().toISOString().split('T')[0]);
    </script>
<script type="text/javascript">
$('#phone').click(function () {
    document.getElementById('phone').type = 'number';
});
$('#y_phone').click(function () {
    document.getElementById('y_phone').type = 'number';
});
</script>
@endsection