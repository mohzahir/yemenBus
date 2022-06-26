<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
  protected $fillable = [
        'day','old_ticket_price','trip_at','finish_at','discount_percentage','available_tickets',
        'winner_id','direction','starting_place','finishing_place','sponsor',
        'sponsor_banner','sponsor_url','transportation_company','transportation_company_banner','transportation_company_url'
        ,'status','booking_link','result_phone','terms'
    ];
  

     public function tripDate()
    {
        //Carbon::setlocale('ar');
        $d=$this->day;
        $day="";
        switch ($d) {
            case '0':
                $day='الاحد';  
            break;
            case '1':
                $day='الاثنين';  
            break;
            case '2':
                $day='الثلاثاء';  
            break;
            case '3':
                $day='الاربعاء';  
            break;
            case '4':
                $day='الخميس';  
            break;
            case '5':
                $day='الجمعة';  
            break;
            case '6':
                $day='السبت';  
            break;
            
            default:
                # code...
                break;
        }
        $date=Carbon::createFromFormat('Y-m-d H:i',$this->trip_at)->format('Y-m-d');

        $tripTime="".$day." الموافق  ".$date."";


        return $tripTime;
    }
       public function clockTime(){
            $tripclock=Carbon::createFromFormat('Y-m-d H:i',$this->trip_at)->format('H:i');
                   return $tripclock;

       }

    
   

   public function finishDate()
    {
       Carbon::setlocale('ar');
       $d=$this->day;
       $day="";
       switch ($d) {
        case ' ':
            $day='';  
        break;
           case '0':
               $day='الاحد';  
           break;
           case '1':
               $day='الاثنين';  
           break;
           case '2':
               $day='الثلاثاء';  
           break;
           case '3':
               $day='الاربعاء';  
           break;
           case '4':
               $day='الخميس';  
           break;
           case '5':
               $day='الجمعة';  
           break;
           case '6':
               $day='السبت';  
           break;
           
           
       }
       $finishTime="".$day." الموافق ".$this->finish_at."";
      

        return $finishTime;
    }

    public function getTripAtAttribute($value)
    {
        
        return Carbon::parse($value)->tz('Asia/Aden')->format('Y-m-d H:i');
        
    }

    public function getFinishAtAttribute($value)
    {
        return Carbon::parse($value)->tz('Asia/Aden')->format('Y-m-d H:i');
    }

    public function getResultPhoneCountryCodeAttribute() {
        return substr($this->result_phone, 0, 3);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function winner() {
        return $this->belongsTo(Participant::class, 'winner_id');
    }

    public function directionText() {
        switch ($this->direction) {
            case 'saudia_yemen':
              return 'من السعودية إلى اليمن';
              break;
            case 'yemen_saudia':
              return 'من اليمن إلى السعودية';
              break;
            case 'in_yemen':
              return 'داخل المدن اليمنية';
              break;
            default:
              return '';
          } 
    }
}
