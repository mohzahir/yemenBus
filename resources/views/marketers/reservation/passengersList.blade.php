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
    <li class="breadcrumb-item active" aria-current="page">   قائمه المسافرين في الحجز {{$passengers[0]->reservation_id}} </li>
  </ol>
</nav>
        <h1 style ="text-align:center">قائمه المسافرين في الحجز {{$passengers[0]->reservation_id}}</h1>

@include('flash-message')


<div class="d-flex justify-content-between" style="dispaly:inline;margin-bottom:50px;">
        
        
    </div>
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="البحث عن مسافر  " style="background-image: url('{{ asset('img/search.png')}}');">
<div class="table-responsive">
  
<table id="myTable" class="table table-striped table-bordered" style="width:100%;text-align:center">
        <thead >
          <tr> 
          
            <th rowspan="2">رقم الحجز</th>
            <th rowspan="2">اسم المسافر </th>
            <th rowspan="2">جوال </th>
            <th rowspan="2">الرقم الوطني</th>
            <th rowspan="2">تاريخ الميلاد</th>
            <th rowspan="2">الفئه العمريه</th>
            <th rowspan="2">النوع</th>
            <th rowspan="2">رقم التزكره</th>
            

        </tr>
        </thead>
        <tbody>
    
       
        
        
        
          <form id="ticketsForm" action="{{route('marketer.reservations.savePassengersTickets')}}" method="POST">
          @foreach ($passengers as $passenger)
  

 <tr>                   
    <td> {{ $passenger->reservation_id}}</td>
    <td> {{ $passenger->name}}</td>
    <td> {{ $passenger->phone}}</td>
    <td> {{ $passenger->p_id}}</td>
    <td> {{ $passenger->dateofbirth}}</td>
    <td> {{ $passenger->age}}</td>
    <td> {{ $passenger->gender}}</td>
    <td> 
        @csrf
        <input type="text" name="external_ticket_no[]" class="form-control" value="{{$passenger->external_ticket_no}}">
        <input type="hidden" name="id[]" value="{{$passenger->id}}">
      </td>
    </tr>
    
    @endforeach
  </form>
        </tbody>
    </table>
    <div class="text-center">

      <button class="btn btn-success btn-sm" onclick="$('#ticketsForm').submit()">حفظ ارقام التزاكر</button>
      <a class="btn btn-danger btn-sm" href="{{ route('marketer.reservations.confirmAll') }}">رجوع</a>
      
    </div>

    
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
