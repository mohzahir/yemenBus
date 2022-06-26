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
    <h1>خدمات المسوق</h1>
@stop

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">

    <a href="{{ route('dashboard.reservations.confirm') }}" class="btn btn-primary mb-2">طلب تأكيد حجز</a>
    <a href="{{ route('dashboard.reservations.postpone') }}" class="btn btn-warning mb-2">طلب تأجيل حجز</a>
    <a href="{{ route('dashboard.reservations.cancel') }}" class="btn btn-danger mb-2">طلب إلغاء حجز</a>
    <a href="{{ route('dashboard.marketers.sms') }}" class="btn btn-info mb-2">إرسال رسالة نصية لعميل</a>
</div>
@stop
