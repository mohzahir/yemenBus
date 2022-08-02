<div>
    <!-- <table class="table mt-3 trip-dep">
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

  </table> -->

    <div class="row">
        @if(count($trips) > 0)
        @foreach ($trips as $trip)

        <div class="col-md-4">
            <div id="order-summary" class="box">
                <div class="box-header">
                    <h3 class="mb-0"> <strong>المنظم شركة</strong> {{ $trip->provider->name_company }} </h3>
                </div>
                <!-- <p class="text-muted">هنا يمكنك تتبع مختصر تفاصيل البرنامج</p> -->
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>العنوان</td>
                                <th>{{ $trip->title ?? '-'}}</th>
                            </tr>
                            <tr>
                                <td>الرحلة من</td>
                                <th>{{ $trip->takeoff_city->name }}</th>
                            </tr>
                            <tr>
                                <td>الرحلة الى</td>
                                <th>{{ $trip->arrival_city->name }}</th>
                            </tr>
                            <tr>
                                <td>رقم الرحله</td>
                                <th>{{ $trip->id }}</th>
                            </tr>
                            
                            <tr>
                                <td>التاريخ</td>
                                <th>{{ $trip->from_date }}</th>
                            </tr>
                            <tr>
                                <td>اليوم</td>
                                <th><?php $days = json_decode($trip->day, true); ?>
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
                                    @endforeach</th>
                            </tr>
                            <tr>
                                <td>السعر </td>
                                <th> <span class="text-warning"> {{ $trip->price }} {{ $trip->direcation == 'sty' ? 'ر.س' : 'ر.ي' }}</span></th>
                            </tr>
                            <tr>
                                <td> العربون</td>
                                <th>{{ $trip->deposit_price ? $trip->deposit_price : ($trip->direcation == 'sty' ? $BUS_RS_DEPOSIT_VALUE : $BUS_RY_DEPOSIT_VALUE) }}</th>
                            </tr>
                            <!-- <tr>
                                <td>نوع البرنامج</td>
                                <th>{{ $trip->sub_service_id == '1' ? 'عمرة' : 'حج' }}</th>
                            </tr> -->
                            <!-- <tr>
                            <td>التنظيم</td>
                            <th>{{ $trip->name_company }}</th>
                        </tr> -->
                            <!-- <tr>
                                <td>جهة الصعود</td>
                                <th>{{ $trip->air_river == 'air' ? 'جوا' : 'برا' }}</th>
                            </tr> -->
                            <!-- <tr>
                                <td>مكان التجمع</td>
                                <th>{{ $trip->takeoff_city->name }}</th>
                            </tr> -->
                            <!-- <tr>
                                <td>خط السير</td>
                                <th>{{ $trip->lines_trip }}</th>
                            </tr> -->
                            <tr>
                                <td>وقت الحركة</td>
                                <th>{{ $trip->leave_time }}</th>
                            </tr>
                            <tr>
                                <td>وقت الحضور</td>
                                <th>{{ $trip->coming_time }}</th>
                            </tr>
                            <tr>
                                <td>وزن العفش </td>
                                <th>{{ $trip->weight }}</th>
                            </tr>
                            <!-- <tr>
                                <td>تاريخ العودة</td>
                                <th>{{ $trip->to_date }}</th>
                            </tr> -->
                            <tr>
                                <td>
                                    <a href="{{ route('passengers.busDetails', ['id' => $trip->id]) }}" class="btn btn-outline-secondary">التفاصيل</a>
                                </td>
                                <th>
                                    <a href="{{ route('passengers.hajCheckout', ['id' => $trip->id]) }}" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>حجز</a>
                                </th>
                            </tr>

                        </tbody>
                    </table>

                    {{ $trips->links() }}
                </div>
            </div>


        </div>
        @endforeach
        @else
        <div class="col-md-12">
            <div class="box">
                <p class="text-danger text-center">لايوجد رحلات لهذه الفئة</p>
            </div>
        </div>
        @endif
    </div>
</div>