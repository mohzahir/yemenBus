@props(['trips'])
<div>
  <table class="table mt-3 trip-dep">
    <tr>
      <th>{{__('للحجز')}}</th>
      <th>{{__('السعر')}}</th>
      <th>{{__('الشركة الناقلة')}}</th>
      <th>{{__('مدينة الصعود')}}</th>
      <th>{{__(' مدينة النزول')}}</th>
      <th>{{__('اليوم')}}</th>
      <th>{{__('المغادرة')}}</th>
      <th>{{__('الوصول')}}</th>

    </tr>
    @foreach($trips as $key => $tripYemen)
    <tr>
      <td><button class="btn btn-info trip-btn">احجز</button></td>
      <td>{{$tripYemen->price}} ريال سعودي</td>
      <td>{{$tripYemen->provider}}</td>
      <td>{{$tripYemen->depCity}}</td>
      <td>{{$tripYemen->comCity}}</td>
      <td>{{$tripYemen->day}}</td>
      <td>{{$tripYemen->leave_time}}</td>
      <td>{{$tripYemen->coming_time}}</td>


    </tr>
    @endforeach

  </table>
</div>