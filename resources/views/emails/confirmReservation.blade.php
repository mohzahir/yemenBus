
<div>
    <div>
    <?php 
if($reseervation->trip->currency=='rs'){
   $currency="ريال سعودي";}
   else{
   $currency="ريال يمني";}

 $provider=App\Provider::where('id',$reseervation->trip->provider_id)->first();
$provider_name=$provider->name_company;


?>
 
<h2>  تم تاكيد الحجز بمبلغ {{$reseervation->paid}}{{$currency}} من مبلغ  {{$reseervation->total_price}}{{$currency}} رقم الحجز {{ $reseervation->id}}  {{$provider_name}} من  {{$reseervation->ride_place ?? $reseervation->trip->takeoff_city->name}}  الى  {{$reseervation->drop_place ?? $reseervation->trip->arrival_city->name}} </h2>
        <h2>   في تاريخ {{ Carbon\Carbon::parse($reseervation->date)->format('Y-m-d')}}</h2> 
    
</div>
</div>
