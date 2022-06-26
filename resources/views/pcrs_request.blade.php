<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قرعة شركة يمن باص</title>
    <meta name="_token" content="{{csrf_token()}}" />

    {{-- <meta name="description" value="fdsa"> --}}
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
    <script src="http://demo.expertphp.in/js/jquery.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet"> 
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>

<style>
    body{
        font-family:Cairo;
    }
    hr.new5 {
  border:1px solid green ;
  border-radius: 5px;
}
</style>
    <script type="text/javascript">

$(document).ready(function(){
    var counter = 2;
    var i = 1;
    
    <?php
   if(old('names')){?>
       var counter ={{count(old('names'))}};
 <?php  }?>
   
        
    $("#addButton").click(function () {
                
      counter++;
    var newTextBoxDiv = $(document.createElement('div'))
         .attr("id", 'TextBoxDiv' + counter);
                    

    newTextBoxDiv.after().html('<div id="TextBoxDiv'+counter+'" style="margin-bottom:20px;margin-top:20px;float:right;text-align:right"><input type="hidden" value="'+counter+'" name="i"><label for="direction" class=" w-60 font-bold ">الاسم الثلاثي: </label><input type="text" id="textbox1"  name="names[]" value="{{ old("names'+counter+'") }}" class="bg-gray-300 text-sm" class="bg-gray-300 text-sm"required ><br><label for="direction" class=" w-60 font-bold "style="text-align:right;">اللقب : </label><br><input type="text"  name="surnames[]"  value="{{ old("surnames'+counter+'") }}" id="textbox1" class="bg-gray-300 text-sm" class="form-class"required > <label for="direction" class=" w-30 font-bold ">رقم الجوال : </label><input type="number" name="phones[]" oninput="javascript: if (this.value.length > 10) this.value = this.value.slice(0,10);"    value="{{ old("phones'+counter+'") }}" style="width:200px;" id="textbox1" class="bg-gray-300 text-sm" required>  <label for="direction" class=" w-30 font-bold "> رقم الجواز : </label><input type="number" name="passport_nos[]" value="{{ old("passport_nos'+counter+'") }}"  id="textbox1" class="bg-gray-300 text-sm"required ><input type="file" name="passport_images[]"  value="{{ old("passport_images'+counter+'") }}"  style="width:200px;float:right;text-align:right" id="textbox1" class="bg-gray-300 text-sm"> <label for="direction" class=" w-40 font-bold " style="float: right;margin-right:-5px;text-align:right">     صورة جواز السفر (اختياري): </label></div>');
            
    newTextBoxDiv.appendTo("#TextBoxesGroup");

                
    i++;
     });

     $("#removeButton").click(function () {
        
     
    if(counter==1){
          alert("لقد تم حذف جيمع المسافرين الاخرين");
          return false;
       }   
        
   
   
             
        $("#TextBoxDiv" + counter).remove();
        counter--;
       
            
     });
        
     $("#getButtonValue").click(function () {
        
    var msg = '';
    for(i=1; i<counter; i++){
   	  msg += "\n Textbox #" + i + " : " + $('#textbox' + i).val();
    }
    	  alert(msg);
     });
  });
</script>



</head>
<body class="bg-gray-200">
    <div class="">

        <div class="bg-white py-6 shadow-sm" >
            <div class="container mx-auto">
                <h1 class="text-center font-bold text-2xl"><a class="text-blue-700 hover:text-blue-900" href="https://www.yemenbus.com">يمن باص YemenBus</a></h1>
                <p class="text-md text-center font-bold">الشبكة الذكية لحجوزات المغتربين اليمنين بالسعودية</p>
                <p class="text-xs text-gray-800 text-center mt-4">رحلات الباصات - رحلات طيران - انجاز المعاملات التاشيرات بالسفارة السعودية باليمن - تسجيل الحجاج - تسجيل المعتمرين - تسجيل الطلاب المغتربين بالجامعات والمعاهد اليمنية - التأمين الصحي للسفر</p>
            </div>
        </div>

        <div class="container mt-4 mx-auto">
                       <div style="text-align:right"> @include('flash-message')</div>

            <div class="mb-4">
                <p class="text-center text-gray-700  text-2xl"><i class="fas fa-briefcase-medical text-yellow-500"></i>   طلب تسجيل موعد لفحص PCR لخلو من كورونا لغرض السفر الى الخارج  <i class="fas fa-briefcase-medical text-yellow-500"></i></p>
               <a href="{{ route('home') }}"> <p class="text-center mt-2"><strong>   احجز رحلتك الان</strong></p></a>
            </div>

            <div class="bg-green-300 shadow-md p-4 mb-6 rounded-md" id="green" >

            <div class="mb-6">
            <div class="bg-white shadow-md p-4 rounded-md mb-4" id="whight" >

                <form action="{{route('pcrs_request.store')}}"  enctype="multipart/form-data" method="post" style="margin-bottom:50px;">
                @csrf
                

                    <div class="form-group flex items-center mb-2" >
                        <label for="city" class="block w-60 font-bold"  style="margin-left:20px;"> المدينة:</label>
                        <select name="city_id" id="city" class="bg-gray-300 text-sm" required>
                         <option value="" {{ old('city_id') == "" ? "selected" : "" }}>--اختر المدينة--</option>

                        @foreach($cities as $city)
                        <option value="{{$city->id}}" {{ old('city_id') == $city->id ? "selected" : "" }}>{{$city->name}}</option>
                        @endforeach
                        </select>
                    </div>
                   <?php if(old('city_id')){ 
                $labs=App\Lab::where('city_id',old('city_id'))->get(); ?>
                    <div class="form-group flex items-center mb-2" >
                        <label for="lab_id" class="block w-60 font-bold"  style="margin-left:20px;"> المختبر:</label>
                        <select name="lab_id" id="lab_id" class="bg-gray-300 text-sm" required>

                        @foreach($labs as $lab)
                        <option value="{{$lab->id}}" {{ old('lab_id') == $lab->id ? "selected" : "" }}>{{$lab->name}}</option>
                        @endforeach
                        </select>
                    </div>
                   <?php }else{ ?>
                    <div class="form-group flex items-center mb-2" style="margin-top:10px;">
                        <label for="lab_id" class="block w-60 font-bold"  style="margin-left:20px;"> المختبر:</label>
                        <select name="lab_id" id="lab_id" class="bg-gray-300 text-sm" required>
                       

                        
                        </select>
                    </div>
                    <?php } ?>
                    <input type="hidden" name="i" value="1">
<div class="form-group flex items-center mb-2" style="margin-top:10px;">
                 
                  
                 <div id='TextBoxesGroup' style="margin-top:10px;">
                     
    <div id="TextBoxDiv1" style="float:right;text-align:right">
    <label for="direction" class=" w-60 font-bold ">الاسم الثلاثي: </label><input type="text" id="textbox1"  name="names[]"  value="{{ old('names.0') }}"class="bg-gray-300 text-sm" class="bg-gray-300 text-sm"required ><br><label for="direction" class=" w-30 font-bold "style="text-align:right;">اللقب : </label><br><input type="text"  name="surnames[]"  value="{{ old('surnames.0') }}" id="textbox1" class="bg-gray-300 text-sm" class="form-class"required > <label for="direction" class=" w-30 font-bold ">رقم الجوال : </label><input type="number" name="phones[]" oninput="javascript: if (this.value.length > 10) this.value = this.value.slice(0,10);"  value="{{ old('phones.0') }}" maxlength=10   style="width:200px;" id="textbox1" class="bg-gray-300 text-sm" required>  <label for="direction" class=" w-30 font-bold "> رقم الجواز : </label><input type="number" name="passport_nos[]"  value="{{ old('passport_nos.0') }}" id="textbox1" class="bg-gray-300 text-sm"required > <label for="direction" class=" w-30 font-bold "style="">  صورة جواز السفر (اختياري): </label><input type="file" value="{{ old('passport_images.0') }}" name="passport_images[]"  style="width:200px;" id="textbox1" class="bg-gray-300 text-sm" > 

    </div>
    @if(old('names'))
            @for( $i =1; $i < count(old('names')); $i++) 
    <div id="TextBoxDiv{{$i+1}}" style="float:right;text-align:right">
    <label for="direction" class=" w-60 font-bold ">الاسم الثلاثي: </label><input type="text" id="textbox1"  name="names[]"  value="{{ old('names.'.$i)}}"class="bg-gray-300 text-sm" class="bg-gray-300 text-sm"required ><br><label for="direction" class=" w-60 font-bold "style="text-align:right;">اللقب : </label><br><input type="text"  name="surnames[]" value="{{ old('surnames.'.$i)}}" id="textbox1" class="bg-gray-300 text-sm" class="form-class"required > <label for="direction" class=" w-30 font-bold ">رقم الجوال : </label><input type="number" name="phones[]" oninput="javascript: if (this.value.length > 10) this.value = this.value.slice(0,10);"      value="{{ old('phones.'.$i)}}" maxlength=10   style="width:200px;" id="textbox1" class="bg-gray-300 text-sm" required>  <label for="direction" class=" w-30 font-bold "> رقم الجواز : </label><input type="number"  name="passport_nos[]"  value="{{ old('passport_nos.'.$i)}}" id="textbox1" class="bg-gray-300 text-sm"required > <label for="direction" class=" w-30 font-bold "style="">  صورة جواز السفر (اختياري): </label><input type="file"  value="{{ old('passport_images.'.$i)}}" name="passport_images[]"  style="width:200px;" id="textbox1" class="bg-gray-300 text-sm" > 

    </div>
@endfor

    @endif
    
</div>
    </div>
    @if(old('names'))
   <?php $d=count(old('names'));?>
   @endif
    <div style="float:right;margin-bottom:40px">
                      <input type='button' @if(old('names')) data="{{count(old('names'))}}" @endif class="btn btn-success" value=' اضافة مسافر ' id='addButton'>
<input type='button'  class="btn btn-danger " @if(old('names')) data="{{count(old('names'))}}" @endif value='حذف مسافر  ' id='removeButton'>

                  </div>
                  
    

                    <br>
                  <div style="margin-top:100px;">
                  
                    
<div class="form-group flex items-center mb-2" >
    <label for="direction" class=" w-60 font-bold " style="float:right;text-align:right;margin-right:-13px;">وقت اخذ العينة (اختياري): </label>
                  <input type="time"  style="float: right;width:180px" value="{{old('time_take')}}" name="time_take" value="{{old('time_take')}}" class="bg-gray-200 text-sm;" >

</div> 
                           


                 <div class="form-group flex items-center mb-2" style="margin-top:10px;">
<label for="direction" class=" w-40 font-bold " style="float: right;margin-right:-5px;text-align:right">     تاريخ السفر (اختياري): </label>
                  <br><br><input type="date"  style="float: right;width:180px"  name="travel_at" value="{{old('travel_at')}}" value="{{old('travel_at')}}"  class="bg-gray-200 text-sm;" >

</div>                            
   <div class="form-group flex items-center mb-2" style="margin-top:10px;">
                        <label for="way_of_travel" class="block w-60 font-bold"  style="margin-left:20px;text-align:right">طريقة السفر (اختياري):</label>
                        <select name="way_of_travel" id="way_of_travel" class="bg-gray-300 text-sm" >
                        <option value="" {{ old('') == "" ? "selected" : "" }}>----</option>
                        <option value="air" {{ old('way_of_travel') == "air" ? "selected" : "" }}>جوا</option>
                        <option value="bus" {{ old('way_of_travel') == "bus" ? "selected" : "" }}> باص</option>
                        <option value="car" {{ old('way_of_travel') == "car" ? "selected" : "" }}>سيارة خاصة </option>
                        </select>
                    </div>

                    <div class="form-group flex items-center mb-2" style="margin-top:10px;">
                  <label for="direction" class="block w-80 font-bold "  style="margin-left:20px;text-align:right;">السفر مع (اختياري):</label> 
                        <select name="provider_id" id="direction" class="bg-gray-300 text-sm" style="width:150px;">
                            <option value="0" {{ old('provider_id') == 0 ? "selected" : "" }}>اي شركة</option>
                            @foreach($providers as $provider)
                            <option value="{{$provider->id}}" {{ old('provider_id') == $provider->id ? "selected" : "" }}>{{$provider->name_company}} </option>

                            @endforeach
                        </select>
                    </div>
                     <div class="form-group flex items-center mb-2" style="margin-top:10px;">
<label for="direction" class=" w-60 font-bold " style="float: right;margin-right:-5px;text-align:right">تم تعرف على خدمة عبر(اختياري): </label>
<input type="checkbox" value="web"  id="know_by"   {{ old('know_by') == "web"? "checked" : "" }}  name="know_by">
    <label for="remember_me">الانترنت</label>
    <br>
    <input type="checkbox" value="friend"  {{ old('know_by') == "friend" ? "checked" : "" }} id="know_by" name="know_by">
    <label for="remember_me"  >  صديق</label>


</div>   


           
                    




<div class="form-group flex items-center mb-2" style="margin-top:10px;">
                  <label for="direction" class="block w-60 font-bold "  style="margin-left:20px;font-size:18px;">بيانات  المسوق (اختياري)</label> 
                  </div>
                
      

                  <div id='TextBoxesGrou'  >
                  
    <div id="TextBoxDi" style="margin-bottom:10px;margin-top:10px;float:right;text-align:right">
        <label for="direction" class=" w-60 font-bold "> الاسم  : </label><input type="text" id="textbox1" value="{{old('marketer_name')}}"  name="marketer_name" class="bg-gray-300 text-sm" class="bg-gray-300 text-sm" ><label for="direction" class=" w-60 font-bold "style="text-align:right;"> رقم جوال : </label><input type="number" id="marketer_phone" name="marketer_phone" oninput="javascript: if (this.value.length > 10) this.value = this.value.slice(0,10);" value="{{old('marketer_phone')}}" id="marketer_phone" class="bg-gray-300 text-sm" class="form-class" > 

    </div>
</div>

</div>  

<br>
<div style="float:right;text-align:right;">
<button type="submit" value="store " name="subm" class="btn btn-success "> حجز</button>

        <a class="btn btn-warning btn-close " href="">الغاء</a>

     <a class="btn btn-danger btn-close " href="{{ route('home') }}" > اغلاق </a>
     </div>
</div>






    

                </form>
                </div>
                </div>

    </div>



<script type="text/javascript">

    $('#city').change(function(){
    var cityID = $(this).val();    
    if(cityID){
        $.ajax({
           type:"GET",
           url:"{{url('pcrs_request/get-lab-list')}}?city_id="+cityID,
           success:function(res){               
            if(res){
                $("#lab_id").empty();
                $("#lab_id").append('<option>  </option>');
                length=res.labs.length;
                    for(i=0;i<length;i++){

                    $("#lab_id").append('<option value="'+res.labs[i].id+'" {{ old("lab_id") =='+res.labs[i].id+' ? "selected" : "" }} >'+res.labs[i].name+'</option>');
                }
                
           
            }else{
               $("#lab_id").empty();
            }
           }
        });
    }else{
        $("#lab_id").empty();
    }      
   });
</script>

           </body>