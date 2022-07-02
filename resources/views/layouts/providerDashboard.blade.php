<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin panel</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/icon.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link href="{{asset('css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">

    <style>
        .bring_left {
            float: left;
        }

        h1,
        h2,
        h3,
        p,
        a {
            font-family: 'Cairo', sans-serif;

        }
    </style>


    @yield('style')
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    @php
    $user = auth()->guard('provider')->user();
    @endphp
    @if($user->car ==1)
    <div class="container-fluid">
        <!--Start header-->

        <div class="row header_section">
            <div class="col-sm-3 col-xs-12 logo_area bring_right" style="float:right">
                <h1 class="inline-block"><img src="{{asset('img/logo.png')}}" alt="">لوحة تحكم</h1>
                <span class="glyphicon glyphicon-align-justify bring_left open_close_menu" data-toggle="tooltip" data-placement="right" title="Tooltip on left"></span>
            </div>
            <div class="col-sm-3 col-xs-12 head_buttons_area bring_right hidden-xs" style="float:right">

                <div class="inline-block full_screen bring_right hidden-xs">
                    <span class="glyphicon glyphicon-fullscreen" data-toggle="tooltip" data-placement="left" title="شاشة كاملة"></span>
                </div>
            </div>
        </div>
        <!--/End header-->

        <!--Start body container section-->

        <!--/End left sidebar-->

        <!--Start Side bar main menu-->
        <div class="main_sidebar bring_right" style="width:250px;">
            <div class="main_sidebar_wrapper">
                <form class="form-inline search_box text-center">
                    <div class="form-group">
                        <input type="search" class="form-control" placeholder="كلمة البحث">
                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span>
                        </button>
                    </div>
                </form>

                <ul>

                    <li><span class="glyphicon glyphicon-home"></span><a href="#">الصفحة الرئيسية</a></li>
                    <li><span class="glyphicon glyphicon-edit"></span><a href="{{route('provider.trip.index')}}">رحلاتي</a></li>
                    <li><span class="glyphicon glyphicon-edit"></span><a href="{{route('provider.trip.create')}}">اضافة رحلة جديدة</a></li>
                    <li><span class="glyphicon glyphicon-user"></span><a href="{{route('dashboard.provider.updateAccountInfoForm')}}">معلوماتي الشخصية  </a>
                    <li><span class="glyphicon glyphicon-user"></span><a href="{{route('dashboard.provider.updateCarInfoForm')}}">معلومات سيارتي  </a>

                    <li><span class="glyphicon glyphicon-edit"></span><a href="{{route('provider.reservations.confirmAll_car')}}">طلبات حجز ركاب </a></li>
                    <li><span class="glyphicon glyphicon-edit"></span><a href="{{route('provider.reservations.cancle_All')}}">طلبات تم الغاؤها </a></li>
                    <li><span class="glyphicon glyphicon-edit"></span><a href="{{route('provider.reservations.posts')}}">طلبات تم التأجيل لها </a></li>

                    <li><span class="glyphicon glyphicon-map-marker"></span><a href="{{route('dashboard.raiseOnMap.index')}}">اضافة مصعد على الخريطه</a></li>




                    <!-- <li><span class="glyphicon glyphicon-envelope"></span><a href="{{route('provider.sms')}}">رسائل نصية</a></li> -->
                    <li><span class="glyphicon glyphicon-envelope"></span><a href="{{route('provider.sms')}}">محادثة مع الادارة</a></li>


                    </li>
                    <li><span class="glyphicon glyphicon-envelope"></span><a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> تسجيل الخروج </a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>

        <!--/End side bar main menu-->

        <!--Start Main content container-->
        <div class="main_content_container" style="margin-top:60px;">

            @Yield('content')
        </div>
        <!--/End body container section-->
    </div>
    </div>
    @Yield('script')
    <script type="text/javascript" src="{{asset('js/jquery-2.1.4.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/js.js')}}"></script>
    @else
    <div class="container-fluid">
        <!--Start header-->

        <div class="row header_section">
            <div class="col-sm-3 col-xs-12 logo_area bring_right" style="float:right">
                <h1 class="inline-block"><img src="{{asset('img/logo.png')}}" alt="">لوحة تحكم</h1>
                <span class="glyphicon glyphicon-align-justify bring_left open_close_menu" data-toggle="tooltip" data-placement="right" title="Tooltip on left"></span>
            </div>
            <div class="col-sm-3 col-xs-12 head_buttons_area bring_right hidden-xs" style="float:right">

                <div class="inline-block full_screen bring_right hidden-xs">
                    <span class="glyphicon glyphicon-fullscreen" data-toggle="tooltip" data-placement="left" title="شاشة كاملة"></span>
                </div>
            </div>

            <div class="text-danger">
                <h1>{{Auth::guard('provider')->user()->name_company}}</h1>
            </div>


        </div>
        <!--/End header-->

        <!--Start body container section-->

        <!--/End left sidebar-->

        <!--Start Side bar main menu-->
        <div class="main_sidebar bring_right" style="width:250px;">
            <div class="main_sidebar_wrapper">
                <form class="form-inline search_box text-center">
                    <div class="form-group">
                        <input type="search" class="form-control" placeholder="كلمة البحث">
                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span>
                        </button>
                    </div>
                </form>

                <ul>

                    <li><span class="glyphicon glyphicon-home"></span><a href="#">الصفحة الرئيسية</a></li>


                    <li><span class="glyphicon glyphicon-plus"></span><a href="{{route('dashboard.financialSetting.index')}}">اضافة صلاحيه الوكلاء الماليه</a></li>


                    <li><span class="glyphicon glyphicon-plus"></span><a href="{{route('provider.nom.index')}}"> ترشيح مسوقين </a></li>

                    <li><span class="glyphicon glyphicon-map-marker"></span><a href="{{route('dashboard.raiseOnMap.index')}}">اضافة مصعد على الخريطه</a></li>

                    <li><span class="glyphicon glyphicon-edit"></span><a href="{{route('provider.reservations.confirmAll')}}">الحجوزات </a></li>
                    <li>
                        <span class="glyphicon glyphicon-user"></span>
                        <a href="{{ route('provider.haj.reservations.index') }}">حجوزات الحج والعمرة </a>
                    </li>
                    <li><span class="glyphicon glyphicon-edit"></span><a href="{{route('provider.trip.create')}}">اضافة الرحلات</a></li>
                    {{-- @if ($provider->haj)
                        
                    <li><span class="glyphicon glyphicon-edit"></span><a href="{{route('provider.trip.create_haj')}}">اضافة رحلة حج وعمرة</a></li>
                    <li><span class="glyphicon glyphicon-edit"></span><a href="{{route('provider.trip.haj')}}">رحلات الحج والعمرة</a></li>

                    @endif --}}

                    <li><span class="glyphicon glyphicon-edit"></span><a href="{{route('provider.trip.index')}}">الرحلات</a></li>


                    <li><span class="glyphicon glyphicon-envelope"></span><a href="{{route('provider.sms')}}">ارسال رسالة للعميل</a></li>

                    <li><span class="glyphicon glyphicon-user"></span><a href="{{route('dashboard.provider.updateAccountInfoForm')}}">اعدادات الحساب </a>

                    </li>
                    <li><span class="glyphicon glyphicon-envelope"></span><a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> تسجيل الخروج </a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>

        <!--/End side bar main menu-->

        <!--Start Main content container-->
        <div class="main_content_container" style="margin-top:60px;">

            @Yield('content')
        </div>
        <!--/End body container section-->
    </div>
    </div>
    @Yield('script')
    <script type="text/javascript" src="{{asset('js/jquery-2.1.4.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/js.js')}}"></script>
    @endif
</body>

</html>