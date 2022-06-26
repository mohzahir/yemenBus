@extends('layouts.admin')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
  <style>
 
h1,h2,h3{
font-family: 'Cairo', sans-serif;
}
p{
    font-family: 'Cairo', sans-serif;
    font-size:20px;

}
label{
    font-family: 'Cairo', sans-serif;
    font-size:16px;
 
}
</style>
@endsection

@section('content')
<div class="main_container  main_menu_open">
                <!--Start system bath-->
                <div class="home_pass hidden-xs">
                    <ul>
                        <li class="bring_right"><span class="glyphicon glyphicon-home "></span></li>
                        <li class="bring_right"><a href="">الصفحة الرئيسية للوحة تحكم الموقع</a></li>
                    </ul>
                </div>
                <!--/End system bath-->
                <div class="page_content">
                <div class="home_statics text-center">
                            <h1 class="heading_title">احصائيات عامة للموقع</h1>

                            <div style="background-color: #9b59b6">
                                <span class="bring_right glyphicon glyphicon-home"></span>

                                <h3>إجمالي المشاركين في القرع</h3>

                                <p class="h4">{{ $total_participants }}</</p>
                            </div>

                            <div style="background-color: #00adbc">
                                <span class="bring_right glyphicon glyphicon-user"></span>

                                <h3>عدد القرع الكلي </h3>

                                <p class="h4">{{ $total_competitions }}</p>
                            </div>
                            
                        </div>

                    <div class="page_content">
                        
                        <div class="quick_links text-center">
                            <a href="#" style="background-color: #c0392b">
                                <h4>عدد المسوقين</h4>
                                <p class="h4" style="color:#fff">{{$total_marketer }}</p> 
                            </a>
                            <a href="" style="background-color: #2980b9">
                                <h4> عدد المزودين</h4>
                                <p class="h5" style="color:#fff">{{ $total_provider }}</p>
                            </a>
                            <a href="" style="background-color: #8e44ad">
                                <h4>عدد الحجوزات المؤكده</h4>
                                <p class="h5"style="color:#fff">{{$total_reservation_confirm }}</p>
                            </a>
                           
                            
                        </div>
                                            </div>
                </div>
                        </div>
            </div>
            <!--/End Main content container-->
@endsection
