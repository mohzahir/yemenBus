<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قرعة يمن باص | تسجيل الدخول</title>
    {{-- <meta name="description" value="fdsa"> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

   
</head>
<!-- <div class="card-header"> {{ isset($url) ? ucwords($url) : ""}} {{ __('Login') }}</div> -->

<body style="background: url({{ asset('passenger-assets/img/hero/bus-cover.png') }});background-size: cover;background-color: #bfcbd6;">
    <div class="container mx-auto">

        <div class="max-w-sm mx-auto bg-white p-4 mt-24 shadow-md rounded-md">
            
            <h1 class="text-2xl text-center mb-4 font-bold"> تسجيل دخول   @switch($url) @case('admin') الادمن @break @case('marketer')مسوقين @break  @case('admin') الادمن @break @case('passenger')مسافر @break @case('lab')مختبر@break   @case('provider')شركة النقل
@break @default @break @endswitch </h1>
            <div class="flex justify-center mb-4">
                <img src="{{ asset('img/login.png') }}" alt="تسجيل الدخول">
            </div>
@include('flash-message')
            @isset($url)
            @if($url ==  'passenger')
                <div class="form-group row">
                    <div class="col-12 text-center">
                         <a href="{{ url('passenger/login/facebook') }}" class="btn btn-primary"> <i style="color: #3182ce" class="fab fa-facebook-square fa-3x"></i></a>
                         <a href="{{ url('passenger/login/google') }}" class="btn btn-primary"> <i style="color: #dc4430" class="fab fa-google-plus-square fa-3x"></i></a>
                         <!-- <a href="{{ url('passenger/login/google') }}" class="btn btn-google-plus"> Google</a> -->
                    </div>
                </div>
                <hr style="margin: 10px">
            @endif
                        <form method="POST" action='{{ url("login/$url") }}' aria-label="{{ __('Login') }}">
                        @else
                        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @endisset
                            @csrf
                            @if($url!='admin')
                <div class="mb-2">
                    <input type="number" name="phone" id="phone"  @if(request()->phone)value="{{request()->phone}}" @endif  placeholder="ادخل رقم الجوال  السغودي  :966051313131" class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md" >
                    @error('phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                 @if($url!='lab')
                <div class="mb-2">
                    <input type="number" name="y_phone" id="y_phone"  @if(request()->y_phone)value="{{request()->y_phone}}" @endif placeholder="ادخل رقم الجوال اليمني  :9671231313131" class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md" >
                    @error('y_phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @endif
@endif
@if($url=='admin')
                <div class="mb-2">
                    <input type="email" name="email" placeholder="ادخل بريد الاكتروني:+" class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md" >
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
@endif
                <div class="mb-2">
                    <input type="password" id="password" name="password"  placeholder="كلمة السر" class="border p-2 w-full border-gray-400 focus:border-gray-500 rounded-md">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <input type="checkbox" id="checkbox">عرض كلمه مرور  </input>

 @if($url=='admin')
          <div class="flex items-center mb-4" style="float:left;color:red">
                    <a type="submit" href="{{route('admin.showResetEmailForm',['user_type'=>$url])}}">نسيت كلمة المرور</a>
                </div>
        @elseif($url=='marketer')
         <div class="flex items-center mb-4" style="float:left;color:red">
                    <a type="submit" href="{{route('showResetPhoneForm',['user_type'=>$url])}}">نسيت كلمة المرور</a>
                </div>
                @elseif($url=='lab')
         <div class="flex items-center mb-4" style="float:left;color:red">
                    <a type="submit" href="{{route('showResetPhoneForm',['user_type'=>$url])}}">نسيت كلمة المرور</a>
                </div>
                @elseif($url=='provider')
         <div class="flex items-center mb-4" style="float:left;color:red">
                    <a type="submit" href="{{route('showResetPhoneForm',['user_type'=>$url])}}">نسيت كلمة المرور</a>
                </div>
        @else
        @endif
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="remember" name="remember" class="ml-1">
                    <label for="remember">تذكرني</label> 
                </div>
               
                <div class="d-flex">
                <button class="bg-blue-600 transition duration-300 hover:bg-blue-700 text-white shadow-md
                 hover:shadow-lg rounded-md px-4 py-2">دخول</button>
              
                 <a class="" style="color: #0e1c35; padding-right:150px" href="{{route('register.passenger')}}">تسجيل جديد</a>
                </div>
            </form>    
             
       
        </div>

    </div>
    <script>
$(document).ready(function(){
    $('#checkbox').on('change', function(){
        $('#password').attr('type',$('#checkbox').prop('checked')==true?"text":"password"); 
    });
});
</script>
</body>


</html>