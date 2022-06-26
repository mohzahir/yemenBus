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

@section('content_header')
    <h1>ارسال رسالة الى مسافر </h1>
@stop

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;margin-top:100px;">
    <nav aria-label="breadcrumb" style="margin-top:-50px;" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">رسالة الى مسافر</li>
  </ol>
</nav>
@include('flash-message')
  <h1>ارسال رسالة الى مسافر </h1>
    <form method="post" action="{{route('admin.passenger.storesms')}}" class="pb-4 @if ($errors->any()) was-validated @endif" 
        style=" margin-bottom:40px;" >
        @csrf
 <input type="hidden" class="form-control" id="admin_id" name="user_id"  value="{{Auth::guard('admin')->user()->id}}" >

       
        <div class="form-group mt-2">
            <label for="passenger_phone">جوال المسافر السعودي</label>
        <input type="text" class="form-control" id="s_phone" name="s_phone" 
        placeholder=" " @if($country =='s') value="{{$phone}}" @endif >
        </div>
        <div class="form-group mt-2">
            <label for="passenger_phone">جوال المسافر اليمني  </label>
           <input type="text" class="form-control" id="y_phone" name="y_phone"
            placeholder="" @if($country == 'y') value="{{$phone}}" @endif >
        </div>
       
        <div class="form-group mt-2">
            <label for="message">الرسالة</label>
            <textarea class="form-control" id="message"  name="message"></textarea>
        </div>
        <button class="btn btn-success btn-lg" type="submit">أرسل الرسالة</button>
    </form>
    </div>
@stop

@section('script')
    <script>
     
</script>
@endsection