@extends('layouts.providerDashboard')
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
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjIUZf1lkiY2zMcGi3RwHuMVKB_LqxnEQ&libraries=places&callback=initialize&language=ar" async defer></script>
    
    <script src="{{asset('/js/mapInput.js')}}"></script>

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




@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
      <nav aria-label="breadcrumb" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.provider.showAccountInfo')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">اضافة صعود على الخريطة  </li>
  </ol>
</nav>
        <h1 style ="text-align:center"> اضافة صعود على الخريطه</h1>
         @include('flash-message')
      
<div class="table-responsive">
<table id="example" class="table table-striped table-bordered" style="width:100%;text-align:center;margin-top:20px;margin-bottom:50px;">
        <thead >
            <th>ID</th>
            <th style="text-align:center;vertical-align:center">الدولة</th>
            <th>المدينة </th>
            <th>رابط الصعود على الخريطة</th>
            <th style="width:100px;">الاجراءات</th>
        </thead>
        <tbody>
            @foreach ($rOms as $rOm)
                <tr>                   
                     <td>{{ $rOm->id }}</td>
                    <td>{{ $rOm->countery }}</td>
                    <td>{{ $rOm->city }}</td>
                     <td><a href="{{ $rOm->link }}"> {{ $rOm->link }}</a></td>
                    
                    <td>
                    <form class="d-inline-block" method="POST" action="{{ route('dashboard.raiseOnMap.destroy', $rOm->id) }}" >
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" href="">حذف</button>
                        </form>
                        
              <a class="btn btn-sm btn-info" href="{{route('dashboard.raiseOnMap.formShared',$rOm->id)}}">مشاركة الموقع </button>

                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $rOms->links() }}
</div>

<form class="pb-4 @if ($errors->any()) was-validated @endif"  action="{{route('dashboard.raiseOnMap.store')}}" method="POST">
        @csrf
  
<div class="mb-2">
                <label>الدولة :</label>  <input type="text" id="starting_point_url" name="countery" placeholder="الدولة" class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md">
                    @error('countery')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-2">
                <label>اسم المدينة :</label> <input type="text" id="starting_point_url" name="city" placeholder="المدينة"  class="border w-full p-2 border-gray-400 focus:border-gray-500 rounded-md">
                    @error('city')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
               

        <div class="form-group">
            <label for="starting_point_url">رابط الصعود على الخريطة</label>
            <input type="url" class="form-control" id="starting_point_url" name="link" required>
            @error('link')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
              {{-- <div class="form-group" style="margin-top:20px;" id="map_canvas2">
    <label for="address_address">موقع مكان الصعود على الخريطة</label>
    <input type="text" id="address-input" name="address_address" class="form-control map-input">
    <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
    <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
</div>
<div id="address-map-container" style="width:100%;height:400px;margin-bottom: 50px ">
    <div style="width: 100%; height: 100%" id="address-map"></div>
</div> --}}

        <button class="btn mt-10 btn-success" type="submit" style="margin-bottom: 20px">اضف</button>
          <a class="btn btn-warning btn-close" href="">الغاء</a><a class="btn btn-danger btn-close" href="{{ route('dashboard.provider.showAccountInfo') }}">اغلاق</a>   
    </form>
    
</div>
@stop
