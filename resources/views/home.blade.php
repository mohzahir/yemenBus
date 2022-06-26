<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قرعة شركة يمن باص</title>
    <meta name="_token" content="{{csrf_token()}}" />

    {{-- <meta name="description" value="fdsa"> --}}
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Amiri:ital@0;1&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
     
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>



</head>
<body class="bg-gray-200">

    <div class="">

        <div class="bg-white py-6 shadow-sm">
            <div class="container mx-auto">
                <h1 class="text-center font-bold text-2xl"><a class="text-blue-700 hover:text-blue-900" href="https://www.yemenbus.com">يمن باص YemenBus</a></h1>
                <p class="text-md text-center font-bold">الشبكة الذكية لحجوزات المغتربين اليمنين بالسعودية</p>
                <p class="text-xs text-gray-800 text-center mt-4">رحلات الباصات - رحلات طيران - انجاز المعاملات التاشيرات بالسفارة السعودية باليمن - تسجيل الحجاج - تسجيل المعتمرين - تسجيل الطلاب المغتربين بالجامعات والمعاهد اليمنية - التأمين الصحي للسفر</p>
            </div>
        </div>

        <div class="container mt-4 mx-auto">

            @if (Session::has('message'))
                <div class="alert alert-{{ Session::get('type', 'default') }} rounded-md p-4 mb-4">
                    {{ Session::get('message') }}
                </div>
            @endif
            @if ($errors->any())

            @endif
            @error('phone')
                <div class="alert alert-danger rounded-md p-4 mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @enderror

            <div class="mb-4">
                <p class="text-center text-gray-900 font-bold text-2xl"><i class="fas fa-trophy text-yellow-500"></i> قرعة هذا الاسبوع <i class="fas fa-trophy text-yellow-500"></i></p>
                <p class="text-center text-gray-400 text-2xl mt-2" style="font-size:14px;">شارك بقرعة للحصول على تذكرة مجانية أو مخفضة لهذا الاسبوع المخصصة للمغتربين اليمنيين بالسعودية</p>
                
                <p class="text-center mt-2"><strong>برعاية يمن باص</strong></p>
            </div>

            <div class="bg-green-300 shadow-md p-4 mb-6 rounded-md">
                <p class="mb-2">ابحث عن القرعة المناسبة لك</p>
                {{-- <p class="mb-4">
                    التذاكر المجانية والمخفضة للرحلات من <strong>السعودية</strong> إلى <strong>اليمن</strong>
                </p> --}}
                <form action="/" method="GET">
                    <div class="form-group flex items-center mb-2">
                        <label for="day" class="block w-24 font-bold">اختر اليوم:</label>
                        <select name="day" id="day" class="bg-gray-300 text-sm">
                            <option value="" selected>الكل</option>
                            <option value="6" {{ Request::get('day') == '6' ? 'selected' : '' }}>السبت</option>
                            <option value="0" {{ Request::get('day') == '0' ? 'selected' : '' }}>الأحد</option>
                            <option value="1" {{ Request::get('day') == '1' ? 'selected' : '' }}>الإثنين</option>
                            <option value="2" {{ Request::get('day') == '2' ? 'selected' : '' }}>الثلاثاء</option>
                            <option value="3" {{ Request::get('day') == '3' ? 'selected' : '' }}>الأربعاء</option>
                            <option value="4" {{ Request::get('day') == '4' ? 'selected' : '' }}>الخميس</option>
                            <option value="5" {{ Request::get('day') == '5' ? 'selected' : '' }}>الجمعة</option>
                        </select>
                    </div>

                    <div class="form-group flex items-center mb-2">
                        <label for="direction" class="block w-24 font-bold text-blue-800">اتجاه الرحلة:</label>
                        <select name="direction" id="direction" class="bg-gray-300 text-sm">
                            <option value="" selected>الكل</option>
                            <option value="saudia_yemen" {{ Request::get('direction') == 'saudia_yemen' ? 'selected' : '' }}>من السعودية إلى اليمن</option>
                            <option value="yemen_saudia" {{ Request::get('direction') == 'yemen_saudia' ? 'selected' : '' }}>من اليمن إلى السعودية</option>
                            <option value="in_yemen" {{ Request::get('direction') == 'in_yemen' ? 'selected' : '' }}>داخل المدن اليمنية</option>
                        </select>
                    </div>
                    <div class="form-group flex items-center mb-2">
                        <label class="block w-24 font-bold">نوع القرعة:</label>
                        <div class="text-sm">
                            <input type="radio" value="" checked name="type" id="all"> <label for="all">الكل</label>
                            <input type="radio" {{ Request::get('type') == 'free' ? 'checked' : '' }} class="mr-2" value="free" id="free" name="type"> <label for="free">مجانية</label>
                            <input type="radio" {{ Request::get('type') == 'discount' ? 'checked' : '' }} class="mr-2" value="discount" id="discount" name="type"> <label for="discount">مخفضة</label>
                        </div>
                    </div>
    
                    <button class="rounded-md bg-blue-600 hover:bg-blue-700 transition duration-300 text-white px-4 py-2 shadow-md hover:shadow-lg">بحث</button>
                </form>
            </div>

            <div class="mb-6">
            
            @forelse ($competitions as $competition)
          
                <div class="bg-white shadow-md p-4 rounded-md mb-4" style="margin-bottom:10px;">
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-lg items-center text-gray-900">
                            <i class="fas fa-clock inline-block ml-2"></i> 
                            يوم الرحلة :  <br><strong>{{ $competition->tripDate() }}</strong>
                        </p>
                       <br>
                       <br>
                                 

                        <div class="badge badge-{{ $competition->discount_percentage == 100 ? 'free' : 'discount' }} inline-block rounded-md mr-1 text-xs px-2 py-2 text-white">
                            {{ $competition->discount_percentage == 100 ? 'مجانية' : 'مخفضة' }}
                        </div>
                         <br>
                        
                              
                                        

                    </div>
<p class="text-lg items-center text-gray-900">
                            <i class="fas fa-clock inline-block ml-2"></i> 
                            ساعة الحركة: <strong>{{ $competition->clockTime() }}</strong>
                        </p>
                    <p class="text-lg items-center mb-2 text-gray-900"><i class="fas fa-tags inline-block ml-1"></i> سعر التذكرة قبل الخصم: <strong>{{ $competition->old_ticket_price }} ريال</strong></p>
                    
                    <p class="text-lg items-center mb-2 text-gray-900"><i class="fas fa-tags inline-block ml-1"></i> سعر التذكرة بعد الخصم: <strong>{{ $competition->old_ticket_price * ( (100 - $competition->discount_percentage) / 100 ) }} ريال (سيتم توفير {{ $competition->old_ticket_price * $competition->discount_percentage / 100 }} ريال)</strong></p>
                    
                    <p class="text-lg items-center mb-2 text-gray-900"><i class="fas fa-map-marker-alt inline-block ml-1"></i> الرحلة من <strong>{{ $competition->starting_place }}</strong> إلى <strong>{{ $competition->finishing_place }}</strong></p>
                    
                    <p class="text-lg items-center mb-2 text-gray-900"><i class="fas fa-ticket-alt inline-block ml-1"></i> عدد التذاكر {{ $competition->discount_percentage == 100 ? 'المجانية' : 'المخفضة' }}: <strong>{{ $competition->available_tickets }}</strong></p>
                    
                    <p class="text-lg items-center mb-2 text-gray-900"><i class="fas fa-tags inline-block ml-1"></i>  احجز الان: <a href="{{ $competition->booking_link }}"><strong>رابط الحجز</strong> </a></strong></p>
<br>
                    <p class="text-lg items-center text-center mb-2 text-gray-900"><i class="fas fa-bus inline-block ml-1"></i> الشركة الناقلة: {!! $competition->transportation_company_url ? "<a class=\"text-blue-700 hover:text-blue-900\" href=\"{$competition->transportation_company_url}\"><strong>{$competition->transportation_company}</strong></a>" : "<strong>{$competition->transportation_company}</strong>" !!}</p>
                    
                    @if ($competition->transportation_company_banner)
                        <a href="{{ $competition->transportation_company_url }}"><img src="{{ asset($competition->transportation_company_banner) }}" loading="lazy" class="max-h-full mx-auto mt-4 banner" ></a>
                    @endif

                    <p class="text-lg items-center text-center mt-2 text-gray-900"><i class="fas fa-ad inline-block ml-1"></i> الراعي الاعلاني : {!! $competition->sponsor_url ? "<a class=\"text-blue-700 hover:text-blue-900\" href=\"{$competition->sponsor_url}\"><strong>{$competition->sponsor}</strong></a>" : "<strong>{$competition->sponsor}</strong>" !!}</p>

                    @if ($competition->sponsor_banner)
                        <a href="{{ $competition->sponsor_url }}"><img src="{{asset($competition->sponsor_banner) }}" loading="lazy" class="max-h-full mx-auto mt-4 banner" ></a>
                    @endif
<br>
                    @if (!$competition->winner_id)
                        <div class="mt-4 rounded-m">
                            <p class="text-center text-lg mb-4">سيتم اختيار الفائز خلال</p>
                            <div class="max-w-xs mx-auto flex justify-between countdown" data-start="{{ $competition->finish_at }}">
                                
                                <div class="text-center pr-10">
                                    <p id="minutes_{{ $competition->id }}" class="minutes text-2xl font-bold">40</p>
                                    <p class="text-sm">دقيقة</p>
                                </div>
                                <div class="text-center">
                                    <p id="hours_{{ $competition->id }}" class="hours text-2xl font-bold">20</p>
                                    <p class="text-sm">ساعة</p>
                                </div>
                                <div class="text-center pl-10">
                                    <p id="days_{{ $competition->id }}" class="days text-2xl font-bold">50</p>
                                    <p class="text-sm">يوم</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mx-auto text-center mt-6 bg-green-200 p-4 rounded-md shadow-md max-w-lg">
                        @if ($competition->winner_id)
                            <p class="text-lg font-bold">الفائز هو صاحب الرقم {{ $competition->winner->phone }}</p>
                            <p class="text-lg">ألف مبروك!</p>
                        @else
                        <p class="font-bold text-xl mb-2">إشترك الآن!</p>
                        <form id="myForm_{{$competition->id}}" action="{{route('participant_competition.store')}}" method="post">
                            @csrf
                            <input type="hidden" value="{{$competition->id}}" name="id" id="id_{{$competition->id}}">
                            <div class="form-group px-2">
                                <label>رقم الجوال للمسافر:</label>
                                <div class="flex justify-center mt-2">
                                    <div class="ml-2">
                                        <input type="radio" name="phone_country" id="sa_{{ $competition->id }}" checked value="966">
                                        <label for="sa_{{ $competition->id }}">سعودي</label>
                                    </div>
                                    <div class="mr-2">
                                        <input type="radio" name="phone_country" id="ye_{{ $competition->id }}" value="967">
                                        <label for="ye_{{ $competition->id }}">يمني</label>
                                    </div>
                                </div>
                                <input type="text" name="phone" id="phone_{{$competition->id}}" class="border shadow-sm px-1 py-1 rounded-sm border-gray-500 mt-2 w-full"  placeholder="" required>
                            </div>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 transition duration-300 px-4 py-2 rounded-md shadow-md hover:shadow-lg mt-2 text-white">احجز الرحلة</button>
                            <p class="text-xs mt-2">بمشاركتك فأنت توافق على الشروط والأحكام</p>
                        </form>
                        @endif
                    </div>

                    <div class="mt-4 rounded-md overflow-hidden">
                        <div class="accordion-head cursor-pointer flex p-4 bg-gray-200 items-center justify-between" onclick="toggleAccordion(this)">
                            <p class="">الشروط والأحكام</p>
                            <i class="transform fas transition-transform duration-300 fa-chevron-down"></i>
                        </div>
                        <div class="accordion-body px-4 bg-gray-300 rounded-sm">
                            {!! $competition->terms !!}
                        </div>
                    </div >
                    
                </div>

            @empty
            
                <p class="text-center text-xl">لا يوجد قرع</p>
            @endforelse
            
            </div>

        </div>
    </div>
    
    {{-- <div>
        <div class="container mx-auto">
            <h1>هذه القرعة مقدمة إليكم برعاية</h1>
            <img src="https://fakeimg.pl/300/" alt="الراعي">
        </div>
    </div> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/luxon/1.25.0/luxon.min.js"></script>
    <script>
        function countDown(elm) {

            var date = luxon.DateTime.fromSQL(elm.getAttribute('data-start'), { zone: 'Asia/Aden' });
            var diff = date.diffNow(['days','hours', 'minutes']);

            elm.querySelector('.minutes').textContent = parseInt(diff.minutes, 10);
            elm.querySelector('.hours').textContent = parseInt(diff.hours, 10);
            elm.querySelector('.days').textContent = parseInt(diff.days, 10) ;

            /*var diffTime = Math.abs(new Date(elm.getAttribute('data-start')) - new Date());
            var diffHours = Math.ceil(diffTime / (1000 * 60 * 60)); 
            var diffMinutes = Math.ceil(diffTime / (1000 * 60)) % 60; 
            var diffSeconds = Math.ceil(diffTime / (1000)) % 60;

            elm.querySelector('.seconds').textContent = diffSeconds;
            elm.querySelector('.minutes').textContent = diffMinutes;
            elm.querySelector('.hours').textContent = diffHours;*/
        }
        document.querySelectorAll('.countdown').forEach(function(elm) {
            countDown(elm);
            setInterval(function() {
                countDown(elm);
            }, 1000)
        })

        function toggleAccordion(elm) {
            elm.querySelector('.fa-chevron-down').classList.toggle('rotate-180')
            var nextElm = elm.nextElementSibling
            if (nextElm.clientHeight === 0) {
                nextElm.style.height = nextElm.scrollHeight + 'px';
                return;
            }
            nextElm.style.height = 0;
        }
        
    </script>
   </body>
</html>