@extends('layouts.admin')
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
    font-family: 'Cairo', sans-serif;

}
.form-control:focus {
  box-shadow: none;
}

.form-control {
style="border-width: 0;border-bottom-width: 1px; border-radius: 0;padding-left: 0;"
}.form-control::placeholder {
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
        <h1>المسوقين</h1>        
    </div>
@endsection

@section('content')

<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- " >

 <nav aria-label="breadcrumb"  >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">  المسوقين</li>
  </ol>
</nav>
<div>
   <h1  style="display: inline-block">المسوقين</h1>
<a href="{{route('dashboard.marketers.create')}}" class="btn btn-success btn-lg"  style="float:left">اضافة مسوق</a>
 </div>
     @include('flash-message')

    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="بحث عن  المسوق " style="background-image: url('{{ asset('img/search.png')}}');">
  <div class="table-responsive">

<table id="myTable" class="table table-striped table-bordered"text-align:center">
        <thead >
            <th>كود المسوق</th>
            <th style="text-align:center;vertical-align:center">اسم المسوق</th>
            <th>رقم الجوال</th>
            <th>الحالة</th>
            <th>المزود</th>
            <th>الحد الاعلى رصيد(ريال السعودي)</th>
            <th>الحد الاعلى رصيد(ريال اليمني)</th>
           
            <th> الاجراءات </th>
            <th> التواصل </th>
           
        </thead>
        <tbody>
            @foreach ($marketers as $marketer)
                <tr>                   
                     <td>{{ $marketer->code }}</td>
                    <td>{{ $marketer->name }}</td>
                    <td>@if($marketer->phone!=null){{ $marketer->phone }}@else{{ $marketer->y_phone }}@endif</td>
                    <td>@if($marketer->state == 'active') مفعل @elseif($marketer->state == 'not_active') غير مفعل @elseif($marketer->state == 'suspended') موقوف @else  @endif</td>
                    <td>@if($marketer->provide == 'global') عام @else {{$marketer->provide}} @endif</td>
                    <td>{{ $marketer->max_rs }}</td>
                    <td>{{ $marketer->max_ry }}</td>
                 
                    <td style="display:inline-block;width:100%">
                    <a class="btn btn-sm btn-info" href="{{ route('dashboard.marketers.edit', $marketer->id) }}">تعديل</a>
                    <a class="btn btn-sm btn-danger" href="{{ route('dashboard.marketers.destroy', $marketer->id) }}">حذف </a>
                        </form>
                        <a class="btn btn-sm btn-success" href="{{ route('dashboard.marketers.chargeForm', $marketer->id) }}"> شحن المسوق</a>
                        </form>
                    </td>
                    <td style="width:150px;margin-top:30px">
                    <a class="btn btn-sm btn-primary" href="{{ route('dashboard.marketers.sendMsms',$marketer->id) }}" style="margin-bottom: 10px"> <span class="glyphicon glyphicon-envelope"></span>   ارسل رسالة    </a>
      <a class="btn btn-sm btn-success" @if($marketer->phone) href="https://api.whatsapp.com/send?phone={{ $marketer->phone}}" @else href="https://api.whatsapp.com/send?phone={{ $marketer->y_phone}}" @endif  style="width:100px">واتس اب </a>

                    
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $marketers->links() }}
</div>
</div>
@endsection

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('script')

<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );



    function confirmDelete(form) {
        event.preventDefault();
        Swal.fire({
            title: 'هل أنت متأكد من رغبتك في حذف المسوق؟',
            text: "هذا سيحذف الحجوزات ايضا",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم',
            cancelButtonText: 'لا'
            }).then((result) => {
            
            if (result.isConfirmed) {
                form.submit();
            }
        })
    }

    


function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
       td6= tr[i].getElementsByTagName("td")[1];
     if (td6) {
      txtValue = td6.textContent || td6.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
       td7= tr[i].getElementsByTagName("td")[2];
     if (td7) {
      txtValue = td7.textContent || td7.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
      }
    }
  }}}
}



</script>
@endsection