<div>
  <table class="table mt-3 trip-dep">
    <tr>
      <th>{{__('للحجز')}}</th>
      <th>{{__('النوع')}}</th>
      <th>{{__('السعر')}}</th>
      <th>{{__('صعود')}}</th>
      <th>{{__('نزول')}}</th>


      <th>{{__('الشركة الناقلة')}}</th>
      <th>{{__('المغادرة')}}</th>
      <th>{{__('الايام')}}</th>

    </tr>
    @foreach($trips as $key => $trip) 
    <tr>
      
    {{-- {{$trips}} --}}
      <td><a href="{{ route('passengers.reserveTrips',[$trip->id])}}" class="btn btn-info trip-btn">احجز</a></td>
      <td>
      @if ($trip->trip_type == 'car')
      سيارة خاصة        
      @else
      شركة نقل
      @endif
      
      </td>
      <td>{{(integer)$trip->price}} {{$currency}}</td>
      <td>
        <div class="city-arrow"> <i class="fas fa-arrow-up fa-xs"></i> {{$trip->depCity}}</div>
        
        </td> 
        <td><div class="city-arrow"> <i class="fas fa-arrow-down fa-xs"></i> {{$trip->comCity}} </div></td>
      <td>{{$trip->provider}}</td>

      <td>{{$trip->leave_time}}</td>

      <td><?php $days = json_decode($trip->day, true); ?>
        @foreach($days as $day)
        @switch($day)
        @case('all')يوميا @break
        @case('sat')السبت @break
        @case('all') كل الايام@break
        @case('sun') الاحد@break
        @case('mon') الاثنين @break
        @case('tue') الثلاثاء @break
        @case('wed') الاربعاء @break
        @case('thu') الخميس @break
        @case('fri') الجمعة @break
        @default
        @endswitch
        @endforeach</td>



    </tr>
    @endforeach

  </table>
</div>