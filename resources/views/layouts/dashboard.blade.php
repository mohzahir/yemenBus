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
    <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
<meta name="_token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

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
        <div class="col-sm-3 col-xs-12 logo_area bring_right" style="float:right">
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
        

    </div>
    <!--/End header-->

    <!--Start body container section-->
    <div class="row container_section">

        <!--Start left sidebar-->
        <div class="user_details close_user_details  bring_left"  style="height:300px;width:250px;" >
            <div class="user_area">
            

                <h1 class="h3"></h1>
                <p><a href="{{route('dashboard.marketer.showAccountInfo')}}">بيانات المستخدم</a></p>

                <p><a href="{{route('dashboard.marketer.updateAccountInfoForm')}}">اعدادت الحساب</a></p>

            </div>
            </div>
        <!--/End left sidebar-->

        <!--Start Side bar main menu-->
        <div class="main_sidebar bring_right" style="width:250px;">
            <div class="main_sidebar_wrapper">
                <form class="form-inline search_box text-center">
                    <div class="form-group">
                       {{--<input type="text" class="form-controller" id="search" name="search"></input>--}}
                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span>
                        </button>
                    </div>
                </form>

                <ul>
                    <li><span class="glyphicon glyphicon-home"></span><a href="{{route('dashboard.marketer.index')}}">الصفحة الرئيسية</a></li>
                    <li><span class="glyphicon glyphicon-edit"></span><a href="https://www.yemenbus.com/orders">بحث عن طلب   </a></li>
                    
                    <li><span class="glyphicon glyphicon-edit"></span><a href="{{route('dashboard.reservations.confirm')}}">حجز رحلة نقل بالباص</a></li>
                    <li><span class="glyphicon glyphicon-edit"></span><a href="{{route('marketer.reservations.confirmAll')}}">حجوزات النقل بالباص </a>
                    
                    <li><span class="glyphicon glyphicon-edit"></span><a href="{{route('marketer.haj.reservations.create')}}">حجز رحلة حج وعمرة</a></li>
                    <li><span class="glyphicon glyphicon-edit"></span><a href="{{route('marketer.haj.reservations.index')}}">حجوزات الحج والعمرة </a>
                        
                    </li>
  <li><span class="glyphicon glyphicon-edit"></span><a href="{{ route('marketer.trips')}}">بحث عن رحلات</a></li>
                 
                    
                     <li><span class="glyphicon glyphicon-edit"></span><a href="https://www.yemenbus.com/trips/order">طلب عرض سعر  </a></li>
                     
                     
                    <li><span class="glyphicon glyphicon-envelope"></span><a href="{{route('dashboard.marketer.sms')}}">ارسال رسالة للعميل</a></li>

                    <li><span class="glyphicon glyphicon-user"></span><a href="{{route('dashboard.marketer.updateAccountInfoForm')}}">أعدادت الحساب </a>
                        
                    </li>
<li><span class="glyphicon glyphicon-user"></span><a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> تسجيل الخروج </a></li>
 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>                              </ul>
            </div>
        </div>

        <!--/End side bar main menu-->

        <!--Start Main content container-->
        <div class="main_content_container">
            
@Yield('content')
</div>
<div >
{{-- <table class="table table-bordered table-hover" style="margin-top:100px;margin-right:300px;width:1000px;text-align:right" >
<thead style="margin-top:100px;">
<tr>
<th>رقم الطلب </th>
<th>رابط الطلب</th>
<th> جوال مسافر</th>
<th>كود المسوق</th>
<th> المبلغ كامل </th>
<th>المبلغ حسب الطلب  </th>
<th> التاريخ</th>
</tr>
</thead>
<tbody>
</tbody>
</table>--}}
</div></div></div>

@Yield('script')
<script type="text/javascript" src="{{asset('js/jquery-2.1.4.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/js.js')}}"></script>
<script type="text/javascript">
$('#search').on('keyup',function(){
$value=$(this).val();
$.ajax({
type : 'get',
url : '{{route('search')}}',
data:{'search':$value},
success:function(data){
$('tbody').html(data);
}
});
})
</script>
<script type="text/javascript">
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
</body>

</html>