@extends('layouts.admin')
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
    style="border-width: 0;border-bottom-width: 1px; border-radius: 0;padding-left: 0;"
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
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- " style="margin-left:150px;">


  <div class="d-flex justify-content-between" style="dispaly:inline;margin-bottom:50px;">
    <nav aria-label="breadcrumb" style="margin-top:-50px;">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>???????? ???????????? </a></li>
        <li class="breadcrumb-item active" aria-current="page"> ???????????? ?????????? ?????????? ????????????</li>
      </ol>
    </nav>
    <h1 style="text-align:center">???????????? ?????????? ?????????? ????????????</h1>

    @include('flash-message')
  </div>
  <input type="text" id="myInput" onkeyup="myFunction()" placeholder="?????????? ???? ??????????  " style="background-image: url('{{ asset('img/search.png')}}');">

  <div class="table-responsive">

    <table id="myTable" class="table table-striped table-bordered" style="width:100%;text-align:center">
      <thead>
        <tr>

          <th colspan="2" style="horizontal-align : middle;text-align:center; width: 50%;">?????????? </th>
          <th rowspan="2">?????? ????????????</th>
          <th rowspan="2"> ????????????</th>
          <th rowspan="2"> ????????????</th>
          <!-- <th rowspan="2">???????? ?????????????? ??????????????</th>
          <th rowspan="2">???????? ?????????????? ????????????</th> -->
          <!-- <th rowspan="2">?????? ?????????????? </th> -->
          <th rowspan="2">???????? ????????????????</th>
          <th rowspan="2">???????? ????????????</th>
          <th rowspan="2">???????? ???????? ???????????? </th>
          <th rowspan="2">???????? ???????? ???????????? </th>
          <th rowspan="2">???????? ?????????? ??????????</th>
          <th rowspan="2">???????????? ??????????????</th>
          <th rowspan="2">???????????? ??????????????</th>
          <th rowspan="2">??????????????</th>
          <th rowspan="2">??????????</th>
          <th rowspan="2">???????? ????????????</th>
          <th rowspan="2">?????? ??????????????</th>
          <th rowspan="2">?????????? ??????????</th>
          <th rowspan="2">?????? ??????????????</th>
          <th rowspan="2">??????????????</th>
          <th rowspan="2">?????????? ??????????????</th>
        </tr>
        <tr>
          <th scope="col"> ?????? ??????????</th>
          <th scope="col">???????? ??????????</th>

        </tr>
      </thead>
      <tbody>





        @foreach ($reservations as $reservation)
        <?php $marketer = App\Marketer::where('code', $reservation->code)->first();

        ?>
        {{-- @if($marketer) --}}

        <?php $provider_name = App\Provider::select('name_company')->where('id', $reservation->provider_id)->first() ?>
        {{-- @if($provider_name) --}}
        <tr>
          <td>{{ $reservation->id }}</td>
          <td> <span class="badge badge-success"> @switch($reservation->status)@case('confirmed') ???????? @break @case('created')?????????????? ?????????????? @break @case('payed') ???? ?????????? @break @case('canceled') ???????? @break @default @endswitch</span></td>
          <td>{{ $reservation->trip_id }}</td>
          <td>{{ $reservation->trip->provider->name_company }}</td>
          <td>{{ $reservation->marketer->name ?? '-' }}</td>
          <!-- <td>{{ $reservation->passenger->phone }}</td>
          <td>{{ $reservation->passenger->y_phone }}</td>
          <td>{{ $reservation->passenger->name_passenger }}</td> -->
          <td>{{ $reservation->trip->takeoff_city->name }}</td>
          <td>{{ $reservation->trip->arrival_city->name }}</td>
          <td>{{ $reservation->ride_place ?? $reservation->trip->takeoff_city->name }}</td>
          <td>{{ $reservation->drop_place ?? $reservation->trip->arrival_city->name }}</td>
          <td>{{ $reservation->total_price }}@switch($reservation->trip->currency)@case('rs')???????? ??????????@break @case('ry') ???????? ????????@break @default @endswitch</td>
          <td>{{ $reservation->paid }}@switch($reservation->trip->currency)@case('rs')???????? ??????????@break @case('ry')???????? ???????? @break @default 0 @endswitch</td>
          <td>{{ $reservation->total_price - $reservation->paid }} @switch($reservation->trip->currency)@case('rs')???????? ??????????@break @case('ry') ???????? ????????@break @default @endswitch</td>
          <td>{{ date('d-m-Y', strtotime($reservation->trip->from_date) )}}</td>

          <td>
            <?php $days = json_decode($reservation->trip->day, true); ?>
            @foreach($days as $day)
            @switch($day)
            @case('all')?????????? @break
            @case('sat')?????????? @break
            @case('all') ???? ????????????@break
            @case('sun') ??????????@break
            @case('mon') ?????????????? @break
            @case('tue') ???????????????? @break
            @case('wed') ???????????????? @break
            @case('thu') ???????????? @break
            @case('fri') ???????????? @break
            @default
            @endswitch
            @endforeach
          </td>
          <td>{{ $reservation->trip->coming_time }}</td>
          
          <td>
            @switch($reservation->payment_type)
            @case('total_payment') ???????????? ???????? @break
            @case('deposit_payment')????????????@break
            @case('later_payment')?????????? ??????????@break
            @default -
            @endswitch
          </td>
          <td>
            @switch($reservation->payment_method)
            @case('bank') ?????????? ???????????? @break
            @case('telr')???????? ????????@break
            @case('inBus')??????@break
            @endswitch
          </td>

          <td>{{ $reservation->ticket_no }} </td>
          <td style="display:inline-block;width:350px;">
            <a class="btn btn-sm btn-success {{ $reservation->status == 'created' ? '' : 'disabled' }}" href="{{ route('haj.reservations.show', ['id' => $reservation->id]) }}">?????????? ??????????\??????????</a>
            <a class="btn btn-sm btn-warning" href="{{ route('admin.reservations.passengersList',$reservation->id) }}">?????????? ??????????????????</a>
            <a class="btn btn-sm btn-info" href="{{ route('admin.reservations.edit',$reservation->id) }}">?????????? ??????????</a>
            <a class="btn btn-sm btn-primary" href="{{ route('admin.reservations.transfer',['id' => $reservation->id]) }}">?????? ??????????</a>
            <!-- <a class="btn btn-sm btn-warning" href="{{ route('admin.reservations.postpone',$reservation->id) }}">?????????? ??????????</a> -->
            <a href="{{ route('admin.reservations.cancel',['id' => $reservation->id]) }}" class="btn btn-sm btn-danger {{ $reservation->status == 'canceled' ? 'disabled' : '' }}">?????????? ??????????</a>
            
            <!-- <a class="btn btn-sm btn-success" href="{{ route('admin.reservations.transfer',$reservation->id) }}">?????? ??????</a> -->
          </td>
          <td style="width:150px;margin-top:30px">
            <a class="btn btn-sm btn-primary" href="{{ route('admin.sms',$reservation->id) }}" style="margin-bottom: 10px"> <span class="glyphicon glyphicon-envelope"></span> ???????? ?????????????? </a>
            <a class="btn btn-sm btn-success" @if($reservation->passenger->phone) href="https://api.whatsapp.com/send?phone={{$reservation->passenger->phone}}" @else href="https://api.whatsapp.com/send?phone={{$reservation->passenger->y_phone}}" @endif style="width:100px">???????? ???? </a>


          </td>
        </tr>
        {{-- @endif --}}
        {{-- @endif --}}
        @endforeach
      </tbody>
    </table>
    {{ $reservations->links() }}
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

  function cancelReservation() {
    x = confirm('???? ?????? ?????????? ???? ?????????? ?????????? ??');

    if (x) {
      $('#cancel_reservation_form').submit();
    }
  }



  function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          td2 = tr[i].getElementsByTagName("td")[1];
          if (td2) {
            txtValue = td2.textContent || td2.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              td9 = tr[i].getElementsByTagName("td")[2];
              if (td9) {
                txtValue = td9.textContent || td9.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                  tr[i].style.display = "";
                } else {
                  td3 = tr[i].getElementsByTagName("td")[3];
                  if (td3) {
                    txtValue = td3.textContent || td3.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                      tr[i].style.display = "";
                    } else {
                      td4 = tr[i].getElementsByTagName("td")[6];
                      if (td4) {
                        txtValue = td4.textContent || td4.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                          tr[i].style.display = "";
                        } else {
                          td5 = tr[i].getElementsByTagName("td")[5];
                          if (td5) {
                            txtValue = td5.textContent || td5.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                              tr[i].style.display = "";
                            } else {
                              td7 = tr[i].getElementsByTagName("td")[4];
                              if (td7) {
                                txtValue = td7.textContent || td7.innerText;
                                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                  tr[i].style.display = "";
                                } else {
                                  td14 = tr[i].getElementsByTagName("td")[8];
                                  if (td14) {
                                    txtValue = td14.textContent || td14.innerText;
                                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                      tr[i].style.display = "";
                                    } else {
                                      td17 = tr[i].getElementsByTagName("td")[9];
                                      if (td17) {
                                        txtValue = td17.textContent || td17.innerText;
                                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                          tr[i].style.display = "";
                                        } else {
                                          td18 = tr[i].getElementsByTagName("td")[10];
                                          if (td18) {
                                            txtValue = td18.textContent || td18.innerText;
                                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                              tr[i].style.display = "";
                                            } else {
                                              td6 = tr[i].getElementsByTagName("td")[7];
                                              if (td6) {
                                                txtValue = td6.textContent || td6.innerText;
                                                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                                  tr[i].style.display = "";
                                                } else {
                                                  tr[i].style.display = "none";

                                                }
                                              }

                                            }
                                          }
                                        }
                                      }
                                    }
                                  }
                                }
                              }
                            }
                          }
                        }
                      }

                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  }
</script>
@endsection