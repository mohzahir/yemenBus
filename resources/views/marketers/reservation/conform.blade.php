@extends('layouts.dashboard')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-PMjWzHVtwxdq7m7GIxBot5vdxUY+5aKP9wpKtvnNBZrVv1srI8tU6xvFMzG8crLNcMj/8Xl/WWmo/oAP/40p1g==" crossorigin="anonymous" />
 <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
 <meta name="_token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

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

th,td{
    text-align:center;
    vertical-align:center;
    horizontal-align:center;
    width:50;
    height:80;
    font-family: 'Cairo', sans-serif;

}
.form-control::placeholder {
  font-size: 0.95rem;
  color: #aaa;
  
  font-style: italic;
}
#myInput {
  background-image:  url("{{asset('/img/search.png')}}");

  background-position: 10px 12px; /* Position the search icon */
  background-repeat: no-repeat; /* Do not repeat the icon image */
  width: 100%; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 1px solid #ddd; /* Add a grey border */
  margin-bottom: 12px; /* Add some space below the input */
}




</style>
@endsection


@section('content_header')
    @if (Session::has('message'))
        <div class="alert alert-{{ Session::get('type', 'warning') }}">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="d-flex justify-content-between" style="dispaly:inline;">
        <h1>حجوزاتي</h1>        
    </div>
@endsection

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- " style="margin-left:200px;">
          <nav aria-label="breadcrumb" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.marketer.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">  حجوزاتي</li>
  </ol>
</nav>
<h1 style="text-align:center">حجوزاتي  </h1>
@include('flash-message')


<div class="d-flex justify-content-between" style="dispaly:inline;">
        <form class="form-inline">
       <input type="text" id="myInput" onkeyup="myFunction()" placeholder="البحث عن الحجز  " style="background-image: url('{{ asset('img/search.png')}}');">

</form>
        
    </div>
  <div class="table-responsive">
<table id="myTable" class="table table-striped table-bordered" style="width:100%;text-align:center">
  <thead >
    <tr> 
    
      <th colspan="2" style="horizontal-align : middle;text-align:center; width: 50%;">الحجز </th>
      <th rowspan="2">رقم الرحله</th>
      <th rowspan="2">الخدمة</th>
      <th rowspan="2"> المزود</th>
      <th rowspan="2"> المسوق</th>
      <th rowspan="2">جوال المسافر السعودي</th>
      <th rowspan="2">جوال المسافر اليمني</th>
      <th rowspan="2">اسم المسافر </th>
      <th rowspan="2">مكان الانطلاق</th>
      <th rowspan="2">مكان الوصول</th>
      <th rowspan="2">مكان صعود الراكب </th>
      <th rowspan="2">مكان نزول الراكب </th>
      <th rowspan="2">مبلغ الحجز الكلي</th>
      <th rowspan="2">المبلغ المدفوع</th>
      <th rowspan="2">المبلغ المتبقي</th>
      <th rowspan="2">التاريخ</th>
      <th rowspan="2">اليوم</th>
      <th rowspan="2">موعد الحضور</th>
      <th rowspan="2">نوع التأكيد</th>
      <th rowspan="2">بوابة الدفع</th>
      <th rowspan="2">عدد التذاكر</th>
      <th rowspan="2">اجراءات</th>
      <th rowspan="2">وسائل التواصل</th>
    </tr>
     <tr>
       <th scope="col"> رقم الحجز</th>
       <th scope="col">حالة  الحجز</th>

  </tr>
  </thead>
  <tbody>

 
  
  
  
    @foreach ($reservations as $reservation)
    <?php  $marketer=App\Marketer::where('code',$reservation->code)->first();

    ?>
{{-- @if($marketer) --}}

<tr>                   
  <td>{{ $reservation->id }}</td>
  <td> <span class="badge badge-success"> @switch($reservation->status)@case('confirmed') مؤكد @break @case('created')بانتظار التاكيد @break @case('payed') تم الدفع @break @case('canceled') ملغي @break @default @endswitch</span></td>
  <td>{{ $reservation->trip_id }}</td>
  <td>{{ $reservation->trip->provider->service->name }}</td>
  <td>{{ $reservation->trip->provider->name_company }}</td>
  <td>{{ $reservation->marketer->name ?? '-' }}</td>
  <td>{{ $reservation->passenger->phone }}</td>
  <td>{{ $reservation->passenger->y_phone }}</td>
  <td>{{ $reservation->passenger->name_passenger }}</td>
  <td>{{ $reservation->trip->takeoff_city->name }}</td>
  <td>{{ $reservation->trip->arrival_city->name }}</td>
  <td>{{ $reservation->ride_place ?? $reservation->trip->takeoff_city->name }}</td>
  <td>{{ $reservation->drop_place ?? $reservation->trip->arrival_city->name }}</td>
  <td>{{ $reservation->total_price }}@switch($reservation->trip->currency)@case('rs')ريال سعودي@break @case('ry') ريال يمني@break @default @endswitch</td>
  <td>{{ $reservation->paid }}@switch($reservation->trip->currency)@case('rs')ريال سعودي@break @case('ry')ريال يمني @break @default 0 @endswitch</td>
  <td>{{ $reservation->total_price - $reservation->paid }} @switch($reservation->trip->currency)@case('rs')ريال سعودي@break @case('ry') ريال يمني@break @default @endswitch</td>
  <td>{{ date('d-m-Y', strtotime($reservation->trip->from_date) )}}</td>

  <td>
    <?php $days = json_decode($reservation->trip->day, true); ?>
    @foreach($days as $day)
    @switch($day)
    @case('all')يوميا @break
    @case('sat')السبت @break
    @case('all') كل الايام@break
    @case('sun') الاحد@break
    @case('mon') الاثنين @break
    @case('tue') الثلاثاء @break
    @case('wed') الاربعاء @break
    @case('thu') الخميس @break
    @case('fri') الجمعة @break
    @default
    @endswitch
    @endforeach
  </td>
  <td>{{ $reservation->trip->coming_time }}</td>
  
  <td>
    @switch($reservation->payment_type)
    @case('total_payment') المبلغ كامل @break
    @case('deposit_payment')بعربون@break
    @case('later_payment')الدفع لاحقا@break
    @default -
    @endswitch
  </td>
  <td>
    @switch($reservation->payment_method)
    @case('bank') الدفع البنكي @break
    @case('telr')بوبة تبلر@break
    @case('inBus')كاش@break
    @endswitch
  </td>

  <td>{{ $reservation->ticket_no }} </td>


<td style="display:inline-block;width:350px;">
<a class="btn btn-sm btn-info" href="{{ route('marketer.reservations.edit',['id' => $reservation->id]) }}">تعديل الحجز</a>
@if($reservation->trip->provider->service_id == 1)
<a class="btn btn-sm btn-warning" href="{{ route('marketer.reservations.passengersList',['id' => $reservation->id]) }}">قائمه المسافرين</a>
@endif
@if($reservation->trip->provider->service_id == 3)
<a class="btn btn-sm btn-warning" href="{{ route('marketer.haj.reservations.passenger.info', ['id' => $reservation->id]) }}">معلومات الحاج\المعتمر</a>
@endif
<!-- <a class="btn btn-sm btn-warning" href="{{ route('provider.reservations.postpone',['id' => $reservation->id]) }}">تأجيل الحجز</a> -->
<a class="btn btn-sm btn-danger" href="{{ route('marketer.reservations.cancel',['id' => $reservation->id]) }}">الغاء الحجز</a>
<a class="btn btn-sm btn-primary" href="{{ route('marketer.reservations.transfer',['id' => $reservation->id]) }}">نقل الحجز</a>

<!-- <a class="btn btn-sm btn-success" href="{{ route('provider.reservations.transfer',['id' => $reservation->id]) }}">نقل الى</a> -->
</td> 
<td style="width:150px;margin-top:30px">
<a class="btn btn-sm btn-primary" href="{{ route('dashboard.marketer.sms',['id' => $reservation->id]) }}" style="margin-bottom: 10px"> <span class="glyphicon glyphicon-envelope"></span>   راسل المسافر   </a>
<a class="btn btn-sm btn-success" @if($reservation->passenger->phone) href="https://api.whatsapp.com/send?phone={{ $reservation->passenger->phone}}" @else href="https://api.whatsapp.com/send?phone={{ $reservation->passenger_phone_yem}}" @endif style="width:100px">واتس اب </a>


</td>
</tr>
{{-- @endif --}}

@endforeach
  </tbody>
    </table>

 
    {{ $reservations->links() }}
    </div>

</div>
  
@endsection


@section('script')

<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>


<script type="text/javascript" src="{{asset('js/jquery-2.1.4.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/js.js')}}"></script>
<script type="text/javascript">




function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        td2= tr[i].getElementsByTagName("td")[1];
     if (td2) {
      txtValue = td2.textContent || td2.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        td9= tr[i].getElementsByTagName("td")[2];
     if (td9) {
      txtValue = td9.textContent || td9.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
       td3= tr[i].getElementsByTagName("td")[3];
     if (td3) {
      txtValue = td3.textContent || td3.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
       td4= tr[i].getElementsByTagName("td")[6];
     if (td4) {
      txtValue = td4.textContent || td4.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
       td5= tr[i].getElementsByTagName("td")[5];
     if (td5) {
      txtValue = td5.textContent || td5.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
       td7= tr[i].getElementsByTagName("td")[4];
     if (td7) {
      txtValue = td7.textContent || td7.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
       td14= tr[i].getElementsByTagName("td")[8];
     if (td14) {
      txtValue = td14.textContent || td14.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } 
      else {
       td17= tr[i].getElementsByTagName("td")[9];
     if (td17) {
      txtValue = td17.textContent || td17.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } 
      else {
       td6= tr[i].getElementsByTagName("td")[7];
     if (td6) {
      txtValue = td6.textContent || td6.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      
      }
    }
    
      }
    }
      }
    }
      }
    }
      }
    }
      }
    }
      }
    }
   
  }
} 
  }
} 
  }
}
  }
}


</script>

<script type="text/javascript">
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>

@endsection