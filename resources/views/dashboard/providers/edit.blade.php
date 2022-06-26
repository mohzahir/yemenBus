

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
@section('content_header')
<h1> ادارة بيانات  {{$provider->name}} </h1>
@stop

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
     <nav aria-label="breadcrumb" style="margin-top:-50px;" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل بيانات المزود</li>
  </ol>
</nav>
   <h1 style ="text-align:center">تعديل بيانات المزود</h1>

    <form method="get" action="{{ route('dashboard.providers.update',$provider->id) }}"  class="pb-4 @if ($errors->any()) was-validated @endif" enctype="multipart/form-data" style=" margin-bottom:40px;">
        @csrf

       
        <div class="form-group">
                <label  for="name_company">
                     اسم الشركة <input type="text" class="form-control" placeholder="اسم الشركة" name="name_company" value= "{{$provider->name_company}}" >
                </label>
            </div>

        <div class="form-group" id="discount_percentage-warapper">
            <label for="phone"> رقم الجوال السعودي</label>
            <input type="text" class="form-control" id="phone" name="phone"    value= "{{$provider->phone}}">
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="form-group" id="discount_percentage-warapper">
            <label for="phone"> رقم الجوال اليمني</label>
            <input type="text" class="form-control" id="y_phone" name="y_phone"    value= "{{$provider->y_phone}}">
            @error('y_phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        
      
        <button type="submit" class="btn btn-success btn-lg">تعديل</button>
          <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a>
     <a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.admin.index') }}">اغلاق</a>
        
    </form>
    </div>
@endsection
