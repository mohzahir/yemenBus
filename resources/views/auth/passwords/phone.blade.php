<!DOCTYPE html>
<html lang="en">
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
<div class="card-header"> </div>

<body class="bg-gray-200">
    <div class="container mx-auto">

        <div class="max-w-sm mx-auto bg-white p-4 mt-24 shadow-md rounded-md">
            
            <h1 class="text-2xl text-center mb-4 font-bold"> استعادة كلمة السر   </h1>
            <div class="flex justify-center mb-4">
                <img src="{{ asset('img/login.png') }}" alt="تسجيل الدخول">
            </div>
@include('flash-message')

     
                        <form method="POST" action="{{ route('sendPassword') }}" >
                            @csrf
                                           <input type="hidden" name="user_type" value="{{$user_type}}"  >

                <div class="mb-2">
                    <input type="number" name="phone" id="phone" placeholder="ادخل رقم الجوال  السغودي  :966051313131" class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md" >
                    @error('phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @if($user_type!='lab')
                <div class="mb-2">
                    <input type="number" name="y_phone" id="y_phone" placeholder="ادخل رقم الجوال اليمني  :9671231313131" class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md" >
                    @error('y_phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
@endif
                <button class="bg-blue-600 transition duration-300 hover:bg-blue-700 text-white shadow-md hover:shadow-lg rounded-md px-4 py-2">ارسال</button>
                @if($user_type=='marketer')
                <a class="bg-red-600 transition duration-300   shadow-md hover:shadow-lg rounded-md px-4 py-2" href="{{route('auth.login.maketer')}}">رجوع</a>
              @elseif($user_type=='provider')
                <a class="bg-red-600 transition duration-300   shadow-md hover:shadow-lg rounded-md px-4 py-2" href="{{route('auth.login.provider')}}">رجوع</a>
             @else
                <a class="bg-red-600 transition duration-300   shadow-md hover:shadow-lg rounded-md px-4 py-2" href="{{route('auth.login.lab')}}">رجوع</a>
              @endif
            </form>    
            

    </div>
   
</body>


</html>