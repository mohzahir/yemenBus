@extends('layouts.admin')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="{{asset('select/dist/css/select2.min.css')}}" />
    <link rel="stylesheet" href="{{asset('select/dist/css/select2.css')}}" /> 
    
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
   <h1 style ="text-align:center">اضافة ناقل بسيارته الخاصة  </h1>
@include('flash-message')

    <form method="POST" action="{{ route('dashboard.providers.store_car') }}" id="category_form" class="pb-4 @if ($errors->any()) was-validated @endif" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">اسم الناقل   </label>
            <input type="text" class="form-control" id="name_company" name="name_company"  value="{{ old('name_company') }}" required>
            @error('name_company')
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
            <label for="person_number">رقم الهوية</label>
           <input type="text" name="person_number"  id="person_number"   placeholder="ادخل رقم الهوية" class="form-control" >
                    @error('person_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
        </div>
        <div class="form-group">
            <label for="person_img">الصورة الشخصية</label>
           <input type="file" name="person_img"  id="person_img"    class="form-control" >
                    @error('person_img')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
        </div>
        <div class="form-group">
            <label for="car_img">صورة السيارة</label>
           <input type="file" name="car_img"  id="car_img"    class="form-control" >
                    @error('car_img')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
        </div>
        <div class="form-group">
            <label for="car_number">رقم السيارة</label>
           <input type="text" name="car_number"  id="car_number"   placeholder="ادخل رقم السيارة" class="form-control" >
                    @error('car_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
        </div>
        <div class="">
            <label>نوع الخدمة</label>
           <select  name="type_service[]" multiple="multiple" id="select2"    class="multiselect-ui form-control " >
                 <option value="1">نقل مسافرين</option>
                 <option value="2">نقل رسائل </option>
                 <option value="3">نقل عفش</option>
                 <option value="4">اخرى</option>
           </select>
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
       
        <button type="submit" class="btn btn-success btn-lg">ااضافة ناقل بسيارته الخاصة  </button>
         
         <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a>
     <a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.providers.index') }}">اغلاق</a>
    </form>
    </div>
@endsection
@section('script')
<script src="{{asset('select/dist/js/select2.full.min.js')}}"></script>

<script type="text/javascript">

$('#phone').click(function () {
    document.getElementById('phone').type = 'number';
});
$('#y_phone').click(function () {
    document.getElementById('y_phone').type = 'number';
});

$(document).ready(function() {
        $('select').selectpicker();
    });
    $(function() {
    $('.multiselect-ui').multiselect({
        includeSelectAllOption: true
    });
});
$('#select2').select2({
            // data:  ["all","sat","sun","mon","tue","tue","wed","thu","fri"],
            // tags: true,
            // maximumSelectionLength: 10,
            // tokenSeparators: [',', ' '],
            // placeholder: "حدد الايام",
            //     dir: "rtl",

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
<script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
@endsection