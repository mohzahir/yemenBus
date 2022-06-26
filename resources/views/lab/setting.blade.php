@extends('layouts.labDashboard')

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
    <li class="breadcrumb-item"><a href="{{route('dashboard.lab.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">  تعديل  بيانات الحساب</li>
  </ol>
</nav>
<h1 style="text-align:center">  تعديل البيانات الحساب   </h1>
@include('flash-message')

<form method="post" action='{{ route("dashboard.lab.update") }}' style="margin-bottom:40px;">
                            @csrf
                            @method('PUT')

                    <div class="form-group" id="discount_percentage-warapper">
                    <label>اسم المختبر :</label >  <input type="text" name="name" value="{{$lab->name}}" placeholder="اسم المختبر " class="form-control">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                    <div class="form-group" id="discount_percentage-warapper">
            <label for="phone"> المدينة</label>
            <select  class="form-control"  name="city">
               @foreach($cities as $city)
                <option @if($lab->city_id==$city->id)selected @endif </option>{{$city->name}}</option>
                @endforeach
            </select>
            
        </div>
                   <div class="form-group" id="discount_percentage-warapper">
            <label for="phone"> رقم الجوال </label>
            <input type="text" class="form-control" id="phone" name="phone"  placeholder="0501233456"   value= "{{$lab->phone}}">
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group" id="discount_percentage-warapper">
            <label for="position">رابط الموقع على الخريطه </label>
            <input type="text" class="form-control" id="position" name="position"   value="{{$lab->position}}" required>
            @error('position')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    
<div class="form-group" id="discount_percentage-warapper">
            <label for="position"> ساعة الدوام  </label>
            <input type="time" class="form-control" id="w_clock" name="w_clock"  value="{{$lab->w_clock}}"  required>

            @error('w_clock')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        


                    <div class="form-group" >
         <label>رقم المرور : </label > <input type="password"class="form-control"  name="password"  placeholder="كلمة السر" class="border p-2 w-full border-gray-400 focus:border-gray-500 rounded-md">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button class="btn btn-success btn-lg" type="submit" >تعديل البيانات</button>  
                
  <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a><a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.lab.index') }}">اغلاق</a>

            </form>
    </div>
@stop
@section('script')
<script type="text/javascript">
$('#phone').click(function () {
    document.getElementById('phone').type = 'number';
});

</script>
    @parent
@stop
