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
 <meta name="_token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.css">

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



/*
.primary-btn {
  background-image: -moz-linear-gradient(0deg, #235ee7 0%, #4ae7fa 100%);
  background-image: -webkit-linear-gradient(0deg, #235ee7 0%, #4ae7fa 100%);
  background-image: -ms-linear-gradient(0deg, #235ee7 0%, #4ae7fa 100%);
}

.primary-btn {
  line-height: 36px;
  padding-left: 30px;
  padding-right: 30px;
  border-radius: 25px;
  border: none;
  color: #fff;
  display: inline-block;
  font-weight: 500;
  position: relative;
  -webkit-transition: all 0.3s ease 0s;
  -moz-transition: all 0.3s ease 0s;
  -o-transition: all 0.3s ease 0s;
  transition: all 0.3s ease 0s;
  cursor: pointer;
  text-transform: uppercase;
  position: relative;
}

.primary-btn {
  color: #fff;
  border: 1px solid #fff;
  -webkit-transition: all 0.3s ease 0s;
  -moz-transition: all 0.3s ease 0s;
  -o-transition: all 0.3s ease 0s;
  transition: all 0.3s ease 0s;
}

.primary-btn:hover {
  background: transparent;
  color: #235ee7;
  border-color: #235ee7;
}
*/
</style>
@endsection


@section('content_header')
    @if (Session::has('message'))
        <div class="alert alert-{{ Session::get('type', 'warning') }}">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="d-flex justify-content-between" style="dispaly:inline;">
        <h1>الحجوزات المؤكده</h1>        
    </div>
@endsection

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- " style="margin-left:200px;">
          <nav aria-label="breadcrumb" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.lab.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">  طلبات الفحص </li>
  </ol>
</nav>
<h1 style="text-align:center"> طلبات الفحص المستفيدين </h1>
@include('flash-message')


<div class="d-flex justify-content-between" style="dispaly:inline;">
        <form class="form-inline">
       <input type="text" id="myInput" onkeyup="myFunction()" placeholder="البحث عن الطلب  " style="background-image: url('{{ asset('img/search.png')}}');">

</form>
        
    </div>
  <div class="table-responsive">
<table id="myTable" class="table table-striped table-bordered" style="width:100%;text-align:center">
        <thead >
          <tr> 
            <th>#</th>
            <th>الاسم الثلاثي</th>
             <th >اللقب</th>
            <th >رقم الجواز</th>
            <th >صورة الجواز</th>
           <th> رقم الجوال  </th>
            <th> طريقة السفر</th>
            <th> سفر مع شركة</th>
            <th> حالة الفحص</th>
            <th >وسائل تواصل </th>
        </tr>
        </thead>
        <tbody>
    
            @foreach ($pcrs as $pcr)
        
                <tr>  
                   <td>{{ $pcr->id }}</td>
                   <td>{{ $pcr->name }}</td>
                   <td>{{ $pcr->surname }}</td>
                   <td>{{ $pcr->passport_no }}</td>
                    <td>
                       <a  data-fancybox="gallery" style=" color: black; text-decoration: none;" class="primary-btn" href="{{asset('public/images/pcrs/'.$pcr->passport_image)}}">عرض الصورة</a>
                       <br><br>
                       
                   </td>
                  
                   <td>@if($pcr->phone){{ $pcr->phone }}@else{{$pcr->y_phone}}@endif</td>
                   <td>@if($pcr->way_of_travel=='out')السفر داخل @else السفرخارج@endif</td>
                   <td>@if($pcr->status=='0'&&date_at==null)لم يتم الفحص @elseif($pcr->status=='0'&& $pcr->date_at !=null)$pcr->dateAdmin() @else  <a  data-fancybox="gallery" style=" color: black; text-decoration: none;" class="primary-btn" href="{{asset('public/images/pcrs/pcrs_checked//'.$pcr->done_img)}}">عرض صورة الفحص</a></td>

                    <td style="width:150px;margin-top:30px">
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.pcrs.sms',$pcr->id) }}" style="margin-bottom: 10px"> <span class="glyphicon glyphicon-envelope"></span>   راسل المسافر   </a>
      <a class="btn btn-sm btn-success" @if($pcr->phone) href="https://api.whatsapp.com/send?phone={{$pcr->phone}}" @else href="https://api.whatsapp.com/send?phone={{$pcr->y_phone}}" @endif  style="width:100px">واتس اب </a>
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.pcrs.share',$pcr->id) }}" style="margin-bottom: 10px"> <span class="glyphicon glyphicon-envelope"></span>   راسل المسافر   </a>

                    
                    </td>
                     <td style="width:150px;margin-top:30px">
                    <a class="btn btn-sm btn-success" href="{{ route('dashboard.lab.dateTime',$pcr->id) }}" style="margin-bottom: 10px"> <span class="glyphicon glyphicon-calendar"></span>   تحديد الموعد   </a>

                    
                    </td>
                 </tr>

                  
                    </tr>

            @endforeach
        </tbody>
    </table>

 
    {{ $pcrs->links() }}
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

$('#name')


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
        tr[i].style.display = "none";
      
      
      
    
   
  }
} 
  }
} 
  }
}
      }
} }
}


</script>

<script type="text/javascript">
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>

@endsection