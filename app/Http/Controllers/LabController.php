<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Pcr;
use App\Lab;
use App\City;
use Carbon\Carbon;
use Str;
use App\Provider;
use Illuminate\Support\Facades\Hash;

class LabController extends Controller
{
    public function index(){
        
        return view('lab.index');
    }
    public function setting(){
        $lab=Auth::guard('lab')->user();
        $cities=City::all();
        return view('lab.setting')->with(['lab'=>$lab,'cities'=>$cities]);
    }
    
         public function UpdateAccountInfo (Request $request){
       
        request()->validate([
                'phone'=>['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i','required'],


        ], [

            'phone.regex'=>'الرقم غير صحيح',
'phone.required'=>'يجب ادخال الرقم',

        ]);
        $phone="";
if($request->phone){
    $into=Str::substr($request->phone,0,2);
    
    if($into=='05'){
    $phoneM=Str::substr($request->phone,2,8);
      
    $phone="9665".$phoneM;
   
}else{
    $phone=$request->phone;
}
}

        
 
        $id=auth()->guard('lab')->user()->id;
        
$lab =Lab::where('id',$id)->first();

$lab->name=$request['name'];
$lab->city_id=$request['city_id'];
        if($request['password']){$lab->password= Hash::make($request['password']);}

          $lab->position=$request['position'];
$lab->w_clock=$request['w_clock'];
        if($request->phone){$lab->phone=$phone;}

           
           $lab->save();
         
        
        
        

$lab->save();
        
        return redirect()->route('dashboard.lab.setting')->with('success', 'تم تعديل بيانات الحساب بنجاح');
    }
public function takeForm($id){
                $pcr=Pcr::where(['id'=>$id])->first();
        return view('lab.take')->with(['pcr'=>$pcr]);
}


public function take($id){
            $pcr=Pcr::where(['id'=>$id])->first();
$pcr->take=1;
$pcr->price=$request->price;
$pcr->note_take=$request->note_take;
$pcr->price_no=$request->price_no;
$pcr->save();
                    
    return redirect()->route('dashboard.lab.pcrsSuspend')->with('success','تم أخذ العينة بنجاح وتوجيه الطلب الى فحوصات قيد المتابعة بنجاح'); 

}
    
    
    
    
    
        public function pcrs(){
        $lid=Auth::guard('lab')->user()->id;
        $pcrs=Pcr::where(['lab_id'=>$lid,'take'=>0])->orderby('id','desc')->paginate(10);

return view('lab.pcrs')->with('pcrs',$pcrs)  ;  }



  public function checked(Request $request,$id){
        $pcr=Pcr::where(['id'=>$id])->first();
        
       /*$pcr->day= Carbon::createFromFormat('Y-m-d H:i', request('date_at'), 'Asia/Aden')->dayOfWeek;

        $date = Carbon::createFromFormat('Y-m-d H:i', request('date_at'), 'Asia/Aden');
        if($date<Carbon::now()){
          return redirect()->back()->with('error','تم ادخال تاريخ من الماضي ');

        }
        $pcr->date_at = $date->tz('UTC')->format('Y-m-d H:i');
               
               $date=$pcr->date();
               $clock=$pcr->clock();
               $day=$pcr->day();*/
        if($request->hasFile('done_img')) {
                  $image=$request->file('done_img');
                        $destinationPath = public_path('/images/pcrs/pcrs_checked/');
                        $filename = $image->getClientOriginalName();
                        $image->move($destinationPath,$filename);
                                     $pcr->done_img = $filename;

                    }
        
        $pcr->note_check=$request->note_check;
            $pcr->status=1;
              
        if($request->action=='send'){
           

if($request->done_img){
        $img="https://dashboard.yemenbus.com/public/images/pcrs/pcrs_checked/".$pcr->done_img;
        
  $msg=' نتائج فحص كورنا لك . سفر سعيد رابط شهاده الفحص '.$img .' بامكانك مشاركته مع الجهات المهتمة لأغراض السفر  ';
                            if($pcr->phone){
                        $p=$pcr->phone;
                         $this->sendSASMS($phone,$msg);
                    }else{
                        $p=$pcr->y_phone;
                         $this->sendYESMS($y_phone,$msg);

                    }
                    $pcr->save();
                    
                    return redirect()->route('dashboard.lab.pcrsSuspend')->with('success','تم اصدار نتيجه الفحص بنجاح سيتم ارسل رسالة لصاحب الرقم '.$p)  ; 
}else{$pcr->save();
return redirect()->route('dashboard.lab.pcrsSuspend')->with('success','تم اصدار نتيجه الفحص بنجاح '); 
}
}else{
            
$pcr->save();
return redirect()->route('dashboard.lab.pcrsSuspend')->with('success','تم اصدار نتيجه الفحص بنجاح '); 

}   
  }
  
    public function checkedForm($id){
                $pcr=Pcr::where(['id'=>$id])->first();
   return view('lab.check')->with('pcr',$pcr);

    }
    
    public function formShared($id){
                $pcr=Pcr::where(['id'=>$id])->first();
   return view('lab.share')->with('pcr',$pcr);

    }


public function share(Request $request ,$id){
   
       
       request()->validate([
                'phone'=>['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i','required_without:y_phone','nullable'],

'y_phone'=>['regex:/^(009677|9677|\+9677|7)([0-9]{8})$/i','required_without:phone','nullable'],
           
           

        ], [

            'phone.regex'=>'الرقم غير صحيح',
'phone.required_without'=>'يجب ادخال احد الرقمين',
'y_phone.regex'=>'الرقم غير صحيح',
'y_phone.required_without'=>'يجب ادخال احد الرقمين',

        ]);

        
        
                 $phone="";
if($request->phone){
    $into=Str::substr($request->phone,0,2);
    
    if($into=='05'){
    $phoneP=Str::substr($request->phone,2,8);
      
    $phone="9665".$phoneP;
   
}else{
    $phone=$request->phone;
}
}

  $y_phone="";
if($request->y_phone){
    $into=Str::substr($request->y_phone,0,1);
    
    if($into=='7'){
    $phonef=Str::substr($request->y_phone,1,8);
      
    $y_phone="9677".$phonef;
  
}else{
    $y_phone=$request->y_phone;
}
}
  
        if($request->phone &&$request->y_phone){return redirect()->back()->with('error','يرجى ادخال احد الرقمين ليس كلاهما');}

        $pcr=Pcr::where(['id'=>$id])->first();
        $pcr->shared=1;
        $img="https://dashboard.yemenbus.com/public/images/pcrs/pcrs_checked/".$pcr->done_img;
        $msg=' نتيجه فحص كورنا للمسافر '.$pcr->name.'  رابط شهادة الفحص '.$img;

                   
                    if($request->phone){
                        $p=$phone;
                         $this->sendSASMS($phone,$msg);
                    }else{
                        $p=$y_phone;
                        $this->sendYESMS($y_phone,$msg);

                    }

return redirect()->route('dashboard.lab.pcrsSuspend')->with('success','تم مشاركة نتيجه الفحص بنجاح مع صاحب رقم  '.$p)  ; 

    }


public function dateTime($id){
   $pcr = Pcr::where('id', $id)->firstOrFail();
   return view('lab.date')->with('id',$id);
        }
        public function checkedDate(Request $request,$id){
                           $pcr = Pcr::where('id', $id)->firstOrFail();

                   $pcr->day= Carbon::createFromFormat('Y-m-d H:i', request('date_at'), 'Asia/Aden')->dayOfWeek;

        $date = Carbon::createFromFormat('Y-m-d H:i', request('date_at'), 'Asia/Aden');
        if($date<Carbon::now()){
          return redirect()->back()->with('error','تم ادخال تاريخ من الماضي ');

        }
        $pcr->date_at = $date->tz('UTC')->format('Y-m-d H:i');
               $pcr->save();
               $date=$pcr->date();
               $clock=$pcr->clock();
               $day=$pcr->day();
               $lab=Lab::where('id',$pcr->lab_id)->first();
               $lab_name=$lab->name;
               
               
                    $msg=' تم تحديد موعد لك لاخذ عينة الفحص كورنا لغرض السفر. الساعة  '.$clock.' تاريخ'.$date.'يوم'.$day.'بمختبر'.$lab_name;
                    if($pcr->phone){
                        $p=$pcr->phone;
                        $this->sendSASMS($phone,$msg);
                    }else{
                        $p=$pcr->y_phone;
                        $this->sendYESMS($y_phone,$msg);

                    }

                  return redirect()->route('dashboard.lab.pcrs')->with('success','تم تحديد لموعد بنجاح وارسال رسالة للمستفيد صاحب الرقم  '.$p);

               

        }

        
        
        
                public function pcrsSuspend(){

        $lid=Auth::guard('lab')->user()->id;
        $pcrs=Pcr::where(['lab_id'=>$lid])->where('take',1)->orderby('id','desc')->paginate(10);

return view('lab.pcrs_suspend')->with('pcrs',$pcrs)  ; 
}



        public function sms($id=null)
    {
        
        if($id){
        $pcr= Pcr::where('id',$id)->first();
        return view('lab.sms')->with(['pcr'=> $pcr]);
    }  
    $pcr=null;     
     return view('lab.sms')->with(['pcr'=> $pcr]);


}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeSms(Request $request)
    {    request()->validate([
        'message'=>['required'],
        'phone'=>['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i','required'],
        ], [

            'phone.regex'=>'الرقم غير صحيح',
            'phone.required'=>'يجب ادخال الرقم',


        'message.required' => ' يرجى ادخال  محتوى الرساله ',
    ]);
        
        
                 $phone="";
if($request->phone){
    $into=Str::substr($request->phone,0,2);
    
    if($into=='05'){
    $phoneP=Str::substr($request->phone,2,8);
      
    $phone="9665".$phoneP;
   
}else{
    $phone=$request->phone;
}
}

  $y_phone="";
if($request->y_phone){
    $into=Str::substr($request->y_phone,0,1);
    
    if($into=='7'){
    $phonef=Str::substr($request->y_phone,1,8);
      
    $y_phone="9677".$phonef;
  
}else{
    $y_phone=$request->y_phone;
}
}
  
        
        
        $body=$request->message;
                

        if($request->phone){
            $to=$phone;
        $this->sendSASMS($to, $body);
        }else{
            $to=$y_phone;
                     $this->sendYESMS($to, $body);

        }

                if($phone){$p=$phone;}else{$p=$y_phone;}


            return redirect()->route('dashboard.lab.pcrs')->with('success','تم ارسال رسال الى صاحب الرقم '.$p);
        

    }
    function sendSASMS($to, $body) {
        $client = new \GuzzleHttp\Client();
        $client->get('http://www.4jawaly.net/api/sendsms.php', [
            'query' => [
                'username' => env('SAUDI_SMS_username'),
                'password' => env('SAUDI_SMS_password'),
                'sender'  => env('SAUDI_SMS_sender'),
                'numbers' => $to,
                'message' => $body,
                'unicode' => 'E',
            ]
        ]);
    }
    function sendYESMS($to, $body) {
    $client = new \GuzzleHttp\Client();
    $client->get('http://52.36.50.145:8080/MainServlet', [
        'query' => [
            'orgName' => env('YEMEN_SMS_orgName'),
            'userName' => env('YEMEN_SMS_userName'),
            'password' => env('YEMEN_SMS_password'),
            'mobileNo' => $to,
            'text' => $body,
            'coding' => 2,
        ]
    ]);
}

    
  
}
    
    
    












