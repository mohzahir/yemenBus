<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pcr;
use Illuminate\Support\Str;
use App\Provider;
use App\Lab;
class AdminPcrsController extends Controller
{
        public function pcrs($id=null){
           
            $pcrs=Pcr::orderby('id','desc')->paginate(30);


return view('dashboard.labs.pcrs.index')->with(['pcrs'=>$pcrs])  ; 
}
        public function sms($id)
    {
        
    
        $pcr= Pcr::where('id',$id)->first();
     return view('dashboard.labs.pcrs.sms')->with(['pcr'=> $pcr]);


}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function smsSend (Request $request)
    {   request()->validate([
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
        
        $body=$request->message;
                

        if($request->phone){
            $to=$phone;
       $this->sendSASMS($to, $body);
        }else{
            $to=$y_phone;
                     $this->sendYESMS($to, $body);

        }

                if($phone){$p=$phone;}else{$p=$y_phone;}


            return redirect()->route('admin.pcrs')->with('success','تم ارسال رسال الى صاحب الرقم '.$p);
        

    }
   public function formShared($id){
                $pcr=Pcr::where(['id'=>$id])->first();
   return view('dashboard.labs.pcrs.share')->with('pcr',$pcr);

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


return redirect()->route('admin.pcrs')->with('success','تم مشاركة نتيجه الفحص بنجاح مع صاحب رقم  '.$p)  ; 

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
