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
    <h1>إضافة مختبر</h1>
@stop

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
    <div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
     <nav aria-label="breadcrumb" style="margin-top:-50px;" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page"> اضافة مختبر</li>
  </ol>
</nav>
   <h1 style ="text-align:center">اضافة مختبر  </h1>
   @include('flash-message')

    <form method="POST" action="{{ route('admin.lab.store') }}"  class="pb-4 @if ($errors->any()) was-validated @endif" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">اسم المختبر</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name"> المدينة</label>
            <select name="city_id" class="form-control">
            @foreach($cities as $city)
            <option value="{{$city->id}}" {{ old('city_id') == $city->id ? "selected" : "" }}>{{$city->name}} </option>
            @endforeach
            </select>
            @error('city_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group" id="discount_percentage-warapper">
            <label for="phone">رقم الجوال  </label>
            <input type="text" class="form-control"  value="{{ old('phone') }}" id="phone" name="phone"  placeholder="مثال +123456789"  required>
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
<div class="form-group" id="discount_percentage-warapper">
            <label for="position">رابط الموقع على الخريطه </label>
            <input type="text" class="form-control" id="position" value="{{ old('position') }}"  name="position"   required>
            @error('position')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name"> الاولوية </label>
            <select name="priority" class="form-control" required>
            <option value="{{$p}}" {{ old('priority') == $p ? "selected" : "" }}>بدون اولوية </option>

            <option value="1" {{ old('priority') == 1 ? "selected" : "" }}>1 </option>
            <option value="2" {{ old('priority') == 2 ? "selected" : "" }}>2 </option>
            <option value="3" {{ old('priority') == 3 ? "selected" : "" }}>3 </option>
            <option value="4" {{ old('priority') == 4 ? "selected" : "" }}>4 </option>
            <option value="5" {{ old('priority') == 5 ? "selected" : "" }}>5 </option>
            </select>
            @error('priority')
                <div class="invalid-feedback">
                    {{ priority }}
                </div>
            @enderror
        </div>

        <div class="form-group" id="discount_percentage-warapper">
            <label for="position"> ساعة الدوام  </label>
            <input type="time" class="form-control" id="w_clock" name="w_clock"  value="{{ old('w_clock') }}" required >

            @error('w_clock')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">كلمة السر</label>
            <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}"  required>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
       
        <button type="submit" class="btn btn-success btn-lg">انشاء مختبر</button>
        <a class="btn btn-default btn-close btn-lg" href="">الغاء</a>
     <a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.admin.index') }}">اغلاق</a>

    </form>
    </div>
@endsection
@section('script')
   
<script type="text/javascript">
$('#phone').click(function () {
    document.getElementById('phone').type = 'number';
});

</script>
@endsection