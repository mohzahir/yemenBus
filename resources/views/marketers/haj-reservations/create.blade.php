@extends('layouts.dashboard')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Amiri:ital@1&family=Cairo:wght@200;400&family=Changa:wght@300&family=El+Messiri&family=Lateef&display=swap&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>

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
</style>
@endsection
@section('content_header')
<h1>تأكيد حجز</h1>
@endsection

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- " style="margin-left:70px;">
    <nav aria-label="breadcrumb" style="">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.marketer.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
            <li class="breadcrumb-item active" aria-current="page"> حجز رحلة حج وعمرة</li>
        </ol>
    </nav>
    <h1 style="text-align:center">حجز رحلة حج وعمرة</h1>

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
    {{-- @if ($message = Session::get('error')) --}}

    @if ($errors->any())
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        @foreach ($errors->all() as $error)
        <p class="yellow-text font lato-normal center">{{ $error }}</p>
        @endforeach
    </div>
    @endif
    <form class="form-contact contact_form" action="{{ route('marketers.haj.reservations.store') }}" method="post" novalidate="novalidate" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="form-group d-flex">
                    <div class="form-group">
                        <select class="form-control" name="trip_id" id="trip_id">
                            <option value="">اختر رحلة</option>
                            @if (count($trips) > 0)
                            @foreach ($trips as $trip)
                            {{-- <option value="{{$trip->id}}" @if(old('trip_id') == $trip->id) selected @endif>{{$trip->takeoff_city->name ?? $trip->takeoff_city->name }} -> {{$trip->arrival_city->name ?? $trip->arrival_city->name }} - {{ $trip->direcation == 'yts' ? ' من اليمن للسعوديه ' : ($trip->direcation == 'sty' ? ' من السعوديه لليمن' : 'رحله داخل اليمن')}} - {{ $trip->provider->name_company }} - {{ $trip->price }} ريال</option> --}}
                            <option value="{{$trip->id}}" @if(old('trip_id')==$trip->id) selected @endif> من مدينه {{$trip->takeoff_city->name }} الى مدينه {{$trip->arrival_city->name }} . اتجاه الرحله {{ $trip->direcation == 'yts' ? ' من اليمن للسعوديه ' : ($trip->direcation == 'sty' ? ' من السعوديه لليمن' : 'رحله داخل اليمن')}} . مزود الخدمه {{ $trip->provider->name_company }} . سعر الرحله {{ $trip->price }} ريال</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="content py-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstname">الاسم الكامل <strong class=" text-danger">*</strong></label>
                            <input id="firstname" type="text" class="form-control" value="{{ old('name') }}" name="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">رقم الهاتف <strong class=" text-danger">*</strong></label>
                            <div class=" d-flex">
                                
                                <div class="phone-intro">
                                    <select class="form-control" name="phoneCountry" id="phoneCountry">
                                        <option @if(old('phoneCountry')=='s') selected @endif value="s">966+</option>
                                        <option @if(old('phoneCountry')=='y') selected @endif value="y">967+</option>
                                    </select>
                                </div>
                                <input class="form-control valid" value="{{ old('phone') }}" name="phone" id="phone" type="text">

                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.row-->
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <label for="street">جنس الراكب</label>
                            <select class="form-control w-100" name="gender" id="gender">
                                <option value="">--</option>
                                <option @if(old('gender')=='male') selected @endif value="male">ذكر</option>
                                <option @if(old('gender')=='female') selected @endif value="female">انثى</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <label for="zip">الفئة العمرية</label>
                            <select class="form-control w-100" name="age" id="age">
                                <option value="">--</option>
                                <option @if(old('age')=='adult') selected @endif value="adult">بالغ</option>
                                <option @if(old('age')=='child') selected @endif value="child">طفل (من سنتين الى 12)</option>
                                <option @if(old('age')=='baby') selected @endif value="baby">رضيع (تحت السنتين)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <label for="state">تاريخ الميلاد</label><br>
                            <!-- <input class="form-control" name="dateofbirth" id="dateofbirth" type="date"
                                style="margin-right: 3px"> -->
                                <input type="text" value="{{ old('dateofbirth.0') }}" style="width: 25%; display: inline-block;" name="dateofbirth[]" placeholder="يوم" class="form-control">
                                <input type="text" value="{{ old('dateofbirth.1') }}" style="width: 30%; display: inline-block;" name="dateofbirth[]" placeholder="شهر" class="form-control">
                                <input type="text" value="{{ old('dateofbirth.2') }}" style="width: 40%; display: inline-block;" name="dateofbirth[]" placeholder="سنة" class="form-control">
                                
                                
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <label for="country">رقم الهوية</label>
                            <input class="form-control" name="nid" id="nid" value="{{ old('nid') }}" type="text"
                                style="margin-right: 3px">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">مكان الصعود</label>
                            <input class="form-control" name="ride_place" value="{{ old('ride_place') }}" id="ride_place" type="text"
                                style="margin-right: 3px">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">مكان النزول</label>
                            <input class="form-control" name="drop_place" value="{{ old('drop_place') }}" id="drop_place" type="text"
                                style="margin-right: 3px">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="street">البريد الالكتروني</label>
                            <input id="street" type="email" class="form-control" value="{{ old('email') }}" name="email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="passport">صوره الجواز</label>
                            <input id="passport" type="file" class="form-control" value="{{ old('passport_img') }}" name="passport_img">
                        </div>
                    </div>
                </div>
                <!-- /.row-->
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <input onclick="$('#deposit_value').css('display', 'none')" @if(old('payment_type')=='total_payment') checked @endif type="radio" class="form-radio" name="payment_type" value="total_payment"> دفع كامل المبلغ
                    <input onclick="$('#deposit_value').css('display', 'block')" @if(old('payment_type')=='deposit_payment') checked @endif type="radio" class="form-radio" name="payment_type" value="deposit_payment"> دفع عربون
                </div>

                <div id="deposit_value" style="display: none">
                    {{-- <input type="text" class="form-control" placeholder="المبلغ المدفوع" name="paid" value="{{old('paid')}}"> --}}
                    <div>
                        <p class="text-danger">قيمه العربون للرحلات من السعوديه لليمن هي {{ env('DEPOSIT_RS_VALUE', 50) }}</p>
                        <p class="text-danger">قيمه العربون للرحلات من اليمن للسعوديه هي {{ env('DEPOSIT_RY_VALUE', 5000) }}</p>
                    </div>
                </div>

                <div class="text-primary">
                    <p> رصيدك بالريال السعودي ({{ $marketer->balance_rs}}) </p>
                    <p> رصيدك بالريال اليمني ({{ $marketer->balance_ry}}) </p>
                </div>
            </div>

        </div>
        <div class="form-group reserve-btn">
            <button type="submit" class="btn btn-success">توجه للدفع</button>
        </div>
    </form>
</div>
@endsection
@section('script')
<script src="http://127.0.0.1:8000/passenger-assets/js/ticket.js"></script>
<script type="text/javascript">
    $('#date').on('change', function(e) {
        e.preventDefault();
        $date = $('#date').val();
        $.ajax({
            type: 'get',
            url: "{{route('reservation.date')}}",

            data: {
                'date': $date,

                '_token': '{{csrf_token()}}',


            },
            success: function(data) {
                $('#' + data).attr('selected', 'true');
            }
        });
    })
</script>

<script type="text/javascript">
    $(document).on('submit', '#myForm', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        var form_data = new FormData(document.getElementById("myForm"));

        var amount = 0;

        if ($('input[name=amount_type]:checked', '#myForm').val() == 'full') {
            amount = $("#amount").val();
        } else {
            amount = $("#amount_deposit").val();

        }
        var currency = $("#currency").val();
        if (currency == 'sar') {
            var currency = "ريال سعودي";
        } else {
            var currency = "ريال يمني";
        }
        swal({
            title: "سيتم خصم مبلغ " + amount + " " + currency + " من رصيدك في الموقع هل تريد اتمام للعمليه ؟",
            type: "question",
            confirmButtonClass: "btn-danger",
            confirmButtonText: 'نعم',
            cancelButtonText: 'لا',
            showCancelButton: true,
            showCloseButton: true
        }).then(function() {
            $.ajax({
                type: "post",
                url: "{{route('dashboard.reservations.storeConfirm')}}",
                data: form_data,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,

                /* data: {           
                    "_token": "{{ csrf_token() }}",
                    "order_id": $("#order_id").val(),
                    "order_url": $("#order_url").val(),
                    "passenger_name": $("#passenger_name").val(),
                    "passenger_phone": $("#passenger_phone").val(),
                    "passenger_phone_yem": $("#passenger_phone_yem").val(),
                    "provider_id": $("#provider_id").val(),
                    "amount": $("#amount").val(),
                    "amount_deposit": $("#amount_deposit").val(),
                    "day": $("#day").val(),
                    "date": $("#date").val(),
                    "code": $("#code").val(),
                    "from_city": $("#from_city").val(),
                    "to_city": $("#to_city").val(),
                    "ticket_no": $("#ticket_no").val(),
                    "image": $("#image").val(),
                    "currency": $("#currency").val(),
                    "amount_type":  $('input[name=amount_type]:checked','#myForm').val(),
},*/
                success: function(res) {
                    if ($.isEmptyObject(res.error)) {


                        if (res.msge == 'success') {
                            var currency = $("#currency").val();
                            if (currency == 'sar') {
                                var currency = "ريال سعودي";
                            } else {
                                var currency = "ريال يمني";
                            }


                            if ($('input[name=amount_type]:checked', '#myForm').val() == 'full') {
                                amount = $("#amount").val();
                                amount_deposit = $("#amount_deposit").val();
                                date = $("#date").val();
                                order_id = $("#order_id").val();
                                swal({
                                    title: "تم تاكيد الحجز بنجاح",
                                    text: ' تم تاكيد الحجز بمبلغ ' + amount + '  ' + currency + ' من مبلغ  ' + amount + '   ' + currency + ' في  تاريخ ' + date,
                                    type: "success",
                                    confirmButtonText: 'توجه لصفحةالحجوزات',
                                    showCloseButton: true
                                }).then(function() {
                                    window.location = res.url;

                                });

                            } else {
                                amount = $("#amount").val();
                                amount_deposit = $("#amount_deposit").val();
                                order_id = $("#order_id").val();
                                date = $("#date").val();



                                swal({
                                    title: "تم تاكيد الحجز بنجاح",
                                    text: ' تم تاكيد الحجز بمبلغ ' + amount_deposit + '  ' + currency + ' من مبلغ  ' + amount + '   ' + currency + ' في  تاريخ ' + date,
                                    type: "success",
                                    confirmButtonText: 'توجه لصفحةالحجوزات',
                                    showCloseButton: true
                                }).then(function() {
                                    window.location = res.url;

                                });


                            }
                        } else {
                            swal({
                                title: "رصيدك غير  كافي ",
                                type: "warning",
                            }).then(function() {

                            });
                        }
                    } else {
                        window.scrollTo(0, 0);

                        printErrorMsg(res.error);
                    }


                },



            });
        });

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function(key, value) {
                $(".print-error-msg").find("ul").append('<li style="list-style-type: none;">' + value + '<button type="button" class="close" data-dismiss="alert">×</button></li>');
            });
        }

    });

    /*
    swal({
        title: "Are you sure to delete this  of ?",
        text: "Delete Confirmation?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Delete",
        closeOnConfirm: false
      },
      function() {
        $.ajax({
            type: "post",
            url: "{{route('dashboard.reservations.storeConfirm')}}",
            data: "data",
            success: function(data) {}
          })
          .done(function(data) {
            swal("Deleted!", "Data successfully Deleted!", "success");
          })
          .error(function(data) {
            swal("Oops", "We couldn't connect to the server!", "error");
          });
      }
    );
    });*/
</script>
@endsection