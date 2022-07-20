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
  <script src="//unpkg.com/alpinejs" defer></script>

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
    <h1>طلب نقل الحجز</h1>
@stop

@section('content')

<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
     <nav aria-label="breadcrumb" style="margin-top:-50px;" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">نقل الحجز</li>
  </ol>
</nav>
@include('flash-message')

        <h1 style ="text-align:center">نقل الحجز بالرقم ({{ $reservation->id }})</h1>
<div x-data="{
    trip : null,
    async getTripData(id) {
        console.log(id)
        if (id) {
            this.trip = await (await fetch('{{ route('getTripData') }}' + '/?id=' + id)).json();

            // log out all the posts to the console
            console.log(this.trip);
        }
    }
}">
    <form action="{{ route('admin.reservations.storetransfer') }}" method="post"  id="myForm" class="pb-4 @if ($errors->any()) was-validated @endif" style=" margin-bottom:40px;" >
        @csrf

        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
    
        <div class="row">
            <div class="col-12">
                <p class="text-danger"> نلفت انتباهك الى انه سوف يتم الغاء الحجز الحالي للعميل واضافة حجز جديد في الرحلة التي ستقوم بإختيارها</p>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-">
                <div class="form-group">
                    <label for="trip_id">اسم العميل</label>
                    <p>{{ $reservation->passenger->name_passenger }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-">
                <div class="form-group">
                    <label for="trip_id">معلومات الرحلة الحالية</label>
                    <p>  رحلة من {{ $reservation->trip->takeoff_city->name }} الى {{ $reservation->trip->arrival_city->name }} - السعر {{ $reservation->trip->price }}  - التاريخ {{ $reservation->trip->from_date }} - بالرقم {{ $reservation->trip->id }} </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-">
                <div class="form-group">
                    <label for="trip_id">عدد التزاكر</label>
                    <p> {{ $reservation->ticket_no }} </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-">
                <div class="form-group">
                    <label for="trip_id">اختر الرحلة الجديدة </label>
                    <select x-on:change="getTripData($el.value)" name="trip_id" id="trip_id" class="form-control" required>
                        <option value="">-- قم باختار الرحلة التي تريد نقل الحجز اليها --</option>
                        @foreach($trips as $trip)
                            <option  @if(old('trip_id') == $trip->id) selected @endif value="{{ $trip->id }}">رحلة من {{ $trip->takeoff_city->name }} الى {{ $trip->arrival_city->name }} - السعر {{ $trip->price }}  - التاريخ {{ $trip->from_date }} - بالرقم {{ $trip->id }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    
        <template x-if="trip">
            <div >
                <h2>معلومات الرحلة الجديدة</h2>
        
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trip_id">رقم الرحلة</label>
                            <p x-text="trip.id">  </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trip_id">المزود</label>
                            <p x-text="trip.provider.name_company">  </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trip_id">مدينة الوصول</label>
                            <p x-text="trip.arrival_city.name">  </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trip_id">مدينة الانطلاق</label>
                            <p x-text="trip.takeoff_city.name">  </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trip_id">العملة</label>
                            <p x-text="trip.currency == 'rs' ? 'ريال سعودي' : 'ريال يمني'" >  </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trip_id">السعر</label>
                            <p x-text="trip.price">  </p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trip_id">التاريخ</label>
                            <p x-text="trip.from_date">  </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trip_id">موعد الحضور</label>
                            <p x-text="trip.coming_time">  </p>
                        </div>
                    </div>
                    <hr>
                    <h2>البيانات المالية</h2>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trip_id">سعر الرحلة الجديدة</label>
                            <p x-text="trip.price">  </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trip_id">المبلغ المدفوع للحجز الحالي</label>
                            <p> {{ $reservation->paid }} </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trip_id">العملة</label>
                            <p x-text="trip.currency == 'rs' ? 'ريال سعودي' : 'ريال يمني'" >  </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="trip_id">  الفرق بين المبلغين <span class="text-danger text-sm">اذا كان المبلغ بالسالب فهذا يعني ان العميل يستحق المبلغ ادناه</span></label>
                            <p x-text="trip.price - {{ $reservation->paid }}">  </p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <p class="text-danger">الرجاء تسوية الحسابات مع العميل قبل الضغط على ذر نقل الحجز</p>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        
    
            
            <button id="submit" class="btn btn-success btn-lg" type="submit">نقل الحجز</button>    
            
            
         
                 <!-- <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a>
         <a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.admin.index') }}">اغلاق</a> -->
    
       
        </form>

</div>
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
url : '{{route('admin.reservation.date')}}',
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
    var date= $("#date").val();
    var order_id= {{ $reservation->id }};
    var trip_id= $("#trip_id").val();
    var provider_name= $( "#provider_name" ).val();
    
    swal({
        title:' هل انت متاكد من نقل الحجز رقم  '+order_id+' الى رحله رقم '+trip_id+' ,
        type: "question",
            confirmButtonClass: "btn-danger",
            confirmButtonText: 'نعم',
  cancelButtonText: 'لا',
  showCancelButton: true,
  showCloseButton: true
        }).then(function () {
            console.log('dsdsd');
            $('#myForm').submit();
        });
      
        
       
    });
    </script>
@endsection