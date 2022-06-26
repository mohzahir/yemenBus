<div>
    <table class="table mt-3 trip-dep">
      <tr>
        <th>{{__('للحجز')}}</th>
        <th>{{__('السعر')}}</th>
        <th>{{__('الشركة')}}</th>
        <th>{{__('ساعة المغادرة')}}</th>

        <th>{{__('تاريخ المغادرة')}}</th>
  
      </tr>
      @foreach($trips as $key => $trip)
      <tr>
        <td><a href="{{ route('passengers.reserveTrips',[$trip->id, $ticketNo])}}" class="btn btn-info trip-btn">احجز</a></td>
        <td>{{(integer)$trip->price}} {{App\Trip::getCurrency($trip->from)}}</td>
        <td>{{$trip->provider}}</td>
        <td>{{$trip->leave_time}}</td>

        <td>{{$trip->from_date}}</td>
  
      </tr>
      @endforeach
  
    </table>
    {{$trips->links()}}

  </div>