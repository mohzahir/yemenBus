
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

}.form-control:focus {
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
  
    </div>
@endsection

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;margin-top:20px;">
 <nav aria-label="breadcrumb" style="margin-top:-50px;" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page"> الصلاحية المالية للمسوقين </li>
  </ol>
</nav>
          <h1 style ="text-align:center">طلبات الصلاحية المالية للمسوقين</h1>        
 <input type="text" id="myInput" onkeyup="myFunction()" placeholder="" style="background-image: url('{{ asset('img/search.png')}}');">
   <div class="table-responsive">

<table id="myTable" class="table table-striped table-bordered" style="width:100%;text-align:center">
        <thead >
        <th>ID</th>
        <th> اسم الشركه </th>
            <th style="text-align:center;vertical-align:center">كود الوكيل</th>
            <th>صلاحية المالية للوكيل </th>
            <th>العملة</th>
            <th> اجراءات التواصل</th>
            <th> اجراءات </th>
        </thead>
        <tbody>
            @foreach ($pfas as $pfa)
            <?php  $marketer=App\Marketer::where('code',$pfa->code)->first();
                 
                   ?>
                   @if($marketer)
                <tr>   
                 <?php $provider=App\Provider::where('id', $pfa->provider_id)->first();
                    
                     ?>
                     @if($provider)
                     <td>{{ $pfa->id }}</td>
                     
                    
  

                     <td>{{ $provider->name_company }}</td>
                    <td>{{ $pfa->code }}</td>
                    <td>{{ $pfa->agent_value }}</td>
                    <td> @if($pfa->agent_currency=='yer') ريال يمني @else ريال سعودي @endif </td>

                    <td style="width:150px;margin-top:30px">
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.marketer.sms',$pfa->id)}}" style="margin-bottom: 10px"> <span class="glyphicon glyphicon-envelope"></span>  راسل المسوق  </a>
                    <a class="btn btn-sm btn-success" @if($marketer->phone) href="https://api.whatsapp.com/send?phone={{$marketer->phone}}"@elsehref="https://api.whatsapp.com/send?phone={{$marketer->y_phone}}"@endif style="width:100px">واتس اب </a>
                   
                    
                    </td>
                  <td> <a class="btn btn-danger" href="{{route('dashboard.providers.pfar.delete',$pfa->id)}}">حذف  الصلاحية  المالية
 </a></td>
                </tr>
                @endif
                @endif
            @endforeach
           
   
        </tbody>
    </table>
    {{ $pfas->links() }}
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
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        td2= tr[i].getElementsByTagName("td")[2];
     if (td2) {
      txtValue = td2.textContent || td2.innerText;
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
    }}}}}
     
      
    
      
    

  



</script>
@endsection