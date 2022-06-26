<div>


    <?php 
if($creseervation->currency=='sar'){
   $currency="ريال سعودي";}
   else{
   $currency="ريال يمني";}
 
 $provider=App\Provider::where('id',$creseervation->provider_id)->first();
$provider_name=$provider->name_company;

?>
 
            @if($creseervation->amount_type =='full')
<h2>  تم الغاء الحجز بمبلغ {{$creseervation->amount}}{{$currency}} من مبلغ  {{$creseervation->amount}}{{$currency}} رقم الحجز {{ $creseervation->id}}  {{$provider_name}} من  {{$creseervation->from_city}}  الى  {{$creseervation->to_city}} </h2>
        <h2>   في تاريخ {{ Carbon\Carbon::parse($creseervation->date)->format('Y-m-d')}}</h2> 
    @else
    <h2>  تم الغاء الحجز بمبلغ {{$creseervation->amount_deposit}}{{$currency}} من مبلغ  {{$creseervation->amount}}{{$currency}} رقم الحجز {{ $creseervation->id}}  {{$provider_name}} من  {{$creseervation->from_city}}  الى  {{$creseervation->to_city}} </h2>
        <h2>   في تاريخ {{ Carbon\Carbon::parse($creseervation->date)->format('Y-m-d')}}</h2> 
    @endif
</div>