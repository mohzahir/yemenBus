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
</style>
@endsection
@section('content_header')
<h1>إضافة مدينة</h1>
@stop

@section('content')
    <div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- " style="margin-left:70px;">
        <nav aria-label="breadcrumb" style="margin-top:-50px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span
                            class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
                <li class="breadcrumb-item active" aria-current="page"> اضافة مدينة</li>
            </ol>
        </nav>
        <h1 style="text-align:center">اضافة مدينة </h1>
        @include('flash-message')

        <form method="POST" action="{{ route('admin.city.store') }}"
            class="pb-4 @if ($errors->any()) was-validated @endif" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">اسم المدينة</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="country"> الدولة</label>
                <select name="country" class="form-control">
                    <option value=""> -- اختر--</option>
                    <option value="1" {{ old('country') == 1 ? "selected" : "" }}>السعودية </option>
                    <option value="2" {{ old('country') == 2 ? "selected" : "" }}>اليمن </option>

                </select>
                @error('country')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>


            <button type="submit" class="btn btn-success btn-lg">انشاء مدينة</button>

        </form>
    </div>
    @endsection
    @section('script')

    @endsection