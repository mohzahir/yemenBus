@extends('layouts.admin')
@section('style')
<meta name="_token" content="{{csrf_token()}}" />
<link href="{{asset('css/ar.css')}}" rel="stylesheet" class="lang_css arabic">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

<!-- Optional theme -->
<!-- Latest compiled and minified CSS -->



<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->


<script src="{{asset('js/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="{{asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.css')}}">
  <link rel="stylesheet" href="{{asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">

  <style>

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
</style>
@endsection

@section('content_header')
    <h1>إنشاء قرعة</h1>
    <p class="mt-1 text-muted">ملحوظة: جميع الأوقات الآتية سيتم تحويلها لتوقيت اليمن</p>
@endsection

@section('content')
<div class="main_container col-md-12 col-md-8 col-sm-12 col-xs- "  style="margin-left:-100px;margin-top:150px">
     <nav aria-label="breadcrumb" style="margin-top:-50px;" >
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('dashboard.admin.index')}}"> <span class="glyphicon glyphicon-home"></span>صفحة رئيسية </a></li>
    <li class="breadcrumb-item active" aria-current="page"> انشاء القرعة </li>
  </ol>
</nav>
       <h1 style ="text-align:center">انشاء القرعة</h1>

@include('flash-message')
    <form method="POST" action="{{ route('dashboard.competitions.store') }}" class="pb-4 @if ($errors->any()) was-validated @endif" enctype="multipart/form-data">
        @csrf
        {{-- <div class="form-group">
            <label for="type">النوع</label>
            <select name="type" id="type" class="form-control" onchange="checkType()">
                <option value="free">مجانية</option>
                <option value="discount">مخفضة</option>
            </select>
        </div> --}}
        <div class="form-group">
            <label for="old_ticket_price">سعر التذكرة قبل التخفيض (ريال)</label>
            <input type="number" class="form-control" id="old_ticket_price" min="1" name="old_ticket_price" value="{{ old('old_ticket_price') }}" required>
            @error('old_ticket_price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group" id="discount_percentage-warapper">
            <label for="discount_percentage">نسبة التخفيض</label>
            <input type="number" class="form-control" id="discount_percentage" min="1" max="100" name="discount_percentage" value="{{ old('discount_percentage') }}" required>
            <small class="form-text text-muted">
                ضع 100 للقرع المجانية
            </small>
            @error('discount_percentage')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="new_ticket_price">سعر التذكرة بعد التخفيض (ريال)</label>
            <input type="number" class="form-control" disabled id="new_ticket_price">
        </div>
        <div class="form-group">
            <label for="available_tickets">عدد التذاكر المجانية / المخفضة</label>
            <input type="number" class="form-control" id="available_tickets" min="0" name="available_tickets" value="{{ old('available_tickets') }}" required>
            @error('available_tickets')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        {{-- <div class="form-group">
            <label for="week">اسبوع بدء القرعة</label>
            <input type="date" class="form-control" id="week" min="0" name="week" required>
            <small class="form-text text-muted">
                اختر أي يوم من أيام الاسبوع الذي سوف تظهر فيه القرعة
            </small>
        </div> --}}
        <div class="form-group">
            <label for="finish_at">معاد اختيار الفائز</label>
        <div class='input-group date' id='finish_at'>
          <input type='text' class="form-control" name="finish_at"  required />
          <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
        @error('finish_at')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
      </div>
    
      <div class="form-group">
      <label for="trip_at">معاد الرحلة</label>

        <div class='input-group date' id='trip_at'>
          <input type='text' class="form-control" name="trip_at"  required/>
          <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
        @error('trip_at')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
      </div>
  
          <div class="form-group">
            <label for="direction">اتجاه الرحلة</label>
            <select name="direction" id="direction" class="bg-gray-300 text-sm form-control" required>
                <option value="saudia_yemen" {{ old('direction') == 'saudia_yemen' ? 'selected' : '' }}>من السعودية إلى اليمن</option>
                <option value="yemen_saudia" {{ old('direction') == 'yemen_saudia' ? 'selected' : '' }}>من اليمن إلى السعودية</option>
                <option value="in_yemen" {{ old('direction') == 'in_yemen' ? 'selected' : '' }}>داخل المدن اليمنية</option>
            </select>
            @error('direction')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="starting_place">نقطة الانطلاق</label>
            <input type="text" class="form-control" name="starting_place" value="{{ old('starting_place') }}" id="starting_place" required>
            @error('starting_place')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="finishing_place">نقطة النهاية</label>
            <input class="form-control" name="finishing_place" value="{{ old('finishing_place') }}" id="finishing_place" required>
            @error('finishing_place')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="booking_link">رابط الحجز من يمن باص</label>
            <input type="url" class="form-control" id="booking_link" name="booking_link" value="{{ old('booking_link') }}" required>
            @error('booking_link')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="result_phone">الجوال الخاص باستقبال النتائج</label>
            <div class="justify-center">
                <div>
                    <input type="radio" name="phone_country" id="sa" checked value="966">
                    <label for="sa">سعودي</label>
                </div>
                <div>
                    <input type="radio" name="phone_country" id="ye" value="967">
                    <label for="ye">يمني</label>
                </div>
            </div>
            <input type="text" class="form-control" id="result_phone" name="result_phone" placeholder="مثال: 501212121" value="{{ old('result_phone') }}" required>
            @error('result_phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="sponsor">الراعي</label>
            <input type="text" class="form-control" id="sponsor" name="sponsor" value="{{ old('sponsor') }}" required>
            @error('sponsor')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="sponsor_url">رابط الراعي</label>
            <input type="url" class="form-control" id="sponsor_url" name="sponsor_url" value="{{ old('sponsor_url') }}" required>
            @error('sponsor_url')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="sponsor_banner">بانر الراعي (اختياري)</label>
            <div class="form-check">
                <input class="form-check-input sponsor-banner-type" checked type="radio" onchange="checkSponsorBannerType()" name="sponsor_banner_type" value="banner_image" id="sponsor_banner_image">
                <label class="form-check-label mr-4" for="sponsor_banner_image">
                    ملف
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input sponsor-banner-type" type="radio" onchange="checkSponsorBannerType()" name="sponsor_banner_type" value="banner_url" id="sponsor_banner_url">
                <label class="form-check-label mr-4" for="sponsor_banner_url">
                    رابط (صورة)
                </label>
            </div>
            <input type="file" class="form-control mt-2" id="sponsor_banner" name="sponsor_banner" value="{{ old('sponsor_banner') }}">
            @error('sponsor_banner')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="transportation_company">الشركة الناقلة</label>
            <input type="text" class="form-control" id="transportation_company" name="transportation_company" value="{{ old('transportation_company') }}" required>
            @error('transportation_company')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="transportation_company_url">رابط الشركة الناقلة</label>
            <input type="url" class="form-control" id="transportation_company_url" name="transportation_company_url" value="{{ old('transportation_company_url') }}" required>
            @error('transportation_company_url')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="transportation_company_banner">بانر الشركة الناقلة (اختياري)</label>
            <div class="form-check">
                <input class="form-check-input transportation-company-banner-type" checked type="radio" onchange="checkTransportationCompanyBannerType()" name="transportation_company_banner_type" value="banner_image" id="transportation_company_banner_image">
                <label class="form-check-label mr-4" for="transportation_company_banner_image">
                    ملف
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input transportation-company-banner-type" type="radio" onchange="checkTransportationCompanyBannerType()" name="transportation_company_banner_type" value="banner_url" id="transportation_company_banner_url">
                <label class="form-check-label mr-4" for="transportation_company_banner_url">
                    رابط (صورة)
                </label>
            </div>
            <input type="file" class="form-control mt-2" id="transportation_company_banner" name="transportation_company_banner" value="{{ old('transportation_company_banner') }}">
            @error('transportation_company_banner')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="terms">شروط القرعة</label>
            <textarea class="form-control" id="terms" name="terms">{!! old('terms') !!}</textarea>
            @error('terms')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success btn-lg">إنشاء</button>
         <a class="btn btn-warning btn-close btn-lg" href="">الغاء</a>
     <a class="btn btn-danger btn-close btn-lg" href="{{ route('dashboard.admin.index') }}">اغلاق</a>
    </form>
    </div>
@endsection

{{-- @section('plugins.Select2', true) --}}

@section('script')

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script  src="{{asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>

<script  src="{{asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>


    <script>
jQuery(document).ready(function(){

    $('#trip_at').datetimepicker({
        useCurrent: false,
                stepping: 60,
                format: 'yyyy-mm-dd hh:ii',
                timeZone: 'Asia/Aden',
            });
    $('#finish_at').datetimepicker({
        useCurrent: false,
                stepping: 60,
                format: 'yyyy-mm-dd hh:ii',
                timeZone: 'Asia/Aden',
            });
    $("#trip_at").on("dp.change", function(e) {
      $('#finish_at').data("DateTimePicker").minDate(e.date);
    });
    $("#finish_at").on("dp.change", function(e) {
      $('#trip_at').data("DateTimePicker").maxDate(e.date);
    });
     $("#trip_at").on("change.datetimepicker", function (e) {
            $('#finish_at').datetimepicker('maxDate', e.date);
        });
  });

           /* tinymce.init({
                selector: '#terms',
                  toolbar: 'undo redo | bold italic underline strikethrough | fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent | forecolor backcolor casechange removeformat',
            });

            $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
            icons: {
                time: 'fas fa-clock',
                date: 'fas fa-calendar',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
                previous: 'fas fa-chevron-right',
                next: 'fas fa-chevron-left',
                today: 'fas fa-calendar-check-o',
                clear: 'fas fa-trash',
                close: 'fas fa-times'
            } });

            var tomorrow = moment().tz('Asia/Aden');

            $('#trip_at').datetimepicker({
                useCurrent: false,
                stepping: 60,
                format: 'YYYY-MM-DD HH:00:00',
                timeZone: 'Asia/Aden',
                minDate: tomorrow
            });
            $('#finish_at').datetimepicker({
                useCurrent: false,
                stepping: 60,
                format: 'YYYY-MM-DD HH:00:00',
                timeZone: 'Asia/Aden',
                minDate: tomorrow
            });

            $('#trip_at').datetimepicker('date', "{{ old('trip_at') }}");
            $('#finish_at').datetimepicker('date', "{{ old('finish_at')}}");

        });

        $("#trip_at").on("change.datetimepicker", function (e) {
            $('#finish_at').datetimepicker('maxDate', e.date);
        });

        //var tomorrow = new Date( new Date().getTime() + (1000 * 60 * 60 *24) );
        //document.getElementById('week').setAttribute('min', new Date().toISOString().split("T")[0]);
        //var tomorrow = luxon.DateTime.local().setZone('Asia/Aden').plus({ days: 1 });
        //var tomorrow = .add(1, 'days')

        /*document.getElementById('finish_at').setAttribute('min', tomorrow.toISODate());
        document.getElementById('trip_at').setAttribute('min', tomorrow.toISODate());

        function setTripMaxDate() {
            document.getElementById('finish_at').setAttribute('max', document.getElementById('trip_at').value);
        }
        setTripMaxDate()*/
        
        function checkSponsorBannerType() {
            var type = $('.sponsor-banner-type:checked').val();

            if (type === 'banner_image') {
                $('#sponsor_banner').attr('type', 'file');
            }
            else {
                $('#sponsor_banner').attr('type', 'text');
            }
        }
        checkSponsorBannerType();

        function checkTransportationCompanyBannerType() {
            var type = $('.transportation-company-banner-type:checked').val();

            if (type === 'banner_image') {
                $('#transportation_company_banner').attr('type', 'file');
            }
            else {
                $('#transportation_company_banner').attr('type', 'text');
            }
        }
        checkTransportationCompanyBannerType();

        function calculateTicketPrice() {
            if (isNaN($('#old_ticket_price').val()) || isNaN($('#discount_percentage').val())) {
                return;
            }
            $('#new_ticket_price').val( $('#old_ticket_price').val() * ( ( 100 -  $('#discount_percentage').val() ) / 100 ) )
        }
        calculateTicketPrice()
        $('#discount_percentage, #old_ticket_price').on('keyup', calculateTicketPrice);

        /*function checkType() {
            if (document.getElementById('type').value === 'free') {
                $('discount_percentage').prop('required', false);
                $('#discount_percentage-warapper').addClass('d-none');
                return;
            }
            $('#discount_percentage-warapper').removeClass('d-none');
            $('discount_percentage').prop('required', true);
            return;
        }*/
        //checkType();
    </script>
@endsection