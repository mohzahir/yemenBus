@extends('layouts.admin')
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
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">  تعديل بيانات الحجز</li>
  </ol>
</nav>
<h1 style="text-align:center"> تعديل  الحجز</h1>
<div class="alert  alert-danger print-error-msg" style="display:none">
<button type="button" class="close" data-dismiss="alert" style="float:left">×</button>
        <ul></ul>
    </div>

<form enctype="multipart/form-data"  id="myForm" class="pb-4 @if ($errors->any()) was-validated @endif" style="margin-bottom:40px;">
        <div class="form-group mt-2">
            <label for="ticket_no">عدد التذاكر</label>
            <input type="text" class="form-control" id="ticket_no" name="ticket_no"   value="{{$reservation->ticket_no}}" >
        </div>
        <div class="form-group mt-2">
            <label for="order_id">رقم الطلب</label>
            <input type="text" class="form-control" id="order_id" name="order_id"  @if($reservation->order_id) value="{{$reservation->order_id}}" @endif >
        </div>
     <div class="form-group mt-2">
            <label for="demand_id">رقم العرض</label>
            <input type="text" class="form-control" id="demand_id" name="demand_id" @if($reservation->demand_id !=0) value="{{$reservation->demand_id}}" @endif>
        </div>
        
          <div class="form-group mt-2">
            <label for="order_url">رابط الطلب</label>
            <input type="url" class="form-control" id="order_url" name="order_url" @if($reservation->order_url) value="{{$reservation->order_url}}" @endif>
        </div>
          <div class="form-group mt-2">
            <label for="image"> ارفاق صورة الطلب</label> (الحقل اختياري)
            <input type="file" class="form-control" id="image" name="image" >
        </div>
   
        
        <button class="btn btn-success btn-lg" type="submit">تعديل  الحجز</button>
        
  <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a><a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.marketer.index') }}">اغلاق</a>

    </form>
    </div>
@stop

@section('script')
    <script>
        $('#postpone_to').attr('min', new Date().toISOString().split('T')[0]);
    </script>

<script type="text/javascript">
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
<script type="text/javascript">
$(document).on('submit','#myForm', function (e) {
    e.preventDefault();
     $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
var form_data = new FormData(document.getElementById("myForm"));
    swal({
        title:"هل تريد تعديل الحجز؟",
             type: "question",
            confirmButtonClass: "btn-danger",
            confirmButtonText: 'نعم',
  cancelButtonText: 'لا',
  showCancelButton: true,
  showCloseButton: true
        }).then(function () {   
        
            $.ajax({
                type: 'post',
                url: "{{route('admin.reservations.update',$reservation->id)}}",
                /*data: {           
                    "_token": "{{ csrf_token() }}",
                    "id": $("#id").val(),
                    "order_id": $("#order_id").val(),
                    "order_link": $("#order_link").val(),
                    "demand_id": $("#demand_id").val(),
                    "ticket_no": $("#ticket_no").val(),
                    "image": $("#image").val(),
},*/
data:form_data,
   dataType:'JSON',
   contentType: false,
   cache: false,
   processData: false,

success: function(res){

                        


        swal({
                            title: "تم تعديل  الحجز بنجاح",
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

</script>@endsection

