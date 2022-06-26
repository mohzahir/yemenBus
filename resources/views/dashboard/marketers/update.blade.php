

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
@endsection
@section('content_header')
<h1> ادارة بيانات  {{$marketer->name}} </h1>
@stop

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
     <nav aria-label="breadcrumb" style="margin-top:-50px;" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل بيانات المسوق</li>
  </ol>
</nav>
   <h1 style ="text-align:center">تعديل بيانات المسوقين</h1>

    <form method="get" action="{{ route('dashboard.marketer.update',$marketer->id) }}"  class="pb-4 @if ($errors->any()) was-validated @endif" enctype="multipart/form-data" style="margin-bottom:40px;">
        @csrf
        <div class="form-group" id="discount_percentage-warapper">
            <label for="phone"> رقم الجوال السعودي</label>
            <input type="text" class="form-control" id="phone" name="phone"    value= "{{$marketer->phone}}">
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="form-group" id="discount_percentage-warapper">
            <label for="phone"> رقم الجوال اليمني</label>
            <input type="text" class="form-control" id="y_phone" name="y_phone"    value= "{{$marketer->y_phone}}">
            @error('y_phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="status">الحالة</label>
            <select name="state" id="status" required class="form-control" value= "{{old('state',$marketer->state)}}">
                <option value="active"  >مفعل</option>
                <option value="not_active" >غير مفعل</option>
                <option value="suspended">موقوف</option>
            </select>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
       
           
                <div class="form-group">

               <label for="">المزودين ( شركة النقل) المفوض بها عليهم</label>
     <select name="provide" class="form-control" id="provider_id">
        <?php $providers= App\Provider::all();?>
                        
             ?>
                    <option value="global"> عام </option>

@foreach($providers as $provider)
       <option value="{{$provider->name_company}}">{{$provider->name_company}}</option>
       @endforeach
                    </select>
</div>

        <h4>الحدود المالية</h4>
        <div class="form-group">
            <label for="max_rs">الحد الاعلى رصيدا (ريال سعودي)</label>
            <input type="number" min="0" id="max_rs" name="max_rs" class="form-control" value= "{{old('max_rs',$marketer->max_rs)}}">
        </div>
        <div class="form-group">
            <label for="max_ry">الحد الاعلى رصيدا (ريال يمني)</label>
            <input type="number" min="0" id="max_ry" name="max_ry" class="form-control" value= "{{old('max_ry',$marketer->max_ry)}}">
        </div>
        <div class="form-group">
            <label for="tip_rs">عمولة التسويق (ريال سعودي / تذكرة)</label>
            <input type="number" min="0" id="tip_rs" name="tip_rs" class="form-control" value= "{{old('tip_rs',$marketer->tip_rs)}}">
        </div>
        <div class="form-group">
            <label for="tip_ry">عمولة التسويق (ريال يمني / تذكرة)</label>
            <input type="number" min="0" id="tip_ry" name="tip_ry" class="form-control" value= "{{old('tip_ry',$marketer->tip_ry)}}">
        </div>


       
        <button type="submit" class="btn btn-success btn-lg">تعديل</button>
             <a class="btn btn-default btn-close btn-lg" href="">الغاء</a>
     <a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.admin.index') }}">اغلاق</a>

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
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
    <script src="{{asset('js/mapInput.js')}}"></script>
@endsection
