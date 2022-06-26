<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قرعة يمن باص | تسجيل حساب مسوق</title>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjIUZf1lkiY2zMcGi3RwHuMVKB_LqxnEQ&libraries=places&callback=initialize&language=ar"
        async defer></script>

    <script src="{{asset('/js/mapInput.js')}}"></script>

    {{-- <meta name="description" value="fdsa"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">


</head>

<body class="bg-gray-200">
    <div class="container mx-auto">

        <div class=" mx-auto bg-white p-4 mt-24 shadow-md rounded-md" style="width:400px;">

            <h1 class="text-2xl text-center mb-4 font-bold">تسجيل الدخول</h1>
            <div class="flex justify-center mb-4">
                <img src="{{ asset('img/login.png') }}" alt="تسجيل الدخول">
            </div>

            @isset($url)
            <form method="POST" action='{{ url("register/$url") }}' aria-label="{{ __('Register') }}">
                @else
                <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                    @endisset
                    @csrf
                    @if($url=='provider')

                    <div class="mb-2">
                        <input type="text" name="name_company" placeholder="اسم الشركه"
                            class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md" required>
                        @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif
                    @if($url=='passenger')
                    <div class="mb-2">
                        <input type="text" name="name_passenger" placeholder="اسم المسافر"
                            class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md"
                             required>
                        @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif
                    @if($url=='marketer')
                    <div class="mb-2">
                        <input type="text" name="name" placeholder="اسم المستخدم "
                            class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md" required>
                        @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    @endif
                    <div class="mb-2">
                        <input type="text" name="phone" placeholder="ادخل رقم الجوال  السغودي  :+966051313131"
                            class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md">
                        @error('phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <input type="text" name="y_phone" placeholder="ادخل رقم الجوال اليمني  :+9671231313131"
                            class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md">
                        @error('y_phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mb-2">
                        <input type="password" name="password" placeholder="كلمة السر"
                            class="border p-2 w-full border-gray-400 focus:border-gray-500 rounded-md" required>
                        @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <input id="password-confirm" type="password" placeholder="تأكد من كلمه السر"
                            class="border p-2 w-full border-gray-400 focus:border-gray-500 rounded-md"
                            name="password_confirmation" required autocomplete="new-password">
                        @error('password-confirm')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>



                    <button
                        class="bg-blue-600 transition duration-300 hover:bg-blue-700 text-white shadow-md hover:shadow-lg rounded-md px-4 py-2">تسجيل</button>
                </form>
        </div>

    </div>
</body>

</html>