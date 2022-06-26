@extends('layouts.passenger')
@section('content')
@section('css')
<style>
    :root {
  --surface-color: #fff;
  --curve: 40;
}
.cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
  margin: 4rem 5vw;
  padding: 0;
  list-style-type: none;
}

.card {
  position: relative;
  display: block;
  height: 100%;  
  border-radius: calc(var(--curve) * 1px);
  overflow: hidden;
  text-decoration: none;
}

.card__image {      
  width: 100%;
  height: auto;
}

.card__overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 1;      
  border-radius: calc(var(--curve) * 1px);    
  background-color: var(--surface-color);      
  transform: translateY(100%);
  transition: .2s ease-in-out;
}

.card:hover .card__overlay {
  transform: translateY(0);
}

.card__header {
  position: relative;
  display: flex;
  align-items: center;
  gap: 2em;
  padding: 2em;
  border-radius: calc(var(--curve) * 1px) 0 0 0;    
  background-color: var(--surface-color);
  transform: translateY(-100%);
  transition: .2s ease-in-out;
}

.card__arc {
  width: 80px;
  height: 80px;
  position: absolute;
  bottom: 100%;
  right: 0;      
  z-index: 1;
}

.card__arc path {
  fill: var(--surface-color);
  d: path("M 40 80 c 22 0 40 -22 40 -40 v 40 Z");
}       

.card:hover .card__header {
  transform: translateY(0);
}

.card__thumb {
  flex-shrink: 0;
  width: 50px;
  height: 50px;      
  border-radius: 50%;      
}

.card__title {
  font-size: 1.3em;
    margin: 0 0 0.3em;
    color: #144065;
}

.card__tagline {
  display: block;
  margin: 1em 0;
  font-family: "MockFlowFont";  
  font-size: .8em; 
  color: #D7BDCA;  
}

.card__status {
  font-size: .8em;
  color: #D7BDCA;
}

.card__description {
  padding: 0 2em 2em;
  margin: 0;
  color: #1a1717;
  font-family: "MockFlowFont";   
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 3;
  overflow: hidden;
}    
</style>
<script src="{{asset('js/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="{{asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.css')}}">
@endsection

@include('incs.headerFormTrip')

<ul class="cards">
  @foreach ($services as $service)
  <li>
    <a href="{{url('passengers/' . $service->slug)}}" class="card">
      <img src="{{$service->img}}" class="card__image" alt="" />
      <div class="card__overlay">
        <div class="card__header">
          <svg class="card__arc" xmlns="http://www.w3.org/2000/svg"><path /></svg>                     
          <img class="card__thumb" src="{{$service->img}}" alt="" />
          <div class="card__header-text">
            <h3 class="card__title">{{$service->name}}</h3>            
            <!-- <span class="card__status">1 hour ago</span> -->
          </div>
        </div>
        <p class="card__description">{{$service->descr}}</p>
      </div>
    </a>      
  </li>
  @endforeach
  
  {{-- <li>
    <a href="{{url('passengers/car')}}" class="card">
      <img src="passenger-assets/img/hero/car.jpg" class="card__image" alt="" />
      <div class="card__overlay">        
        <div class="card__header">
          <svg class="card__arc" xmlns="http://www.w3.org/2000/svg"><path /></svg>                 
          <img class="card__thumb" src="passenger-assets/img/hero/car.jpg" alt="" />
          <div class="card__header-text">
            <h3 class="card__title">نقل الركاب عالماشي</h3>
            <!-- <span class="card__status">3 hours ago</span> -->
          </div>
        </div>
        <p class="card__description">استكشف جميع الرحلات عن طريق سيارة خاصة</p>
      </div>
    </a>
  </li>
  <li>
    <a href="{{url('passengers/haj')}}" class="card">
      <img src="passenger-assets/img/hero/haj.jpg" class="card__image" alt="" />
      <div class="card__overlay">
        <div class="card__header">
          <svg class="card__arc" xmlns="http://www.w3.org/2000/svg"><path /></svg>                     
          <img class="card__thumb" src="passenger-assets/img/hero/haj.jpg" alt="" />
          <div class="card__header-text">
            <h3 class="card__title">رحلات الحج والعمرة</h3>
            <!-- <span class="card__tagline">Lorem ipsum dolor sit amet consectetur</span>             -->
            <!-- <span class="card__status">1 hour ago</span> -->
          </div>
        </div>
        <p class="card__description">استكشف جميع الرحلات الخاصة بالحج والعمرة</p>
      </div>
    </a>
  </li>
  <li>
    <a href="{{url('passengers/msg')}}" class="card">
      <img src="passenger-assets/img/hero/bus1-old.jpg" class="card__image" alt="" />
      <div class="card__overlay">
        <div class="card__header">
          <svg class="card__arc" xmlns="http://www.w3.org/2000/svg"><path /></svg>                     
          <img class="card__thumb" src="passenger-assets/img/hero/bus1-old.jpg" alt="" />
          <div class="card__header-text">
            <h3 class="card__title">مرسول اليمن لنقل الرسائل والبضائع</h3>
            <!-- <span class="card__tagline">Lorem ipsum dolor sit amet consectetur</span>             -->
            <!-- <span class="card__status">1 hour ago</span> -->
          </div>
        </div>
        <p class="card__description">استكشف جميع الرحلات الخاصة بنقل البضائع</p>
      </div>
    </a>
  </li> --}}
</ul>

@endsection

@section('js')

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script  src="{{asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>


    <script>
    
jQuery(document).ready(function(){

   /* $('.tripDate').datetimepicker({
        useCurrent: false,
                stepping: 60,
                format: 'mm-dd',
                timeZone: 'Asia/Aden',
            });
   */
    
  });
</script>
@endsection