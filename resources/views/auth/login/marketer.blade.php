<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قرعة يمن باص | تسجيل الدخول</title>
    {{-- <meta name="description" value="fdsa"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body class="bg-gray-200">
    <div class="container mx-auto">

        <div class="max-w-sm mx-auto bg-white p-4 mt-24 shadow-md rounded-md">
            
            <h1 class="text-2xl text-center mb-4 font-bold">تسجيل الدخول</h1>
            <div class="flex justify-center mb-4">
                <img src="{{ asset('img/login.png') }}" alt="تسجيل الدخول">
            </div>

            <form action="{{route('marketer.login')}}" method="POST">
                @csrf
                <div class="mb-2">
                    <input type="email" name="email" placeholder="البريد الالكتروني" class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-2">
                    <input type="password" name="password" placeholder="كلمة السر" class="border p-2 w-full border-gray-400 focus:border-gray-500 rounded-md">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="remember" name="remember" class="ml-1">
                    <label for="remember">تذكرني</label>
                </div>
                <button class="bg-blue-600 transition duration-300 hover:bg-blue-700 text-white shadow-md hover:shadow-lg rounded-md px-4 py-2">دخول</button>
            </form>
        </div>

    </div>
</body>
</html>