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
    <link  href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link href="{{asset('css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">
    <meta name="_token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
  <script type="text/javascript" src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery-3.5.1.js')}}"></script>


    <style>
    .bring_left {
    float: left;
}
h1,h2,h3,p,a{
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
<div class="container-fluid">
    <!--Start header-->
    <div class="row header_section" >
        <div class="col-sm-3 col-xs-12 logo_area bring_right" style="float:right;width:250px">
            <h1 class="inline-block" ><img src="{{asset('img/logo.png')}}" alt="">لوحة تحكم</h1>
            <span class="glyphicon glyphicon-align-justify bring_left open_close_menu" data-toggle="tooltip"
                  data-placement="right" title="Tooltip on left"></span>
        </div>
        <div class="col-sm-3 col-xs-12 head_buttons_area bring_right hidden-xs" style="float:right">
       
            <div class="inline-block full_screen bring_right hidden-xs">
                <span class="glyphicon glyphicon-fullscreen" data-toggle="tooltip" data-placement="left"
                      title="شاشة كاملة"></span>
            </div>
        </div>
        <div class=" col-sm-4 col-xs-12 user_header_area bring_left left_text" style="float:left">

            <div class="user_info inline-block">
                <span class="h4 nomargin user_name"></span>
                <span class="glyphicon glyphicon-cog"></span>
            </div>
        </div>
        

    </div>
    <!--/End header-->

    <!--Start body container section-->
    <div class="row container_section">

        <!--Start left sidebar-->

        <!--Start Side bar main menu-->
        <div class="main_sidebar bring_right" style="width:250px;">
            <div class="main_sidebar_wrapper">
                 
                <ul>
                <li><span class="glyphicon glyphicon-home"></span><a href="{{route('dashboard.lab.index')}}">صفحه رئيسية</a></li>

                    <li><span class="glyphicon glyphicon-user"></span><a href="{{route('dashboard.lab.pcrs')}}">طلبات الفحص </a>
                    <li><span class="glyphicon glyphicon-calendar"></span><a href="{{route('dashboard.lab.pcrsSuspend')}}">طلبات قيد المتابعة </a>
                    <li><span class="glyphicon glyphicon-user"></span><a href="{{route('dashboard.lab.setting')}}">بيانات الحساب  </a>
                        
                    </li>


                  {{--  <li><span class="glyphicon glyphicon-edit"></span><a href="{{route('dashboard.lab.setting')}}">أعدادت الحساب </a></li>--}}
                     <li><span class="glyphicon glyphicon-envelope"></span><a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> تسحجيل الخروج </a></li>
 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                 </ul></div></div>

        <!--/End side bar main menu-->

        <!--Start Main content container-->
        <div style="text-align:center;float:center;">
        </div>

        <div class="main_content_container" style="margin-top:100px;">

@Yield('content')
</div></div></div></body>
        <!--/End body container section-->





<script type="text/javascript" src="{{asset('js/jquery-2.1.4.min.js')}}"></script>

<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/js.js')}}"></script>
@Yield('script')

<script type="text/javascript">
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
</body>

</html>