@extends('layouts.providerDashboard')
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
    <li class="breadcrumb-item"><a href="{{route('dashboard.provider.showAccountInfo')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">  ترشيح المسوقين </li>
  </ol>
</nav>
        <h2 style ="text-align:center"> ترشيح المسوقين </h2>
        @include('flash-message')

          <input type="text" id="myInput" onkeyup="myFunction()" placeholder="البحث بكود الوكيل او الاسم او رقم جوال " style="background-image: url('{{ asset('img/search.png')}}');">

   <div class="table-responsive">
<table id="myTable" class="table table-striped table-bordered" style="width:100%;text-align:center;margin-top:20px;margin-bottom:50px;text-align:center">
        <thead>
            <th style="text-align:center;vertical-align:center"> اسم الوكيل</th>
            <th style="text-align:center;vertical-align:center">صلاحية المالية للوكيل </th>
            <th style="text-align:center;vertical-align:center">العملة</th>
            <th style="text-align:center;vertical-align:center">رقم جوال سعودي</th>
            <th style="text-align:center;vertical-align:center">رقم جوال يمني</th>
            <th style="width:100px;text-align:center;vertical-align:center
">الاجراءات</th>
        </thead>
        <tbody>
            @foreach ($noms as $nom)
                <tr>                   
                    <td>{{ $nom->name }}</td>
                    <td>{{ $nom->currency=='ry' ? $nom->balance_ry : $nom->balance_rs }}</td>
                    <td> @if($nom->currency=='ry') ريال يمني @else ريال سعودي @endif </td>
                    <td> @if($nom->phone!=null){{ $nom->phone }}@else @endif</td>
                    <td>@if($nom->y_phone!=null){{ $nom->y_phone }}@else @endif</td>

                    <td>
                    <form class="d-inline-block" method="POST" action="{{ route('provider.nom.delete', $nom->id) }}" >
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $noms->links() }}

</div>
<span style="width:100%;color:red;font-size:18px;">ملاحظة</span>
<span style="width:100%;color:black;font-size:14px;">  رقم  الجوال بلارقام التالية :1234567890  </span>
<br>
<br>
    <form class="pb-4 @if ($errors->any()) was-validated @endif"  action="{{route('provider.nom.store')}}" method="POST" style="margin-bottom:40px;">
        @csrf
        <div class="form-group">
            <label>اضافه مسوقين     </label>
            <div class="agents-wrapper">
                <div class="agent mb-2 row" style="display: flex;flex-flow: row wrap;align-items: center; margin-bottom:5px;">
                   
                <input type="text" class="form-control col-4" name="name" placeholder="اسم المسوق"  style="width:200px;height:40px;">
                <input type="number" class="form-control col-4" name="balance" placeholder="الصلاحية المالية"  style="width:200px;height:40px;">
                <select class="form-control col-4" name="currency"  style="width:200px;height:40px;">
                  <option value="rs" selected>ريال سعودي</option>
                  <option value="ry">ريال يمني</option>
                </select>
                <input type="text" class="form-control col-4" name="phone" id="phone" placeholder=" رقم جوال سعودي"  style="width:200px;height:40px;">
                <input type="text" class="form-control col-4" name="y_phone" id="y_phone" placeholder="رقم الجوال اليمني"  style="width:200px;height:40px;">
                <input type="email" class="form-control col-4" name="email" placeholder="الايميل"  style="width:200px;height:40px;">
                <input type="password" class="form-control col-4" name="password" placeholder="كلمه السر"  style="width:200px;height:40px;">

                </div>
            </div>
   
        </div>

        <button type="submit" class="btn btn-success btn-lg">اضافة</button>
          <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a><a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.provider.showAccountInfo') }}">اغلاق</a>   
    </form>

    </div>
@stop
@section('script')
<script type="text/javascript">
$('#phone').click(function () {
    document.getElementById('phone').type = 'number';
});
$('#y_phone').click(function () {
    document.getElementById('y_phone').type = 'number';
});
</script>
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
        td2= tr[i].getElementsByTagName("td")[3];
     if (td2) {
      txtValue = td2.textContent || td2.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        td4= tr[i].getElementsByTagName("td")[4];
     if (td4) {
      txtValue = td4.textContent || td2.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      }  
      else {
        tr[i].style.display = "none";
      }
    }
      }
    }}}
     
      
    
      
    

  
  }}


</script>
@endsection