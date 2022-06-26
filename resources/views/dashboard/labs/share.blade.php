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
    <li class="breadcrumb-item active" aria-current="page">  شارك موقع</li>
  </ol>
</nav>

   <h1  style="display: inline-block">شارك موقع {{$lab->name}}</h1>
@include('flash-message')

    <form method="post" action="{{route('admin.lab.shareSend',$lab->id)}}" class="pb-4 @if ($errors->any()) was-validated @endif" >
        @csrf
 

        <div class="form-group mt-2">
            <label for="passenger_phone">اسم المختبر</label>
            <input   class="form-control" name="name"   value="{{$lab->name}}" disabled >
        </div>
      
        <div class="form-group mt-2">
            <label for="phone"> رقم الجوال السعودي</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="مثال 0501234567"  >
        </div>
        
         <div class="form-group mt-2">
            <label for="y_phone"> رقم الجوال اليمني</label>
            <input type="text" class="form-control" id="y_phone" name="y_phone" placeholder="مثال 701234567"  >
        </div>
       
        <button  type="submit" class="btn btn-success btn-lg">شارك الموقع</button>
        
     
         
         <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a>
     <a class="btn btn-danger btn-close btn-lg" href="{{ route('admin.lab.index') }}">اغلاق</a>
        
        </form>
    </div>
@stop

@section('script')
   
<script type="text/javascript">
$('#phone').click(function () {
    document.getElementById('phone').type = 'number';
});

</script>
@endsection