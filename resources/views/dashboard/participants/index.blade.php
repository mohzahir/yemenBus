@extends('layouts.admin')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
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
        <h1>المشاركين</h1>
    </div>
@endsection

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
     <nav aria-label="breadcrumb" style="margin-top:-50px;" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">المشاركين </li>
  </ol>
</nav>
<h1 style="text-align:center">المشاركين</h1>
@include('flash-message')
  <div class="table-responsive">

<table id="example" class="table table-striped table-bordered" style="width:100%;text-align:center">
        <thead>
            <th>ID</th>
            <th>رقم الجوال</th>
            <th>نقطة الانطلاق</th>
            <th>نقطة النهاية</th>
            <th>الإجراءات</th>
        </thead>
        <tbody>
            @if($participants )
            @foreach ($participants as $participant)
                <tr>
                    <td>{{ $participant->id }}</td>
                    <td>{{ $participant->phone }}</td>
                    <td>{{ $participant->competition->starting_place }}</td>
                    <td>{{ $participant->competition->finishing_place }}</td>
                    <td>
                        <form class="d-inline-block" method="POST" action="{{ route('dashboard.participants.destroy', $participant) }}" >
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" href="">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
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

    /*function confirmDelete(form) {
        event.preventDefault();
        Swal.fire({
            title: 'هل أنت متأكد من رغبتك في حذف هذا المشارك؟',
            text: "",
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
    }*/
</script>
@endsection