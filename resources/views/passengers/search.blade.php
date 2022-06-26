@extends('layouts.passenger')
@section('content')

@include('incs.headerFormTrip')

<div class="whole-wrap">
    <div class="container box_1170">
        <div class="row"> 
            <div class="col-6">
            </div>
        </div>

    </div>
</div>

<div class="whole-wrap">
    <div class="container box_1170">
        <div class="section-top-border">
            @if($tripDetails['from'] && $tripDetails['to']) 
                <h3 class="mb-30"> الرحلات من مدينة {{  $tripDetails['from'] }} الى مدينة {{  $tripDetails['to'] }} </h3>
                <span>عدد التذاكر - {{  $tripDetails['ticketNo'] }}  </span>
             @endif
             @if(!$tripDetails['from'] && !$tripDetails['to'] && $tripDetails['all'])
                 <h3> رحلات كل يوم </h3>
             @endif
             @if($tripDetails['from'] && !$tripDetails['to']) 
                <h3 class="mb-30"> الرحلات من مدينة {{  $tripDetails['from'] }} </h3>
                <span>عدد التذاكر - {{  $tripDetails['ticketNo'] }}  </span>
             @endif
             @if(!$tripDetails['from'] && $tripDetails['to']) 
                <h3 class="mb-30"> الرحلات الى مدينة {{  $tripDetails['to'] }} </h3>
                <span>عدد التذاكر - {{  $tripDetails['ticketNo'] }}  </span>
             @endif
             <div class="progress-table-wrap">
                @include('incs.searchedTrips', ['trips' =>$searchedTrips ,
                                                //'currency' => $currency, 
                                                'ticketNo' => $tripDetails['ticketNo']])
            </div>
        </div>

    </div>
</div>

@endsection