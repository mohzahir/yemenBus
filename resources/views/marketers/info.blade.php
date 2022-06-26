@extends('layouts.dashboard')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
  <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIg793UIO-lGCHUeNURCT8mYFM63o6Czo&callback=initMap&libraries=&v=weekly"
      defer
    ></script>

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
#address_on_map {
            max-width: 400px;
            height: 400px;
        }

</style>
@endsection


@section('content_header')
    <h1>بيانات المسوق</h1>
@stop

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;">
          <nav aria-label="breadcrumb" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.marketer.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page">  بيانات الحساب  </li>
  </ol>
</nav>
<h1 style="text-align:center">بيانات الحساب  </h1>


    <div class="pb-4">
        <div class="form-group">
            <label for="name">الاسم</label>
            <input type="text" class="form-control-plaintext" readonly id="name" value="{{ \Auth::guard('marketer')->user()->name }}">
        </div>
        <div class="form-group">
            <label for="id">الرقم الخاص للمسوق بالنظام</label>
            <input type="text" class="form-control-plaintext" readonly id="id" value="{{ \Auth::guard('marketer')->user()->code }}">
        </div>
        <div class="form-group">
            <label for="id">رقم الجوال المعتمد</label>
            <input type="text" class="form-control-plaintext" readonly id="id" @if(\Auth::guard('marketer')->user()->phone) value="{{ \Auth::guard('marketer')->user()->phone}}" @else value="{{ \Auth::guard('marketer')->user()->y_phone}}" @endif>
        </div>
        <div class="form-group">
            <label for="id">الرصيد (ريال سعودي)</label>
            <input type="text" class="form-control-plaintext" readonly id="id" value="{{ \Auth::guard('marketer')->user()->max_rs}}">
        </div>
        <div class="form-group">
            <label for="id">الرصيد (ريال يمني)</label>
            <input type="text" class="form-control-plaintext" readonly id="id" value="{{ \Auth::guard('marketer')->user()->max_ry}}">
        </div>  
       {{-- <h4>موقع المسوق</h4>
        <div class="form-group">
        <label for="city">الدولة</label>
            @if($address!=null)<input type="text" class="form-control-plaintext" readonly id="city" value="{{$address->countery}}">@endif
        </div>

        <div class="form-group">
            <label for="district">المدينة</label>
            @if($address!=null)<input type="text" class="form-control-plaintext" readonly id="district" value="{{$address->city}}">@endif
        </div>
        <div class="form-group">
            <label for="street">الحي</label>
            @if($address!=null)<input type="text" class="form-control-plaintext" readonly id="street" value="{{$address->neigh}}">@endif
        </div>
        <div class="form-group">
            <label for="city">الشارع</label>
            @if($address!=null)<input type="text" class="form-control-plaintext" readonly id="city" value="{{$address->street}}">@endif
        </div>
        <div class="form-group">
            <label for="address_on_map">الموقع على الخريطة</label>
            <div id="address_on_map"></div>
        </div>
        --}}
    </div>
    </div>
@endsection

@section('script')
<script>
// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
function initMap() {
  const map = new google.maps.Map(document.getElementById("address_on_map"), {
    center: { lat: -33.8688, lng: 151.2195 },
    zoom: 13,
  });
  const card = document.getElementById("pac-card");
  const input = document.getElementById("pac-input");
  map.controls[google.maps.ControlPosition.TOP].push(card);
  const autocomplete = new google.maps.places.Autocomplete(input);
  // Bind the map's bounds (viewport) property to the autocomplete object,
  // so that the autocomplete requests use the current map bounds for the
  // bounds option in the request.
  autocomplete.bindTo("bounds", map);
  // Set the data fields to return when the user selects a place.
  autocomplete.setFields(["address_components", "geometry", "icon", "name"]);
  const infowindow = new google.maps.InfoWindow();
  const infowindowContent = document.getElementById("infowindow-content");
  infowindow.setContent(infowindowContent);
  const marker = new google.maps.Marker({
    map,
    anchorPoint: new google.maps.Point(0, -29),
  });
  autocomplete.addListener("place_changed", () => {
    infowindow.close();
    marker.setVisible(false);
    const place = autocomplete.getPlace();

    if (!place.geometry) {
      // User entered the name of a Place that was not suggested and
      // pressed the Enter key, or the Place Details request failed.
      window.alert("No details available for input: '" + place.name + "'");
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17); // Why 17? Because it looks good.
    }
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);
    let address = "";

    if (place.address_components) {
      address = [
        (place.address_components[0] &&
          place.address_components[0].short_name) ||
          "",
        (place.address_components[1] &&
          place.address_components[1].short_name) ||
          "",
        (place.address_components[2] &&
          place.address_components[2].short_name) ||
          "",
      ].join(" ");
    }
    infowindowContent.children["place-icon"].src = place.icon;
    infowindowContent.children["place-name"].textContent = place.name;
    infowindowContent.children["place-address"].textContent = address;
    infowindow.open(map, marker);
  });
}
</script>

@endsection