<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Marketer;
use App\Provider;
use App\Lab;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;

class ForgotPasswordPhoneController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */


   
    public function showLinkRequestForm(){
        
        return view('auth.passwords.phone')->with('user_type',request()->user_type);
        
    }
     public function sendPassword(Request $request){
         
                  if($request->user_type=='lab'){
 request()->validate([
                'phone'=>['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i','required'],



        ], [

            'phone.regex'=>'الرقم غير صحيح',
'phone.required_without'=>'يجب ادخال الرقم',

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


        $lab=Lab::where('phone',$phone)->first();
        
        if($lab){
            $pass=str_pad(rand(0,999999),6);
        
         $random =Hash::make($pass);
        $lab->password = $random;
     
      $body= $pass.' رقمك السري في اليمن باص ';

 $body.=' لا تقم باعطاءه لاي متصل ';  
 $body.=' رابط التحكم للوحه التحكم الخاصه بك ';
  $body.="https://www.dashboard.yemenbus.com/reset/redirect/".$lab->id;   
             $to=$phone;
              $this->sendSASMS($to,$body);
         
         
         $lab->save;
     //return   redirect()->route('signInMarketer')->with(['phone'=>$phone,'password'=>$pass]);
    

       return redirect()->route('auth.login.lab')->with(['url'=>request()->user_type,'success'=>'تم ارسال كلمه السر الى رقم جوالك']);
}else{
            return redirect()->back()->with(['error'=>'رقم جوال غير مسجل في النظام ']);

}






}
         
         
         
         
          request()->validate([
                'phone'=>['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i','required_without:y_phone','nullable'],

'y_phone'=>['regex:/^(009677|9677|\+9677|7)([0-9]{8})$/i','required_without:phone','nullable'],
           

        ], [

            'phone.regex'=>'الرقم غير صحيح',
            'phone.exists'=>'الرقم غير مسجل في النظام',
'phone.required_without'=>'يجب ادخال احد الرقمين',
'y_phone.regex'=>'الرقم غير صحيح',
'y_phone.required_without'=>'يجب ادخال احد الرقمين',

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
 $phoneProv="";
if($request->y_phone){
    $into=Str::substr($request->y_phone,0,1);
    
    if($into=='7'){
    $phoneP=Str::substr($request->y_phone,1,8);
      
    $phoneProv="9677".$phoneP;
   
}else{
    $phoneProv=$request->y_phone;
}
}

         if($request->user_type=='marketer'){
         
if($phone){
        $marketer=Marketer::where('phone',$phone)->first();
        
        if($marketer){
            $pass=str_pad(rand(0,999999),6);
        
         $random =Hash::make($pass);
        $marketer->password = $random;
     
      $body= $pass.' رقمك السري في اليمن باص ';

 $body.=' لا تقم باعطاءه لاي متصل ';  
 $body.=' رابط التحكم للوحه التحكم الخاصه بك ';
  $body.="https://www.dashboard.yemenbus.com/reset/redirect/".$marketer->code;   

         

         if($request->phone){
             $to=$phone;
              $this->sendSASMS($to, $body);
         }else{
             $to=$phoneProv;
              $this->sendYESMS($to, $body);
         }
         
         $marketer->save;
        
     //return   redirect()->route('signInMarketer')->with(['phone'=>$phone,'password'=>$pass]);
    

       return redirect()->route('auth.login.maketer')->with(['url'=>request()->user_type,'success'=>'تم ارسال كلمه السر الى رقم جوالك']);
}else{
            return redirect()->back()->with(['error'=>'رقم جوال غير مسجل في النظام ']);

}
}else{
    
     $marketer=Marketer::where('y_phone',$phoneProv)->first();
        
        if($marketer){
            $pass=str_pad(rand(0,999999),6);
         $random =Hash::make($pass);
        $marketer->password = $random;
               $body= $pass.' رقمك السري في اليمن باص ';

 $body.=' لا تقم باعطاءه لاي متصل ';  
 $body.=' رابط التحكم للوحه التحكم الخاصه بك ';
  $body.="https://www.dashboard.yemenbus.com/reset/redirect/".$marketer->code;   

         

         if($request->phone){
             $to=$phone;
              $this->sendSASMS($to, $body);
         }else{
             $to=$phoneProv;
              $this->sendYESMS($to, $body);
         }
         
         $marketer->save();
         

        
        return redirect()->route('auth.login.maketer')->with(['url'=>request()->user_type,'success'=>'تم ارسال كلمه السر الى رقم جوالك']);
}else{
            return redirect()->back()->with(['error'=>'رقم جوال غير مسجل في النظام ']);

}
}
         }else{
                    
if($phone){
        $provider=Provider::where('phone',$phone)->first();
        
        if($provider){
            $pass=str_pad(rand(0,999999),6);
         $random =Hash::make($pass);
        $provider->password = $random;
        $body= $pass.' رقمك السري في اليمن باص ';

 $body.=' لا تقم باعطاءه لاي متصل ';  
 $body.=' رابط التحكم للوحه التحكم الخاصه بك ';
  $body.="https://www.dashboard.yemenbus.com/reset/redirect/".$provider->id;   

          if($request->phone){
             $to=$phone;
              $this->sendSASMS($to, $body);
         }else{
             $to=$phoneProv;
              $this->sendYESMS($to, $body);
         }
         $provider->save();

        
        return redirect()->route('auth.login.provider')->with(['url'=>request()->user_type,'success'=>'تم ارسال كلمه السر الى رقم جوالك']);
}else{
            return redirect()->back()->with(['error'=>'رقم جوال غير مسجل في النظام ']);

}
}else{
    
     $provider=Provider::where('y_phone',$phoneProv)->first();
        
        if($provider){
            $pass=str_pad(rand(0,999999),6);
         $random =Hash::make($pass);
        $provider->password = $random;
       $body= $pass.' رقمك السري في اليمن باص ';

 $body.=' لا تقم باعطاءه لاي متصل ';  
 $body.=' رابط التحكم للوحه التحكم الخاصه بك ';
  $body.="https://www.dashboard.yemenbus.com/reset/redirect/".$provider->id;   

 if($request->phone){
             $to=$phone;
              $this->sendSASMS($to, $body);
         }else{
             $to=$phoneProv;
              $this->sendYESMS($to, $body);
         }         
         $provider->save();
         

        
        return redirect()->route('auth.login.provider')->with(['url'=>request()->user_type,'success'=>'تم ارسال كلمه السر الى رقم جوالك']);
}else{
            return redirect()->back()->with(['error'=>'رقم جوال غير مسجل في النظام ']);

}
} 
         }
    }
    
    public function signInMarketer($code)
{
    // Check if the URL is valid
  
 $marketer=Marketer::where('code',code)->first();
    // Authenticate the user
    Auth::guard('marketer')->login($marketer);

    // Redirect to homepage
    return redirect('/marketers/archive');
}
public function signInProvider($id)
{
    // Check if the URL is valid
  
 $provider=Provider::where('id',$id)->first();
 
    // Authenticate the user
    Auth::guard('provider')->login($provider);

    // Redirect to homepage
    return redirect('/provider/dashboard');
}
    
    public function signInLab($id)
{
    // Check if the URL is valid
  
 $lab=Lab::where('id',$id)->first();
 
    // Authenticate the user
    Auth::guard('lab')->login($lab);

    // Redirect to homepage
    return redirect('lab/index');
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
                'unicode' => 'Utf8',
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
             'unicode' => 'Utf8',

        ]
    ]);
}
}
