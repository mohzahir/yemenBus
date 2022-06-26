@extends('layouts.dashboard')

@section('style')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjIUZf1lkiY2zMcGi3RwHuMVKB_LqxnEQ&libraries=places&callback=initialize&language=ar" async defer></script>
    
    <script src="{{asset('/js/mapInput.js')}}"></script>

    <style>
        #address_on_map_sa, #address_on_map_ye, #starting_point {
            max-width: 400px;
            height: 400px;
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
    margin-bottom:10px;
 
}
    </style>
@stop

@section('content_header')
@stop

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;margin-top:50px;margin-bottom:20px;">
              <nav aria-label="breadcrumb" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.marketer.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">  حجوزات  مؤكده</li>
  </ol>
</nav>
<h1 style="text-align:center">     تعديل البيانات   </h1>


<form method="get" action='{{ route("dashboard.marketer.UpdateAccountInfo") }}' style="margin-bottom:40px;">
                            @csrf
                            @method('PUT')

                            <div class="mb-2">
                    <label>اسم المستخدم :</label >  <input type="text" name="name" value="{{$marketer->name}}" placeholder="اسم المستخدم " class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                
                   <div class="form-group" id="discount_percentage-warapper">
            <label for="phone"> رقم الجوال السعودي</label>
            <input type="text" class="form-control" id="phone" name="phone"    value= "{{$marketer->phone}}">
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="form-group" id="discount_percentage-warapper">
            <label for="phone"> رقم الجوال اليمني</label>
            <input type="text" class="form-control" id="y_phone" name="y_phone"    value= "{{$marketer->y_phone}}">
            @error('y_phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

                <div class="mb-2">
                <label> بريد الاكتروني : </label > <input type="email" name="email" @if($marketer->email)value="{{$marketer->email}}"@endif placeholder="البريد الالكتروني" class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>





                <div class="mb-2">
         <label>رقم المرور : </label > <input type="password" name="password"  placeholder="كلمة السر" class="border p-2 w-full border-gray-400 focus:border-gray-500 rounded-md">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
               {{-- <div class="mb-2">
                <label>الدولة :</label>  <input type="text" name="countery" placeholder="الدولة" @if($address) value="{{$address->countery}}" @endif class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md">
                    @error('countery')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-2">
                <label>اسم المدينة :</label> <input type="text" name="city" placeholder="المدينة" @if($address)  value="{{$address->city}}" @endif class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md">
                    @error('city')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-2">
                <label>اسم الحي :</label> <input type="text" name="neigh" placeholder="الحي" @if($address)  value="{{$address->neigh}}" @endif class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md">
                    @error('city')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-2">
                <label>اسم الشارع :</label> <input type="text" name="street" placeholder="الشارع" @if($address)  value="{{$address->street}}" @endif class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md">
                    @error('city')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-2">
                <label> العنوان  : </label><input type="text" placeholder="ادخل العنوان بالتفصيل" id="address-input" name="address_address" class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md map-input" >
                <input type="hidden" name="address_latitude" id="address-latitude" />
                <input type="hidden" name="address_longitude" id="address-longitude"   />
            </div>
            <label>الموقع على الخريطه : </label>
            <div id="address-map-container" style="width:500px;height:300px; ">
                <div style="width: 100%; height: 100%" id="address-map"></div>
            </div> --}}                   
                <button class="btn btn-success btn-lg" type="submit" style="margin-top:20px;float:left;">تعديل البيانات</button>  
                
  <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a><a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.marketer.index') }}">اغلاق</a>

            </form>
    </div>
@stop
@section('script')
<script type="text/javascript">
$('#phone').click(function () {
    document.getElementById('phone').type = 'number';
});
$('#y_phone').click(function () {
    document.getElementById('y_phone').type = 'number';
});
</script>
    @parent
@stop
