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


</style>
@endsection


@section('content_header')
    @if (Session::has('message'))
        <div class="alert alert-{{ Session::get('type', 'warning') }}">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="d-flex justify-content-between">
        <h1>القرع</h1>
        <a href="{{ route('dashboard.competitions.create') }}" class="btn btn-success">إضافة قرعة</a>
    </div>
@endsection

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
     <nav aria-label="breadcrumb" style="margin-top:-50px;" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">  عرض القرع </li>
  </ol>
</nav>
       <h1 style ="text-align:center">عرض القرع</h1>

@include('flash-message')
<table id="example" class="table table-striped table-bordered" style="width:100%;text-align:center">
        <thead>
            <th>ID</th>
            <th>ميعاد الرحلة (بتوقيت اليمن)</th>
            <th>تنتهي في (بتوقيت اليمن)</th>
            <th>عدد التذاكر المتاحة</th>
            <th>عدد المشاركين</th>
            <th>الراعي</th>
            <th>الحالة</th>
            <th>الإجراءات</th>
        </thead>
        <tbody>
            @foreach ($competitions as $competition)
                <tr>
                    <td>{{ $competition->id }}</td>
                    <td>{{ $competition->trip_at }}</td>
                    <td>{{ $competition->finish_at }}</td>
                    <td>{{ $competition->available_tickets }}</td>
                    <td>{{ count($competition->participants) }}</td>
                    <td>{{ $competition->sponsor }}</td>
                    <td>{{ $competition->status == 'active' ? 'مفعلة' : 'منتهية' }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route('dashboard.competitions.show', $competition) }}">عرض</a>
                        <a class="btn btn-sm btn-warning" href="{{ route('dashboard.competitions.edit', $competition) }}">تعديل</a>
                        <form class="d-inline-block" method="POST" action="{{ route('dashboard.competitions.destroy', $competition) }}" >
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" href="">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection


@section('script')

<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );


</script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>

@endsection