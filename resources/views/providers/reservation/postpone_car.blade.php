@extends('layouts.providerDashboard')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>

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
    <h1>طلب تأجيل حجز</h1>
@stop

@section('content')

<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
                        <nav aria-label="breadcrumb" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.provider.showAccountInfo')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page"> طلب تأجيل الحجز </li>
  </ol>
</nav>
<h1 style="text-align:center">طلب تأجيل حجز</h1>
<div class="alert  alert-danger print-error-msg" style="display:none">
<button type="button" class="close" data-dismiss="alert" style="float:left">×</button>
        <ul></ul>
    </div>

<form id="myForm" class="pb-4 @if ($errors->any()) was-validated @endif" style="margin-bottom:40px;">
    @csrf
 <input type="hidden" class="form-control" name="id" id="id" value="{{$reservation->id}}" >
        <div class="form-group mt-2">
            <label for="order_id">رقم الطلب</label>
            <input type="text" class="form-control" id="order_id" name="order_id" value="{{$reservation->order_id}}">
        </div>
   
         
        <div class="form-group mt-2">
            <label for="passenger_phone">جوال المسافر </label>
            <input type="text" class="form-control" id="passenger_phone" name="passenger_phone" placeholder="مثال +9661231313131"  value="{{$reservation->passenger_phone}}" >
        </div>
         <div class="form-group mt-2">
            <label for="passenger_phone_yem">   جوال المسافر اليمني  </label>
            <input type="text" class="form-control" id="passenger_phone_yem" name="passenger_phone_yem" placeholder="مثال +9671231313131"  value="{{$reservation->passenger_phone_yem}}" >
        </div>
        <div class="form-group mt-2">
            <label for="amount">مبلغ</label>
            <input type="number" min="1" class="form-control" id="amount" name="amount" value="{{$reservation->amount}}">
        </div>
               
        <div class="form-group mt-2">
            <label for="currency">العملة</label>
            <select name="currency" class="form-control" id="currency" required>
           
                <option value="sar"  @if($reservation->currency=='sar')selected @endif >ريال سعودي</option>
                <option value="yer"  @if($reservation->currency=='yer')selected @endif>ريال يمني</option>
            </select>
        </div>
 <div class="form-group mt-2">
            <label for="day">اليوم</label>
            <select name="day" class="form-control" id="day" required>
                <option value="" @if($reservation->day=="")selected @endif >-- اختر -- </option>
                 <option id="sat" value="sat" @if($reservation->day=="sat")selected @endif >السبت</option>
                <option  id="sun"value="sun" @if($reservation->day=="sun")selected @endif>الاحد </option>
                <option  id="mon" value="mon" @if($reservation->day=="mon")selected @endif>الاثنين </option>
                <option id="tue" value="tue" @if($reservation->day=="tue")selected @endif>الثلاثاء </option>
                <option id="wed" value="wed" @if($reservation->day=="wed")selected @endif>الاربعاء </option>
                <option id="thu" value="thu" @if($reservation->day=="thu")selected @endif>الخميس </option>
                <option id="fri" value="fri" @if($reservation->day=="fri")selected @endif>الجمعة </option>>
                
            </select>        </div>



        <div class="form-group mt-2">
            <label for="date">التأجيل إلى تاريخ</label>
            <input type="date" class="form-control" name="date" id="date" required @if($reservation->date)value="{{ \Carbon\Carbon::parse($reservation->date)->format('Y-m-d')}}"@endif >
                
        </div>
        <div class="form-group mt-2">
            <label for="note">ملاحظات</label>
            <textarea class="form-control" name="note" id="note"></textarea>
        </div>
        <button class="btn btn-success btn-lg" type="submit">طلب تأجيل الحجز</button>
        
  <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a><a class="btn btn-danger btn-close btn-lg" href="{{route('dashboard.provider.showAccountInfo')}}">اغلاق</a>

    </form>
    </div>
@stop

@section('script')
    <script>
        $('#postpone_to').attr('min', new Date().toISOString().split('T')[0]);
    </script>
<script type="text/javascript">
$('#date').on('change',function(e){
  e.preventDefault();
$date=$('#date').val();
$.ajax({
type : 'get',
url : '{{route('provider.date')}}',
data:{
  'date':$date,
 
  '_token':'{{csrf_token()}}',


},
success:function(data){
$('#'+data).attr('selected','true');
}
});
})
</script>
<script type="text/javascript">
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
<script type="text/javascript">
$(document).on('submit','#myForm', function (e) {
    e.preventDefault();

date=$("#date").val();
    swal({
        title:"هل تريد تاجيل الحجز الى   "+date+" ?",
             type: "question",
            confirmButtonClass: "btn-danger",
            confirmButtonText: 'نعم',
  cancelButtonText: 'لا',
  showCancelButton: true,
  showCloseButton: true
        }).then(function () {   
            $.ajax({
                type: "post",
                url: "{{route('provider.reservations.storePostpone_car')}}",
                data: {           
                    "_token": "{{ csrf_token() }}",
                    "id": $("#id").val(),
                    "day": $("#day").val(),
                    "date": $("#date").val(),
                    // "code": $("#code").val(),
                    "note": $("#note").val(),
},
success: function(res){
var url=res.url;

date=$("#date").val();


        swal({
                            title: "تم تاجيل  الحجز بنجاح",
                            text: ' تم تاجيل الحجز الى تاريخ '+date,
                            type: "success",
                            confirmButtonText: 'توجه لصفحة الحجوزات',
                            showCloseButton: true
        }).then(function () {  
            window.location=res.url;
 
        });

    }
 

                    

,
                 


            });
    });
        

});

</script>
@endsection