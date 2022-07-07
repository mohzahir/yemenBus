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
</style>

<script src="//unpkg.com/alpinejs" defer></script>

@endsection
@section('content_header')
    <h1>إضافة مسوق</h1>
@stop

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
    <div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
     <nav aria-label="breadcrumb" style="margin-top:-50px;" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page"> اضافة مسوق</li>
  </ol>
</nav>
   <h1 style ="text-align:center">اضافة مسوق  </h1>
@include('flash-message')
    <form x-data="{active: null}" method="POST" action="{{ route('dashboard.marketers.store') }}"  class="pb-4 @if ($errors->any()) was-validated @endif" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">اسم المسوق</label>
            <input type="text" class="form-control" id="name" name="name"  value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name">نوع المسوق</label> <br>
            <input @click="active = null" type="radio" name="marketer_type"  value="global_marketer" required> مسوق عام <br>
            <input @click="active = 'provider'" type="radio" name="marketer_type"  value="provider_marketer" required> مسوق مخصص لمزود <br>
            <input @click="active = 'service'" type="radio" name="marketer_type"  value="service_marketer" required> مسوق مخصص لقسم <br>
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <template x-if="active == 'provider'">
            <div class="form-group" x-transition>
                <label for="name">اختر المزود</label>
                <!-- <input type="text" class="form-control" id="provider_id" name="provider_id"  value="{{ old('provider_id') }}" > -->
                <select class="form-control" name="provider_id" id="">
                    <option value=""> ---- </option>
                    @foreach($providers as $provider)
                        <option @if(old('provider_id') == $provider->id ) selected @endif value="{{ $provider->id }}">{{ $provider->name_company }}</option>
                    @endforeach
                </select>
                @error('provider_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </template>
        <template x-if="active == 'service'">
            <div class="form-group" x-transition>
                <label for="name">اختر الخدمة</label>
                <!-- <input type="text" class="form-control" id="service_id" name="service_id"  value="{{ old('service_id') }}" > -->
                <select class="form-control" name="service_id" id="">
                    <option value=""> ---- </option>
                    @foreach($services as $service)
                        <option @if(old('service_id') == $service->id ) selected @endif value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                @error('service_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </template>
        <div class="form-group" id="discount_percentage-warapper">
            <label for="phone">رقم الجوال  السعودي</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}"  placeholder="مثال 966512345678" >
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group" id="discount_percentage-warapper">
            <label for="phone">رقم الجوال  اليمني</label>
            <input type="text" name="y_phone" id="y_phone" value="{{ old('y_phone') }}" placeholder="ادخل رقم الجوال اليمني  :967712345678" class="form-control" >
                    @error('y_phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
        </div>
        
        
        <div class="form-group">
            <label for="password">كلمة السر</label>
            <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}"  required>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
       
        <button type="submit" class="btn btn-success btn-lg">انشاء مسوق</button>
    </form>
    </div>
@endsection
@section('script')
   
<script type="text/javascript">
$('#phone').click(function () {
    document.getElementById('phone').type = 'number';
});
$('#y_phone').click(function () {
    document.getElementById('y_phone').type = 'number';
});
</script>
@endsection