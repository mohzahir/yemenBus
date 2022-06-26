<div>
    <?php 
if($preseervation->currency=='sar'){
   $currency="ريال سعودي";}
   else{
   $currency="ريال يمني";}
 
 $provider=App\Provider::where('id',$preseervation->provider_id)->first();
$provider_name=$provider->name_company;

?>
 
            @if($preseervation->amount_type =='full')
<h2>  تم تأجيل الحجز بمبلغ {{$preseervation->amount}}{{$currency}} من مبلغ  {{$preseervation->amount}}{{$currency}} رقم الحجز {{ $preseervation->id}}  {{$provider_name}} من  {{$preseervation->from_city}}  الى  {{$preseervation->to_city}} </h2>
        <h2>   الى تاريخ {{ Carbon\Carbon::parse($preseervation->date)->format('Y-m-d')}}</h2> 
    @else
<h2>  تم تأجيل الحجز بمبلغ {{$preseervation->amount}}{{$currency}} من مبلغ  {{$preseervation->amount}}{{$currency}} رقم الحجز {{ $preseervation->id}}  {{$provider_name}} من  {{$preseervation->from_city}}  الى  {{$preseervation->to_city}} </h2>
        <h2>   الى تاريخ {{ Carbon\Carbon::parse($preseervation->date)->format('Y-m-d')}}</h2> 
    @endif
</div>