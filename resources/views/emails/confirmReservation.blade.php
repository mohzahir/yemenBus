
<div>
    <div>
    <?php 
if($reseervation->currency=='sar'){
   $currency="ريال سعودي";}
   else{
   $currency="ريال يمني";}

 $provider=App\Provider::where('id',$reseervation->provider_id)->first();
$provider_name=$provider->name_company;


?>
 
            @if($reseervation->amount_type =='full')
<h2>  تم تاكيد الحجز بمبلغ {{$reseervation->amount}}{{$currency}} من مبلغ  {{$reseervation->amount}}{{$currency}} رقم الحجز {{ $reseervation->id}}  {{$provider_name}} من  {{$reseervation->from_city}}  الى  {{$reseervation->to_city}} </h2>
        <h2>   في تاريخ {{ Carbon\Carbon::parse($reseervation->date)->format('Y-m-d')}}</h2> 
    @else
<h2>  تم تاكيد الحجز بمبلغ {{$reseervation->amount_deposit}}{{$currency}} من مبلغ  {{$reseervation->amount}}{{$currency}} رقم الحجز {{ $reseervation->id}}  {{$provider_name}} من  {{$reseervation->from_city}}  الى  {{$reseervation->to_city}} </h2>
        <h2>   في تاريخ {{ Carbon\Carbon::parse($reseervation->date)->format('Y-m-d')}}</h2> 
    @endif
</div>