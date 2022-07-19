@extends('layouts.dashboard')
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
@section('content_header')
    <h1>أرشيف المسوق</h1>
@stop

@section('content')

<h1 style="text-align:center"> مرحبا بك  {{Auth::guard('marketer')->user()->name}} في   لوحه   التحكم   الخاصة   بك </h1>

    
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
<div class="pb-4">
        <div class="row">
            <div class="col-lg-4 col-md-6" >
                <div class="small-box bg-info" style="width:300px;height:100px;color:#fff;background-color: #c0392b;text-align:center;margin-top:50px;">
                    <div class="inner" style="float:center;padding-top:1px;">
                    <h3>{{$deposit_amount}}</h3>
                        <p>حجوزاتي بعربون</p>
                    </div>
                    {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
            <div class="small-box bg-info" style="width:300px;height:100px;color:#fff;background-color: #2980b9;text-align:center;margin-top:50px;">
            <div class="inner" style="float:center;padding-top:1px;">
                    <h3  style="float:center;">{{$full_amount}}</h3>
                        <p>حجوزاتي بالمبغ كاملاً</p>
                    </div>
                    {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
            <div class="small-box bg-info" style="width:300px;height:100px;color:#fff;background-color: #8e44ad;text-align:center;margin-top:50px;">
                    <div class="inner" style="float:center;padding-top:1px;">
                    <h3>{{$postpone}}</h3>
                        <p>طلبات تعديل حجز</p>
                    </div>
                    {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                </div>
            </div>
             {{--<div class="col-lg-4 col-md-6">
            <div class="small-box bg-info" style="width:300px;height:100px;color:#fff;background-color: #d35400;text-align:center;margin-top:20px;">
                    <div class="inner" style="float:center;padding-top:1px;">
                    <h3>5</h3>
                        <p>طلبات الغاء حجز</p>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> 
                </div>
            </div>--}}
            <div class="col-lg-4 col-md-6">
            <div class="small-box bg-info" style="width:300px;height:100px;color:#fff;background-color: #2c3e50;text-align:center;margin-top:20px;">
                    <div class="inner" style="float:center;padding-top:1px;">
                    <h3>{{$confirm}}</h3>
                    <p> الحجوزات المؤكدة </p>
                    </div>
                    {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
            <div class="small-box bg-info" style="width:300px;height:100px;color:#fff;background-color: #2c3e50;text-align:center;margin-top:20px;">
                    <div class="inner" style="float:center;padding-top:1px;">
                    <h3>{{$cancel}}</h3>
                        <p>الغاء الحجز</p>
                    </div>
                    {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                </div>
            </div>  
             
            
        </div>

        
    </div>
    </div>
    
@stop