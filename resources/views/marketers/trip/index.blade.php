@extends('layouts.dashboard')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<meta name="_token"content="{{ csrf_token() }}"><link rel="stylesheet"href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-PMjWzHVtwxdq7m7GIxBot5vdxUY+5aKP9wpKtvnNBZrVv1srI8tU6xvFMzG8crLNcMj/8Xl/WWmo/oAP/40p1g==" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">

<style>
  h1,
  h2,
  h3 {
    font-family: 'Cairo', sans-serif;
  }

  p {
    font-family: 'Cairo', sans-serif;
    font-size: 20px;

  }

  label {
    font-family: 'Cairo', sans-serif;
    font-size: 16px;

  }

  th,
  td {
    text-align: center;
    vertical-align: center;
    horizontal-align: center;
    width: 50;
    height: 80;
    font-family: 'Cairo', sans-serif;

  }

  .form-control:focus {
    box-shadow: none;
  }

  .form-control {
   border-width: 0;
   border-bottom-width: 1px;
    border-radius: 0;
    padding-left: 0
  }

  /*
*
* ==========================================
* FOR DEMO PURPOSE
* ==========================================
*
*/



  .form-control::placeholder {
    font-size: 0.95rem;
    color: #aaa;

    font-style: italic;
  }

  #myInput {
    background-image: url("{{asset('/img/search.png')}}");

    background-position: 10px 12px;
    /* Position the search icon */
    background-repeat: no-repeat;
    /* Do not repeat the icon image */
    width: 100%;
    /* Full-width */
    font-size: 16px;
    /* Increase font-size */
    padding: 12px 20px 12px 40px;
    /* Add some padding */
    border: 1px solid #ddd;
    /* Add a grey border */
    margin-bottom: 12px;
    /* Add some space below the input */
  }
</style>
@endsection


@section('content_header')
@if (Session::has('message'))
<div class="alert alert-{{ Session::get('type', 'warning') }}">
  {{ Session::get('message') }}
</div>
@endif
<div class="d-flex justify-content-between" style="dispaly:inline;">
</div>
@endsection

@section('content')

<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- " style="margin-left:70px;">
  <nav aria-label="breadcrumb" style="margin-top:50px;">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('dashboard.marketer.showAccountInfo')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
      <li class="breadcrumb-item active" aria-current="page">>قائمة الرحلات</li>
    </ol>
  </nav>
  <h1 style="text-align:center">قائمة الرحلات</h1>
  @include('flash-message')



  <h2 style="float: center">ابحث عن الرحلة </h2>
  <form>
    @csrf
    <div class="row">

      <div class="col-sm-4">
          <label>اليوم </label>

          <select name="day" class="form-control" id="day">
              <option value="">اختر</option>

              <option @if(request('day') == 'all') selected @endif value="all">كل يوم </option>
              <option @if(request('day') == 'sat') selected @endif value="sat">السبت</option>
              <option @if(request('day') == 'sun') selected @endif value="sun">الاحد </option>
              <option @if(request('day') == 'mon') selected @endif value="mon">الاثنين </option>
              <option @if(request('day') == 'tue') selected @endif value="tue">الثلاثاء </option>
              <option @if(request('day') == 'wed') selected @endif value="wed">الاربعاء </option>
              <option @if(request('day') == 'thu') selected @endif value="thu">الخميس </option>
              <option @if(request('day') == 'fri') selected @endif value="fri">الجمعة </option>
          </select>
      </div>
      
      <div class="col-sm-4">
          <label>التاريخ</label>
          <input type="date" class="form-control" value="{{ request('from_date') }}" name="from_date">
      </div>
      <div class="col-sm-4">
          <label>القسم\الخدمة</label>
          <select name="service_id" id="" class="form-control">
              <option value="">-- اختر القسم --</option>
              @foreach($services as $service)
                  <option @if(request('service_id') == $service->id) selected @endif value="{{ $service->id }}">{{ $service->name }}</option>
              @endforeach
          </select>
      </div>
      <div class="col-sm-6">
          <label>الى مدينة </label>
          <select name="arrival_city_id" id="" class="form-control">
              <option  value="">-- اختر المدينة--</option>
              @foreach($cities as $city)
                  <option @if(request('arrival_city_id') == $city->id) selected @endif value="{{ $city->id }}">{{ $city->name }}</option>
              @endforeach
          </select>
      </div>
      <div class="col-sm-6">
          <label>من مدينة</label>
          <select name="takeoff_city_id" id="" class="form-control">
              <option value="">-- اختر المدينة--</option>
              @foreach($cities as $city)
                  <option @if(request('takeoff_city_id') == $city->id) selected @endif value="{{ $city->id }}">{{ $city->name }}</option>
              @endforeach
          </select>
      </div>


  </div>
    <button class="btn btn-success "  type="submit">بحث</button>
    <a class="btn btn-warning btn-close " href="">الغاء</a>
  </form>
  <div class="table-responsive" style="margin-top:20px;">
    <table class="table table-striped table-bordered" style="width:100%;text-align:center">
      <thead>
        <th>رقم الرحلة</th>
        <th>الخدمه</th>
        <th>سعر الرحلة </th>
        <th> من </th>
        <th>الى</th>
        <th style="width:100px;">خط سير الرحلة</th>
        <th>اليوم</th>

        <th>من تاريخ </th>
        <th>الى تاريخ </th>
        <th>عدد التذاكر </th>
        <th>ساعة الحضور</th>

        <th> ساعة لحركة </th>
        <th>وزن العفش</th>
        <!-- <th style="width:300px;">اجراءات</th> -->



      </thead>
      <tbody id="trips">

        @foreach ($trips as $trip)

        <tr>
          <td>{{ $trip->trip_id}}</td>
          <td>{{ $trip->provider->service->name}}</td>
          <td>{{ $trip->price }}</td>
          <td>{{ App\Trip::getCityName($trip->takeoff_city_id)}}</td>
          <td>{{ App\Trip::getCityName($trip->arrival_city_id)}}</td>
          <td>{{ $trip->lines_trip}}</td>

          <td>
            <?php $days = json_decode($trip->day, true); ?>
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
          <td>@if($trip->from_date !=null){{ date('d-m-Y', strtotime($trip->from_date) )}}@else @endif</td>
          <td>@if($trip->to_date !=null){{ date('d-m-Y', strtotime($trip->to_date) )}}@else @endif</td>
          <td>{{ $trip->no_ticket}}</td>
          <td>@if($trip->leave_time){{ $trip->leave_time}}@else @endif</td>
          <td>@if($trip->coming_time){{ $trip->coming_time}}@else @endif</td>
          <td>@if($trip->weight){{ $trip->weight}}@else @endif</td>
          <!-- <td>


          </td> -->
        </tr>

        @endforeach
      </tbody>
    </table>

    {{ $trips->links() }}
  </div>
</div>
@endsection

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('script')

<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script>
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>
<script type="text/javascript" src="{{asset('js/jquery-2.1.4.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/js.js')}}"></script>
<script type="text/javascript">
  $('#serch').on('click', function(e) {
    e.preventDefault();
    $day = $('#day').val();
    $from_date = $('#from_date').val();
    $from = $('#from').val();
    $to = $('#to').val();

    $.ajax({
      type: 'post',
      url: "{{route('filter')}}",
      data: {
        'day': $day,
        'from_date': $from_date,
        'from': $from,
        'to': $to,
        '_token': '{{csrf_token()}}',


      },
      success: function(data) {
        $('#trips').html(" ");
        if (data) {
          for (i = 0; i < data.length; i++) {

            $('#trips').append(data[i]);
          }
        } else {
          $('#trips').html(" ");
        }

      }
    });
  })
</script>
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'csrftoken': '{{ csrf_token() }}'
    }
  });
</script>
@endsection