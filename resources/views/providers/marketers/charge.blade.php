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
<script>
    $(".alert").alert('close')
</script>
@endsection



@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- " style="margin-left:70px;margin-top:100px;">
    <nav aria-label="breadcrumb" style="margin-top:-50px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
            <li class="breadcrumb-item active" aria-current="page"> شحن المسوق </li>
        </ol>
    </nav>
    <h1 style="text-align:center">شحن المسوق</h1>

    @include('flash-message')

    <form enctype="multipart/form-data" action="{{ route('provider.marketers.charge')}}" method="POST" style="margin-bottom:40px;">
        @csrf
        <div class="form-group mt-2">
            <label for="marketer_id">رقم المسوق </label>
            <input type="text" class="form-control" name="marketer_id" @if($marketer)value="{{$marketer->id}}" @endif>
        </div>
        <div class="form-group mt-2">
            <label for="amount">المبلغ</label>
            <input type="number" class="form-control" name="amount" value="{{ old('amount') }}">
        </div>
        <div class="form-group mt-2">
            <label for="currecny">العملة</label>
            <select name="currecny" class="form-control" id="currecny">
                <option @if(old('currecny')=='rs' ) selected @endif value="rs">ريال سعودي</option>
                <option @if(old('currecny')=='ry' ) selected @endif value="yer">ريال يمني</option>
            </select>
        </div>
        <div class="form-group mt-2">
            <label for="notes">ملاحظات</label>
            <textarea class="form-control" name="notes">{{ old('notes') }}</textarea>
        </div>
        <div class="form-group mt-2">
            <label for="transfer_img">صورة الحوالة</label>
            <input type="file" class="form-control" name="transfer_img" value="{{ old('transfer_img') }}">
        </div>
        <button class="btn btn-success btn-lg">شحن الرصيد</button>
        <a class="btn btn-danger btn-close btn-lg" href="{{ route('provider.marketers.index') }}">رجوع</a>


    </form>
</div>
@endsection