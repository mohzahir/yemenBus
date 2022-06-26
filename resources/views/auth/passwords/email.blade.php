

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

     
                        <form method="POST" action="{{ route('password.email') }}" >
                            @csrf
                                           <input type="hidden" name="user_type" value="{{$user_type}}"  >

                <div class="mb-2">
                    <input type="email" name="email" id="email" placeholder="ادخل البريد الاكتروني" class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md" >
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                

                <button class="bg-blue-600 transition duration-300 hover:bg-blue-700 text-white shadow-md hover:shadow-lg rounded-md px-4 py-2">ارسال</button>
                <a class="bg-red-600 transition duration-300 hover:bg-red-600	  shadow-md hover:shadow-lg rounded-md px-4 py-2" href="{{route('auth.login.admin')}}">رجوع</a>

            </form>    
            

    </div>
   
</body>


</html>