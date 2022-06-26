@extends('layouts.passenger')
@section('content')
@section('css')

<script src="{{asset('js/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="{{asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.css')}}">
@endsection

@include('incs.headerFormTrip')

<div class="whole-wrap">
  <div class="container box_1170">
    @php $yCurrency= 'ريال يمني'; @endphp 
    <div class="section-top-border">
    <h1 style="text-align: center">جميع الرحلات بشركة نقل  </h1>

      <h3 class="mb-30">جميع الرحلات (من السعودية إلى اليمن)</h3>
      <div class="progress-table-wrap">
        {{-- {{dd($tripsToYemen)}} --}}
              @include('incs.trips', ['trips' =>$tripsToYemen ,'currency' => 'ر.س'])
        
      </div>
    </div>

    <div class="section-top-border">
      <h3 class="mb-30">جميع الرحلات (من اليمن إلى السعودية)</h3>
      <div class="progress-table-wrap">
        {{-- {{dd($tripsToSa)}} --}}
          
              @include('incs.trips', ['trips' =>$tripsToSa ,'currency' =>$yCurrency ])
      </div>
    </div>

    <div class="section-top-border">
      <h3 class="mb-30">جميع الرحلات (بين المدن اليمنية )</h3>
      <div class="progress-table-wrap">
              @include('incs.trips', ['trips' =>$tripsBtYemen , 'currency' => $yCurrency ])
        
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script  src="{{asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>


    <script>
    
jQuery(document).ready(function(){

   /* $('.tripDate').datetimepicker({
        useCurrent: false,
                stepping: 60,
                format: 'mm-dd',
                timeZone: 'Asia/Aden',
            });
   */
    
  });
</script>
@endsection