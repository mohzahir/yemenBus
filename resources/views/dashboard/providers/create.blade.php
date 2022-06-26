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
    <h1>إضافة مسوق</h1>
@stop

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
    <div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
     <nav aria-label="breadcrumb" style="margin-top:-50px;" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page"> اضافة مزود</li>
  </ol>
</nav>
   <h1 style ="text-align:center">اضافة مزود  </h1>
@include('flash-message')

    <form method="POST" action="{{ route('dashboard.providers.store') }}"  class="pb-4 @if ($errors->any()) was-validated @endif" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">اسم الشركة   </label>
            <input type="text" class="form-control" id="name_company" name="name_company"  value="{{ old('name_company') }}" required>
            @error('name_company')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name">الخدمه   </label>
            <select name="service_id" class="form-control">
                <option value="">  ---- </option>
                @foreach ($services as $service)
                    <option value="{{$service->id}}"> {{$service->name}}</option>
                @endforeach
            </select>
            @error('service_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
         <div class="form-group">
            <label for="name">المدينة   </label>
            <input type="text" class="form-control" id="city" name="city"  value="{{ old('city') }}" required>
            @error('city')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group" id="discount_percentage-warapper">
            <label for="phone">رقم الجوال  السعودي</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}"  placeholder="مثال +123456789" >
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

         <div class="form-group" id="discount_percentage-warapper">
            <label for="y_phone">رقم الجوال  اليمني</label>
           <input type="text" name="y_phone"  id="y_phone" value="{{ old('y_phone') }}"  placeholder="ادخل رقم الجوال اليمني  :+9671231313131" class="form-control" >
                    @error('y_phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
        </div>
        
        
        <div class="form-group">
            <label for="password">كلمة السر</label>
            <input type="password" class="form-control" id="password" name="password"  value="{{ old('password') }}"   required>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
       
        <button type="submit" class="btn btn-success btn-lg">ااضافة  </button>
         
         <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a>
     <a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.providers.index') }}">اغلاق</a>
    </form>
    </div>
@endsection
@section('script')
<script type="text/javascript">
$('#phone').click(function () {
    document.getElementById('phone').type = 'number';
});
$('#y_phone').click(function () {
    document.getElementById('y_phone').type = 'number';
});
</script>
@endsection