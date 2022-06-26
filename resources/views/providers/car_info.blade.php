@extends('layouts.providerDashboard')

@section('style')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjIUZf1lkiY2zMcGi3RwHuMVKB_LqxnEQ&libraries=places&callback=initialize&language=ar" async defer></script>

<script src="{{asset('/js/mapInput.js')}}"></script>

<style>
    #address_on_map_sa,
    #address_on_map_ye,
    #starting_point {
        max-width: 400px;
        height: 400px;
    }

    h1,
    h2,
    h3 {
        font-family: 'Cairo', sans-serif;
    }

    p {
        font-family: 'Cairo', sans-serif;
        font-size: 20px;

    }

    label {
        font-family: 'Cairo', sans-serif;
        font-size: 16px;
        margin-bottom: 10px;

    }
</style>
@stop

@section('content_header')
@stop

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- " style="margin-left:70px;margin-top:50px;margin-bottom:20px;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.provider.showAccountInfo')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
            <li class="breadcrumb-item active" aria-current="page"> تعديل البيانات </li>
        </ol>
    </nav>


    <h1 style="text-align:center">معلومات سيارتي</h1>
    

    <form method="get" action='{{ route("dashboard.provider.UpdateAccountInfo") }}'>
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="car_img">صورة السيارة</label>
           <input type="file" name="car_img"  id="car_img"    class="form-control" >
                    @error('car_img')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <img src="{{asset(''.$provider->car_img.'')}}" alt="صورة السيارة" height="200px" width="300px" >
        </div>

        <div class="form-group">
            <label for="car_number">رقم السيارة</label>
           <input type="text" name="car_number"  id="car_number" value="{{$provider->car_number}}"   placeholder="ادخل رقم السيارة" class="form-control" >
                    @error('car_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
        </div>


<button class="btn btn-success" type="submit" style="margin-top:20px;float:left;">تعديل البيانات</button>
<a class="btn btn-warning btn-close" style="margin-top:20px;float:left;" href="">الغاء</a>
</form>
</div>
@stop
@section('script')
<script type="text/javascript">
    $('#phone').click(function() {
        document.getElementById('phone').type = 'number';
    });
    $('#y_phone').click(function() {
        document.getElementById('y_phone').type = 'number';
    });
</script>
@parent
@stop