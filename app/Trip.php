<?php

namespace App;

use App\City;
use App\Provider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Trip extends Model
{
  protected $fillable = [
    'direcation',
    'provider_id',
    'sub_service_id',
    'lines_trip',
    'takeoff_city_id',
    'arrival_city_id',
    'day',
    'coming_time',
    'leave_time',
    'weight',
    'no_ticket',
    'note',
    'price',
    'title',
    'deposit_price',
    'created_at',
    'status'
  ];

  protected  $dates = ['to_date,from_date'];

  public function dayTr()
  {

    $days[] = explode(',', $this->day);
    $da = array();
    foreach ($days as $d) {
      /* switch ($d) {
                case 'all':
            array_push($days,'الكل');

                  break;
            case 'sat':
            array_push($days,'السبت');

                  break;
                case 'sun':
            array_push($days,'الاحد');

                break;
                case 'mon':
            array_push($days,'الاتنين');

                break;
                case 'tue':
              array_push($days,'الثلاثاء');

                break;
              case 'wed':
              array_push($days,'الاربعاء');

                break;
                case 'thu':
                array_push($days,'الخميس');
                break;
                case 'fri':
              array_push($days,'الجمعة');
                break;
            
            
              }*/

      return $d;
    }

    return $days;
  }

  public static function getTrips($direction, $slug)
  {

    // return self::select('trips.*')->selectRaw('(select city.name from city where city.id = trips.takeoff_city_id) as depCity ')->selectRaw('(select city.name from city where city.id = trips.arrival_city_id) as comCity ')->selectRaw('(select providers.name_company from providers where providers.id = provider_id) as provider ')->where('direcation', $direction)
    //   ->where('providers.service_id', '=', 1)->orderBy('id', 'desc')
    //   ->limit(7)->get();
    // dd($direction);
    return self::select('trips.*', 'providers.name_company as provider', 'providers.service_id')
      ->selectRaw('(select city.name from city where city.id = trips.takeoff_city_id) as depCity ')
      ->selectRaw('(select city.name from city where city.id = trips.arrival_city_id) as comCity ')
      ->join('providers', 'trips.provider_id', '=', 'providers.id')
      ->join('services', 'providers.service_id', '=', 'services.id')
      ->where('direcation', $direction)
      ->where('services.slug', '=', $slug)
      ->orderBy('trips.id', 'desc')
      ->limit(7)->get();
  }
  public static function getTrips_car($direction)
  {
    return self::select('trips.*')->selectRaw('(select city.name from city where city.id = trips.from) as depCity ')->selectRaw('(select city.name from city where city.id = trips.to) as comCity ')->selectRaw('(select providers.name_company from providers where providers.id = provider_id) as provider ')->where('direcation', $direction)
      ->where('service_id', '2')
      ->orderBy('id', 'desc')
      ->limit(7)->get();
  }
  public static function getTrips_msg($direction)
  {
    return self::select('trips.*')->selectRaw('(select city.name from city where city.id = trips.from) as depCity ')->selectRaw('(select city.name from city where city.id = trips.to) as comCity ')->selectRaw('(select providers.name_company    from providers where providers.id = provider_id) as provider ')->selectRaw('(select providers.msg    from providers where providers.id = provider_id) as msg ')->where('direcation', $direction)
      ->where('service_id', 4)
      ->orderBy('id', 'desc')
      ->limit(7)->get();
  }
  public static function getTrips_haj($direction)
  {
    return self::select('trips.*')->selectRaw('(select city.name from city where city.id = trips.from) as depCity ')->selectRaw('(select city.name from city where city.id = trips.to) as comCity ')->selectRaw('(select providers.name_company    from providers where providers.id = provider_id) as provider ')->selectRaw('(select providers.haj    from providers where providers.id = provider_id) as haj ')->where('direcation', $direction)
      ->where('service_id', 3)
      ->orderBy('id', 'desc')
      ->limit(7)->get();
  }
  public static function getTripDetails($id)
  {
    return self::select('trips.*')
      ->selectRaw('(select city.name from city where city.id = trips.takeoff_city_id) as depCity ')
      ->selectRaw('(select city.name from city where city.id = trips.arrival_city_id) as comCity ')
      ->selectRaw('(select providers.name_company from providers where providers.id = provider_id) as provider ')
      ->where('id', $id)->first();
  }

  public static function getCurrency($cityId)
  {
    $city = City::where('id', $cityId)->first();
    $country = $city ? $city->country : '';
    return  $currency = $country == 1 ? ' ر.س' : 'ريال يمني';
  }
  public static function getCityName($cityId)
  {
    $city = City::where('id', $cityId)->first();
    return $city ? $city->name : '';
  }
  public static function getCitys()
  {
    $citys = City::all();
    return $citys ? $citys->name : '';
  }

  public static function getProviderName($id)
  {
    return Provider::where('id', $id)->first()->name_company;
  }

  public static function getCityCountry($cityId)
  {
    $city = City::where('id', $cityId)->first();
    return $city ? $city->country : '';
  }

  public function orders()
  {
    return $this->hasMany(TripOrder::class, 'trip_id', 'id');
  }

  public static function getDay($tday)
  {
    switch ($tday) {
      case 'sat':
        $tday = "السبت";
        break;
      case 'sun':
        $tday = "الاحد";
        break;
      case 'mon':
        $tday = "الاثنين";
        break;
      case 'tue':
        $tday = "الثلاثاء";
        break;
      case 'wed':
        $tday = "الاربعاء";
        break;
      case 'thu':
        $tday = "الخميس";
        break;
      case 'fri':
        $tday = "الجمعة";
        break;

      default:
        break;
    }
    return $tday;
  }

  public static function replaceDays($days)
  {
    if ($days == 'all') {
      return 'كل يوم';
    } else {
      $days_array = explode(",", $days);
      $days_ar = [];
      foreach ($days_array as $day) {
        array_push($days_ar, self::getDay($day));
      }
      return implode(' , ', $days_ar);
    } //end else



  }

  public function provider()
  {
    return $this->belongsTo(Provider::class, 'provider_id');
  }

  public function takeoff_city()
  {
    return $this->belongsTo(City::class, 'takeoff_city_id');
  }

  public function arrival_city()
  {
    return $this->belongsTo(City::class, 'arrival_city_id');
  }
  public function sub_service()
  {
    return $this->belongsTo(SubService::class, 'sub_service_id');
  }
}
