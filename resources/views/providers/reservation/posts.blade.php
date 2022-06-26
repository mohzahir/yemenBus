@extends('layouts.providerDashboard')
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
.form-control:focus {
  box-shadow: none;
}

.form-control {
style="border-width: 0;border-bottom-width: 1px; border-radius: 0;padding-left: 0;"
}

/*
*
* ==========================================
* FOR DEMO PURPOSE
* ==========================================
*
*/



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
    </div>
@endsection

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- " style="margin-left:200px;">
                        <nav aria-label="breadcrumb" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.provider.showAccountInfo')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">   الحجوزات المؤجلة </li>
  </ol>
</nav>
        <h1 style ="text-align:center">الحجوزات المؤجلة</h1>

@include('flash-message')


<div class="d-flex justify-content-between" style="dispaly:inline;margin-bottom:50px;">
        
        
    </div>
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="البحث عن الحجز  " style="background-image: url('{{ asset('img/search.png')}}');">
<div class="table-responsive">
  
<table id="myTable" class="table table-striped table-bordered" style="width:100%;text-align:center">
        <thead >
          <tr> 
          
           <th colspan="2" style="horizontal-align : middle;text-align:center; width: 50%;">الحجز </th>
            <th rowspan="2">كود المسوق</th>
            <th rowspan="2">جوال المسافر السعودي</th>
            <th rowspan="2">جوال المسافر اليمني</th>
            <th rowspan="2">اسم المسافر </th>
            <th rowspan="2">التاريخ</th>
            <th rowspan="2">اليوم</th>
            <th rowspan="2">من مدينة</th>
            <th rowspan="2">الى مدينة</th>
            <th rowspan="2">مبلغ الحجز الكلي بالطلب</th>
            <th rowspan="2">مبلغ العربون بالطلب</th>
            <th rowspan="2">نوع  التأكيد</th>
            <th rowspan="2">عدد  التذاكر</th>
             <th  rowspan="2">رقم الطلب</th>
            <th  rowspan="2" >رقم العرض الفائز </th>

            <th rowspan="2">رابط  الطلب</th>
            <th rowspan="2">صورة  الطلب</th>
            <!-- <th rowspan="2">اجراءات</th> -->
            <!-- <th rowspan="2">وسائل التواصل</th> -->
          </tr>
           <tr>
             <th scope="col"> رقم الحجز</th>
             <th scope="col">حالة  الحجز</th>

        </tr>
        </thead>
        <tbody>
    
       
        
        
        
        
            @foreach ($reservations as $reservation)
                 

                <tr>                   
                   <td >{{ $reservation->id }}</td>
                   <td>@switch($reservation->status)@case('confirm') مؤكد @break @case('postpone')مؤجل @break @case('cancel') ملغي @break   @case('transfer') تم نقله @break @default @endswitch</td>


                <td>{{ $reservation->code }}</td>
                    <td>{{ $reservation->passenger_phone }}</td>
                    <td>{{ $reservation->passenger_phone_yem }}</td>
                    <td>{{ $reservation->passenger_name }}</td>
                    <td>{{ date('d-m-Y', strtotime($reservation->date) )}}</td>

                    <td> 
@switch($reservation->day)
@case('sat')السبت@break
@case('sun')الاحد@break
@case('mon')الاثنين@break
@case('tue')الثلاثاء@break
@case('wed')الاربعاء@break
@case('thu')الخميس@break
@case('fri')الجمعة@break
@default
@endswitch
</td>
<td>{{App\Trip::getCityName($reservation->from_city) }}</td>
                    <td>{{ App\Trip::getCityName($reservation->to_city) }}</td>
                    <td>{{ $reservation->amount }}@switch($reservation->currency)@case('sar')سعودي@break @case('yer') يمني@break @default @endswitch</td>
                    <td>{{ $reservation->amount_deposit }}@switch($reservation->currency)@case('sar')ريال سعودي@break @case('yer')ريال يمني @break @default @endswitch</td>
                    <td>@switch($reservation->amount_type)@case('full') المبلغ كامل @break @case('deposit')بعربون@break @default @endswitch</td>

                    <td>{{ $reservation->ticket_no }} </td>
                    <td >@if( $reservation->order_id){{ $reservation->order_id }}@else @endif</td>
                    <td>@if($reservation->demand_id !=0){{ $reservation->demand_id}}@else @endif </td>

                    <td>@if( $reservation->order_url){{ $reservation->order_url }}@endif</td>
                    <td>@if( $reservation->image)<a href="{{ route('provider.image.download', $reservation->id) }}">صورة الطلب</a>@endif</td>
                   
                  
                </tr>

            @endforeach
        </tbody>
    </table>
    {{ $reservations->links() }}
</div>
</div>
@endsection

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('script')

<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>


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
