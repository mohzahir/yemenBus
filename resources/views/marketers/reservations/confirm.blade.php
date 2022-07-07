@extends('layouts.dashboard')
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
    <h1>تأكيد حجز</h1>
@endsection

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
    <nav aria-label="breadcrumb" style="" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.marketer.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">  حجز رحلة نقل بالباص</li>
  </ol>
</nav>
<h1 style="text-align:center">حجز رحلة نقل بالباص</h1>

@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>	
    <strong>{{ $message }}</strong>
</div>
@endif
{{-- @if ($message = Session::get('error')) --}}

@if ($errors->any())
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button>
    @foreach ($errors->all() as $error)
  <p class="yellow-text font lato-normal center">{{ $error }}</p>
  @endforeach
</div>
@endif
    <form class="form-contact contact_form" action="{{ route('dashboard.reservations.storeConfirm') }}"
        method="post" novalidate="novalidate">
        @csrf
       <div class="row">
           <div class="col-12">
               <div class="form-group d-flex">
                   <div class="form-group">
                    <select class="form-control" name="trip_id" id="trip_id">
                        <option value="">اختر رحلة</option>
                        @if (count($trips) > 0)
                            @foreach ($trips as $trip)
                                <option value="{{$trip->trip_id}}" @if(old('trip_id') == $trip->trip_id) selected @endif> من مدينه {{$trip->takeoff_city->name }} الى مدينه {{$trip->arrival_city->name }} . اتجاه الرحله {{ $trip->direcation == 'yts' ? ' من اليمن للسعوديه ' : ($trip->direcation == 'sty' ? ' من السعوديه لليمن' : 'رحله داخل اليمن')}} . مزود الخدمه {{ $trip->provider->name_company }} . سعر الرحله {{ $trip->price }} ريال</option>
                            @endforeach
                        @endif
                    </select>
                   </div>
                   
                   <div class="phone-intro">
                       <select class="form-control" name="phoneCountry" id="phoneCountry">
                           <option value="s" @if(old('phoneCountry') == 's') selected @endif>966+</option>
                           <option value="y" @if(old('phoneCountry') == 'y') selected @endif>967+</option>
                           
                        </select>
                    </div>  
                    <input class="form-control valid" placeholder="512345678" name="phone" id="phone" type="text" value="{{ old('phone') }}"
                    placeholder=" * رقم الجوال ">

               </div>
               
           </div>
           <div class="col-sm-12">
               <div class="form-group">
                   <input class="form-control valid" name="email" id="email" type="text" value="{{ old('email') }}"
                   placeholder="البريد الالكتروني">
               </div>
           </div>
           <div class="col-sm-12">
               <div class="form-group">
                   <textarea class="form-control w-100" name="notes" id="notes" cols="30" rows="6" 
                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'ملاحظات'" placeholder=" ملاحظات">
                   {{ old('notes') }}
               </textarea>
               </div>
               <input type="hidden" name="ticketNo" value="1">
           </div>
           <hr>

           <div class="col-sm-12 add-passenger-container">
               <h3 style="margin-bottom: 20px"> بيانات الراكب</h3>

               <div class="form-group d-flex passenger-row" id="passenger-row">
                   <input class="form-control valid" name="name[]" id="name" type="text" value="{{ old('name') }}"
                   placeholder=" اسم الراكب">
                   
                   <div style="margin-right: 3px"></div>
                   <select class="form-control" name="age[]" id="age">
                       <option value="">الفئة العمرية للراكب</option>
                       <option {{ old('age.0') == 'adult' ? 'checked' : '' }} value="adult">بالغ</option>
                       <option  {{ old('age.1') == 'child' ? 'checked' : '' }} value="child">طفل (من سنتين الى 12)</option>
                       <option {{ old('age.2') == 'baby' ? 'checked' : '' }} value="baby">رضيع (تحت السنتين)</option>
                   </select>
                   <div style="margin-right: 3px"></div>

                   <select class="form-control" name="gender[]" id="gender">
                       <option  value="">جنس الراكب</option>
                       <option {{ old('gender.0') == 'female' ? 'checked' : '' }} value="femal">انثى</option>
                       <option {{ old('gender.0') == 'male' ? 'checked' : '' }} value="male">ذكر</option>
                   </select>
             
                   <input class="form-control" name="dateofbirth[]" id="dateofbirth" type="text"
                   style="margin-right: 3px" onfocus="(this.type='date')"
                   placeholder="تاريخ الميلاد" value="{{ old('dateofbirth.0') }}">

                   <input class="form-control" name="nid[]" id="nid" type="text"
                   style="margin-right: 3px" value="{{ old('nid.0') }}"
                   placeholder="رقم هوية الراكب">
               </div>
               
           </div>
           <div class="col-sm-12">
               <div class="form-group">
                   <a href="#" class="ticket-form add-ticket"> اضافة راكب</a>
                   <a href="#" id="" class="ticket-form remove-ticket" style="display: none"> حذف راكب</a>

               </div>
           </div>

           <div class="col-sm-12">
               <div class="form-group">
                   <input onclick="$('#deposit_value').css('display', 'none')" type="radio" class="form-radio" name="payment_type" value="total_payment"> دفع كامل المبلغ
                   <input onclick="$('#deposit_value').css('display', 'block')" type="radio" class="form-radio" name="payment_type" value="deposit_payment"> دفع عربون
               </div>
               
                <div id="deposit_value" style="display: none">
                    {{-- <input type="text" class="form-control" placeholder="المبلغ المدفوع" name="paid" value="{{old('paid')}}"> --}}
                    <div>
                        <p class="text-danger">قيمه العربون للرحلات من السعوديه لليمن هي {{ env('DEPOSIT_RS_VALUE', 50) }}</p>
                        <p class="text-danger">قيمه العربون للرحلات من اليمن للسعوديه هي {{ env('DEPOSIT_RY_VALUE', 5000) }}</p>
                    </div>
                </div>

                <div class="text-primary">
                    <p> رصيدك بالريال السعودي ({{ $marketer->balance_rs}}) </p>
                    <p> رصيدك بالريال اليمني ({{ $marketer->balance_ry}}) </p>
                </div>
           </div>

       </div>
       <div class="form-group reserve-btn">
           <button type="submit" class="btn btn-success">توجه للدفع</button>
       </div>
   </form>
    </div>
    @endsection
@section('script')
<script src="http://127.0.0.1:8000/passenger-assets/js/ticket.js"></script>
<script type="text/javascript">

$('#date').on('change',function(e){
  e.preventDefault();
$date=$('#date').val();
$.ajax({
type : 'get',
url : "{{route('reservation.date')}}",

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
$(document).on('submit','#myForm', function (e) {
    e.preventDefault();
     $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
var form_data = new FormData(document.getElementById("myForm"));

   var amount=0;
    
    if( $('input[name=amount_type]:checked','#myForm').val()=='full'){
         amount = $("#amount").val();
    }
    else{
         amount = $("#amount_deposit").val();

    }
    var currency = $("#currency").val();
    if(currency=='sar'){
        var currency = "ريال سعودي";
    }else{
        var currency = "ريال يمني";
    }
    swal({
        title:"سيتم خصم مبلغ "+amount+" "+currency+" من رصيدك في الموقع هل تريد اتمام للعمليه ؟",
             type: "question",
            confirmButtonClass: "btn-danger",
            confirmButtonText: 'نعم',
  cancelButtonText: 'لا',
  showCancelButton: true,
  showCloseButton: true
        }).then(function () {   
            $.ajax({
                type: "post",
                url: "{{route('dashboard.reservations.storeConfirm')}}",
data:form_data,
   dataType:'JSON',
   contentType: false,
   cache: false,
   processData: false,

               /* data: {           
                    "_token": "{{ csrf_token() }}",
                    "order_id": $("#order_id").val(),
                    "order_url": $("#order_url").val(),
                    "passenger_name": $("#passenger_name").val(),
                    "passenger_phone": $("#passenger_phone").val(),
                    "passenger_phone_yem": $("#passenger_phone_yem").val(),
                    "provider_id": $("#provider_id").val(),
                    "amount": $("#amount").val(),
                    "amount_deposit": $("#amount_deposit").val(),
                    "day": $("#day").val(),
                    "date": $("#date").val(),
                    "code": $("#code").val(),
                    "from_city": $("#from_city").val(),
                    "to_city": $("#to_city").val(),
                    "ticket_no": $("#ticket_no").val(),
                    "image": $("#image").val(),
                    "currency": $("#currency").val(),
                    "amount_type":  $('input[name=amount_type]:checked','#myForm').val(),
},*/
success: function(res){
    if($.isEmptyObject(res.error)){
                        
                        
    if(res.msge=='success'){
        var currency = $("#currency").val();
    if(currency=='sar'){
        var currency = "ريال سعودي";
    }else{
        var currency = "ريال يمني";
    } 
        

        if($('input[name=amount_type]:checked','#myForm').val()=='full'){
         amount = $("#amount").val();
         amount_deposit=$("#amount_deposit").val();
         date=$("#date").val();
         order_id=$("#order_id").val();
        swal({
                            title: "تم تاكيد الحجز بنجاح",
                            text: ' تم تاكيد الحجز بمبلغ '+amount+'  '+currency+' من مبلغ  '+amount+'   '+currency+' في  تاريخ '+date,
                            type: "success",
                            confirmButtonText: 'توجه لصفحةالحجوزات',
  showCloseButton: true
        }).then(function () {  
            window.location=res.url;
 
        });

    }
    else{
        amount = $("#amount").val();
         amount_deposit=$("#amount_deposit").val();
         order_id=$("#order_id").val();
         date=$("#date").val();

        
    
    swal({
                            title: "تم تاكيد الحجز بنجاح",
                            text: ' تم تاكيد الحجز بمبلغ '+amount_deposit+'  '+currency+' من مبلغ  '+amount+'   '+currency+' في  تاريخ '+date,
                            type: "success",
                            confirmButtonText: 'توجه لصفحةالحجوزات',
  showCloseButton: true
        }).then(function () {  
            window.location=res.url;
 
        });

        
}}else{
    swal({
                            title: "رصيدك غير  كافي ",
                            type: "warning",
        }).then(function () {  
 
        });
}
}else{
    window.scrollTo(0, 0); 
       
    printErrorMsg(res.error);
                    }

                    
}
,
                 


            });
    });
    function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li style="list-style-type: none;">'+value+'<button type="button" class="close" data-dismiss="alert">×</button></li>');
            });
        }

});

/*
swal({
    title: "Are you sure to delete this  of ?",
    text: "Delete Confirmation?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Delete",
    closeOnConfirm: false
  },
  function() {
    $.ajax({
        type: "post",
        url: "{{route('dashboard.reservations.storeConfirm')}}",
        data: "data",
        success: function(data) {}
      })
      .done(function(data) {
        swal("Deleted!", "Data successfully Deleted!", "success");
      })
      .error(function(data) {
        swal("Oops", "We couldn't connect to the server!", "error");
      });
  }
);
});*/
</script>
@endsection


       
       