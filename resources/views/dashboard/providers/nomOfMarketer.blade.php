@extends('layouts.admin')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
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
#myInput {
  background-image:  url("{{asset('/img/search.png')}}");

  background-position: 10px 12px; /* Position the search icon */
  background-repeat: no-repeat; /* Do not repeat the icon image */
  width: 100%; /* Full-width */
  height: 40px; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 1px solid #ddd; /* Add a grey border */
  margin-bottom: 12px; /* Add some space below the input */
}




</style>
@endsection

@section('content_header')
    <h1>إعدادات المسوق</h1>
@stop

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
      <nav aria-label="breadcrumb" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">  ترشيح المسوقين </li>
  </ol>
</nav>
        <h2 style ="text-align:center"> ترشيح المسوقين </h2>
          <input type="text" id="myInput" onkeyup="myFunction()" placeholder="البحث باسم لشركة او اسم الوكيل او رقم جوال " style="background-image: url('{{ asset('img/search.png')}}');">

   <div class="table-responsive">
<table id="myTable" class="table table-striped table-bordered" style="width:100%;text-align:center;margin-top:20px;margin-bottom:50px;text-align:center">
        <thead>
        <th style="text-align:center;vertical-align:center"> الشركة </th>
        <th style="text-align:center;vertical-align:center"> اسم الوكيل</th>
            <th style="text-align:center;vertical-align:center">صلاحية المالية للوكيل </th>
            <th style="text-align:center;vertical-align:center">العملة</th>
            <th style="text-align:center;vertical-align:center">رقم جوال يمني</th>
            <th style="text-align:center;vertical-align:center">رقم جوال سعودي</th>
            
        </thead>
        <tbody>
            @foreach ($noms as $nom)
           
 <?php $provider=App\Provider::where('id',$nom->provider_id)->first(); ?> 
                @if($provider)
                <tr>       
               
                <td>{{ $provider->name_company }}</td>
                <td>{{ $nom->name_agent }}</td>
                    <td>{{ $nom->agent_value }}</td>
                    <td> @if($nom->agent_currency=='yer') ريال يمني @else ريال سعودي @endif </td>
                    <td> @if($nom->phone!=null){{ $nom->phone }}@else @endif</td>
                    <td>@if($nom->y_phone!=null){{ $nom->y_phone }}@else @endif</td>

                    
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    {{ $noms->links() }}

</div>

    </div>
@stop
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
        td1= tr[i].getElementsByTagName("td")[1];
     if (td1) {
      txtValue = td1.textContent || td1.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      }else {
        td5= tr[i].getElementsByTagName("td")[5];
     if (td5) {
      txtValue = td5.textContent || td5.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        td3= tr[i].getElementsByTagName("td")[4];
     if (td3) {
      txtValue = td3.textContent || td3.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
      }
    }}}
     
      
}}
      
    

  

  }}

</script>
@endsection