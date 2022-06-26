@extends('layouts.admin')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
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
</style>
@endsection

@section('content_header')
    @if (Session::has('message'))
        <div class="alert alert-{{ Session::get('type', 'warning') }}">
            {{ Session::get('message') }}
        </div>
    @endif
   
@endsection

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
          <nav aria-label="breadcrumb" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.marketer.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page"> الحجوزات المؤكده</li>
  </ol>
</nav>
<h1 style="text-align:center">  حجوزات المؤكده</h1>
@include('flash-message')

    <table class="datatable w-100">
        <thead>
            <th>ID</th>
            <th>رقم الجوال</th>
            <th>نقطة الانطلاق</th>
            <th>نقطة النهاية</th>
            <th>الإجراءات</th>
        </thead>
        <tbody>
            @foreach ($participants as $participant)
                <tr>
                    <td>{{ $participant->id }}</td>
                    <td>{{ $participant->phone }}</td>
                    <td>{{ $participant->competition->starting_place }}</td>
                    <td>{{ $participant->competition->finishing_place }}</td>
                    <td>
                        <form class="d-inline-block" method="POST" action="{{ route('dashboard.participants.destroy', $participant) }}" onsubmit="event.preventDefault(); confirmDelete(this)">
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

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('script')
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script>
    $('.datatable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Arabic.json'
        }
    });

    function confirmDelete(form) {
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
    }
</script>
@endsection