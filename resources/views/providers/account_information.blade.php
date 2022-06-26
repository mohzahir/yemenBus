@extends('layouts.providerDashboard')

@section('style')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjIUZf1lkiY2zMcGi3RwHuMVKB_LqxnEQ&libraries=places&callback=initialize&language=ar" async defer></script>
    
    <script src="{{asset('/js/mapInput.js')}}"></script>

    <style>
        #address_on_map_sa, #address_on_map_ye, #starting_point {
            max-width: 400px;
            height: 400px;
        }
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
    margin-bottom:10px;
 
}
    </style>
@stop

@section('content_header')
@stop
 
@section('content')

  
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:70px;margin-top:30px">
       <h1 style="text-align:center"> مرحبا بك  {{Auth::guard('provider')->user()->name_company}} في   لوحه   التحكم   الخاصة   بك </لشخصية  </h1>
        
        <div class="form-group" id="discount_percentage-warapper">
            <label for="phone">جوال الحجز المعتمد</label>
          @if($provider->phone)  <p>{{$provider->phone}}</p> @else <p>{{$provider->y_phone}}</p> @endif
            <p>{{$provider->city}}</p>

        </div>
     


        @if($address!=null)
        
        <h3> موقع المزود </h3>

        <div class="form-group">
            <label for="delegate_name">الدولة</label>
            <p>{{$address->countery}}</p>
        </div>
        <div class="form-group">
            <label for="delegate_name"> المدينه</label>
            <p>{{$address->city}}</p>
        </div>
        <div class="form-group">
    <label for="address_address">Address</label>
    <input type="text" id="address-input" name="address_address" class="form-control map-input" value="{{$address->address_address}}">
    <input type="hidden" name="address_latitude" id="address-latitude" value="{{$address->latitude}}" />
    <input type="hidden" name="address_longitude" id="address-longitude" value="{{$address->address_longitude}}" />
</div>
<div id="address-map-container" style="width:100%;height:400px; ">
    <div style="width: 100%; height: 100%" id="address-map"></div>
</div>

               
              @endif
              
  @if($bank!=null)

        <div class="form-group">
            <label for="bank_account_number_sa">رقم الحساب البنكي </label>
            <p>{{$bank->bank_account_number}}</p>

        </div>
        <div class="form-group">
            <label for="iban_number_sa">رقم الايبان (إن وجد) </label>
            <p>{{$bank->IBAN}}</p>

        </div>
        <div class="form-group">
            <label for="bank_name_sa">اسم البنك </label>
            <p>{{$bank->bank_name}}</p>

        </div>
        <div class="form-group">
            <label for="bank_soft_code_sa">السوفت كود للبنك (السعودية)</label>
            <p>{{$bank->bank_softcode}}</p>

        </div>
    </div>
@endif

@stop
@section('script')
    @parent
@stop
