<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pcr extends Model
{
    protected $table ='pcrs';
    protected $fillable = [
        'id','way_of_travel','shared','take','note_take','note_check','price','price_no','time_take','travel_at','	know_by','marketer_name','marketer_phone','done_img','city','day','date_at','lab_id ','provider_id','name','surname','passport_no','passport_image','status','y_phone','phone'
    ];
    public $timestamps = false;

    public function getDateAtAttribute($value)
    {
        
        return Carbon::parse($value)->tz('Asia/Aden')->format('Y-m-d H:i');
        
    }

    
    public function date()
    {
    $date=Carbon::createFromFormat('Y-m-d H:i',$this->date_at)->format('m-d');
        return $date;

   
    }
    public function day()
    {
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
        
   return $day;
    
    }
    public function clock()
    {
        
  $clock=Carbon::createFromFormat('Y-m-d H:i',$this->date_at)->format('H:i');
        return $clock;
   
    
    }
    public function dateAdmin()
    {
        if($this->date_at){
    $date=$this->date();
    $day=$this->day();
    $clock=$this->clock();
    
    $msg=' تم تحديد الموعد يوم '.$day.' تاريخ '.$date.' الساعة '.$clock;
        return $msg;
}else{
    $msg=' لم يتم تحديد موعد ';
        return $msg;
}
   
    }

}
