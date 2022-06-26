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


    <h1 style="text-align:center">تعديل البيانات</h1>

    <form method="get" action='{{ route("dashboard.provider.UpdateAccountInfo") }}'>
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>اسم المستخدم :</label> <input type="text" name="name" value="{{$provider->name}}" placeholder="اسم المستخدم " class="form-control">
            @error('name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group" id="discount_percentage-warapper">
            <label for="phone"> رقم الجوال السعودي</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{$provider->phone}}">
            @error('phone')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group" id="discount_percentage-warapper">
            <label for="phone"> رقم الجوال اليمني</label>
            <input type="text" class="form-control" id="y_phone" name="y_phone" value="{{$provider->y_phone}}">
            @error('y_phone')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label>اسم المدينة :</label> <input type="text" name="city" placeholder="المدينة" value="{{$provider->city}}" class="form-control">
            @error('city')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label> بريد الاكتروني : </label> <input type="email" name="email" value="{{$provider->email}}" placeholder="البريد الالكتروني" class="form-control">
            @error('email')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>





        <div class="form-group">
            <label>رقم المرور : </label> <input type="password" name="password" placeholder="كلمة السر" class="form-control">
            @error('password')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>اسم الشركة : </label> <input type="text" name="name_company" value="{{$provider->name_company}}" placeholder="اسم الشركه" class="form-control">
            @error('name_company')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{--
                <div class="mb-2">
                <label>رقم  الحساب البنكي : </label >  <input type="text" name="bank_account_number" @if($bank!=null) value="{{$bank->bank_account_number}}" @endif placeholder="رقم الحساب البنكي" class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md">
        @error('bank_account_number')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
</div>

<div class="form-group">
    <label>الايبان ان وجد : </label> <input type="text" name="IBAN" @if($bank!=null) value="{{$bank->IBAN}}" @endif placeholder="  الايبان ان وجد " class="form-control">
    @error('IBAN')
    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label>اسم البنك : </label> <input type="text" name="bank_name" @if($bank!=null) value="{{$bank->bank_name}}" @endif placeholder="   اسم البنك  " class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md">
    @error('bank_name')
    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mb-2">
    <label>سوفت كود للبنك :</label> <input type="text" name="bank_softcode" @if($bank!=null) value="{{$bank->bank_softcode}}" @endif placeholder=" سوفت كود للبنك" class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md">
    @error('bank_softcode')
    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
<div class="mb-2">
    <label>الدولة :</label> <input type="text" name="countery" placeholder="الدولة" @if($bank!=null) value="{{$bank->countery}}" @endif class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md">
    @error('countery')
    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>


<div class="mb-2">
    <label> العنوان : </label><input type="text" placeholder="ادخل العنوان بالتفصيل" id="address-input" name="address_address" class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md map-input">
    <input type="hidden" name="address_latitude" id="address-latitude" @if($address!=null) @if ($address->address_address!=0) value="{{$address->address-latitude}}" @else value="0" @endif @endif />
    <input type="hidden" name="address_longitude" id="address-longitude" @if($address!=null) @if ($address->address_address!=0) value="{{$address->address-longitude}}" @else value="0" @endif @endif />
</div>


--}}
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