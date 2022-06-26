@extends('layouts.admin')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link
    href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap"
    rel="stylesheet">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css"
    integrity="sha512-PMjWzHVtwxdq7m7GIxBot5vdxUY+5aKP9wpKtvnNBZrVv1srI8tU6xvFMzG8crLNcMj/8Xl/WWmo/oAP/40p1g=="
    crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">

<style>
    h1,
    h2,
    h3 {
        font-family: 'Cairo', sans-serif;
    }

    p {
        font-family: 'Cairo', sans-serif;
        font-size: 20px;

    }

    label {
        font-family: 'Cairo', sans-serif;
        font-size: 16px;

    }

    th,
    td {
        text-align: center;
        vertical-align: center;
        horizontal-align: center;
        width: 50;
        height: 80;
        font-family: 'Cairo', sans-serif;

    }

    .form-control:focus {
        box-shadow: none;
    }

    .form-control {
        style="border-width: 0;border-bottom-width: 1px; border-radius: 0;padding-left: 0;"
    }

    <meta name="_token"content="{{ csrf_token() }}"><link rel="stylesheet"href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
 

    #myInput {
        background-image: url("{{asset('/img/search.png')}}");

        background-position: 10px 12px;
        /* Position the search icon */
        background-repeat: no-repeat;
        /* Do not repeat the icon image */
        width: 100%;
        /* Full-width */
        font-size: 16px;
        /* Increase font-size */
        padding: 12px 20px 12px 40px;
        /* Add some padding */
        border: 1px solid #ddd;
        /* Add a grey border */
        margin-bottom: 12px;
        /* Add some space below the input */
    }
    .swal2-html-container{
        font-size: 15px;
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

<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- " style="margin-left:70px;">
    <nav aria-label="breadcrumb" style="margin-top:50px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.provider.showAccountInfo')}}"> <span
                        class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
            <li class="breadcrumb-item active" aria-current="page">>قائمة المدن</li>
        </ol>
    </nav>
    <h1 style="text-align:center">قائمة المدن</h1>
    @include('flash-message')


    <div class="table-responsive" style="margin-top:20px;">
        <table class="table table-striped table-bordered" style="width:100%;text-align:center">
            <thead>
                <th> اسم المدينة </th>
                <th> الدولة </th>
                
                <th style="width:300px;">اجراءات</th>

            </thead>
            <tbody id="">

                @foreach ($cities as $city)

                <tr>
                    <td>{{ $city->name }}</td>
                    <td>@if($city->country == 1 ) السعودية @elseif($city->country == 2) اليمن @endif</td>
                    
                    <td>
                        <a class="btn btn-sm btn-danger city-delete"
                        data-url="{{ route('admin.city.delete',$city->id) }}" href="#">
                            الغاء
                        </a>
                        <a class="btn btn-sm btn-success" href="{{ route('admin.city.edit',$city->id) }}">
                            تعديل</a>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>

        {{ $cities->links() }}
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript" src="{{asset('js/jquery-2.1.4.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/js.js')}}"></script>
<script src="{{asset('js/sweet-alert.js')}}"></script>

<script type="text/javascript">
 const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

    $(document).on('click','.city-delete', function(e){
        e.preventDefault()
        Swal.fire({
            title: 'حذف',
            text: 'هل تريد حذف المدينة؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'حذف',
            cancelButtonText: 'الغاء',    
        }).then((result) => {
            if(result.value){
                $.ajax({
                    type: 'delete',
                    url: $(this).data('url'),
                    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                    data:{},
                    success: function(){
                        Toast.fire({
                        icon: 'success',
                        title: 'تم الحذف بنجاح'
                      })
                    },
                })
                $(this).parent().parent().fadeOut();     
            }
        })

    });
</script>
<script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
@endsection