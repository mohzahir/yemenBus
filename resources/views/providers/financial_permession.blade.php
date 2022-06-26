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
    <li class="breadcrumb-item active" aria-current="page">   صلاحية مالية للمسوقين </li>
  </ol>
</nav>
        <h2 style ="text-align:center"> صلاحية مالية للمسوقين المعتمدين</h2>
                @include('flash-message')

          <input type="text" id="myInput" onkeyup="myFunction()" placeholder="البحث بكود الوكيل او الاسم" style="background-image: url('{{ asset('img/search.png')}}');">

   <div class="table-responsive">
<table id="myTable" class="table table-striped table-bordered" style="width:100%;text-align:center;margin-top:20px;margin-bottom:50px;text-align:center">
        <thead>
            <th  style="text-align:center;vertical-align:center">رقم المسوق</th>
            <th style="text-align:center;vertical-align:center"> المزود</th>
            <th style="text-align:center;vertical-align:center"> اسم المسوق</th>
            <th style="text-align:center;vertical-align:center">المبلغ بالريال اليمني </th>
            <th style="text-align:center;vertical-align:center">المبلغ بالريال السعودي</th>
            {{-- <th style="width:100px;text-align:center;vertical-align:center
">الاجراءات</th> --}}
        </thead>
        <tbody>
            @foreach ($marketers as $marketer)
                <tr>
                                     
                     <td>{{ $marketer->id }}</td>
                    <td>{{ $marketer->provider->name_company }}</td>
                    <td>{{ $marketer->name }}</td>
                    <td>{{ $marketer->balance_ry }}</td>
                    <td>{{ $marketer->balance_rs }}</td>
                    {{-- <td> @if($marketer->agent_currency=='yer') ريال يمني @else ريال سعودي @endif </td> --}}
                    
                    {{-- <td>
                    <form class="d-inline-block" method="POST" action="{{ route('dashboard.financialSetting.destroy', $marketer->id) }}" >
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" href="">حذف</button>
                        </form>
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- {{ $marketers->links() }} --}}

</div>
    <form class="pb-4 @if ($errors->any()) was-validated @endif"  action="{{route('dashboard.financialSetting.store')}}" method="POST" style="margin-bottom:40px;">
        @csrf
        <div class="form-group">
            <label>اضافة  صلاحية الوكلاء المالية</label>
            <div class="agents-wrapper">
                <div class="agent mb-2 row" style="display: flex;flex-flow: row wrap;align-items: center; margin-bottom:5px;">
                    <select class="form-control col-4" name="marketer_id"  style="width:200px;height:40px;" required>
                        @foreach($marketers as $marketer)
                        <option value="{{$marketer->id}}">{{$marketer->name}}</option>
                        @endforeach
                       
                    </select>
                    <input type="number" class="form-control col-4" name="agent_value" placeholder="الصلاحية المالية"  style="width:200px;height:40px;">
                    <select class="form-control col-4" name="agent_currency"  style="width:200px;height:40px;">
                        <option value="rs" selected>ريال سعودي</option>
                        <option value="ry">ريال يمني</option>
                    </select>
                </div>
            </div>
   
        </div>

        <button type="submit" class="btn btn-success btn-lg">حفظ</button>
          <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a><a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.provider.showAccountInfo') }}">اغلاق</a>   
    </form>

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
        tr[i].style.display = "none";
      }
    }
      }
    }}}
     
      
    
      
    

  



</script>
@endsection