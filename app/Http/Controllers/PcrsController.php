<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lab;
use App\City;
use App\Provider;
use DB;
use App\Pcr;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Str;

class PcrsController extends Controller
{
    public function create()
    {
        $providers=Provider::all();
        $cities=City::all();
        return view('pcrs_request')->with(['providers'=>$providers,'cities'=>$cities]);
       
    
        
    }
    
    public function add(Request $request)
    {
       /*  request()->validate([
            'phones'=>['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i','required'],
            'marketer_phone'=>['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i'],


    ], [

        'phones.regex'=>'الرقم غير صحيح',
        'marketer_phone.regex'=>'رقم المسوق غير صحيح',
'phones.required'=>'يجب   ادخال الرقم ',
    ]);
    if($request->phone){
        $into=Str::substr($request->phone,0,2);
        
        if($into=='05'){
        $phoneP=Str::substr($request->phone,2,8);
          
        $phone="9665".$phoneP;
       
    }else{
        $phone=$request->phone;
    }
    }
    $phoneM="";
    if($request->marketer_phone){
        $into=Str::substr($request->marketer_phone,0,2);
        
        if($into=='05'){
        $phoneP=Str::substr($request->marketer_phone,2,8);
          
        $phoneM="9665".$phoneP;
       
    }else{
        $phoneM=$request->marketer_phone;
    }
    }
    

        $pcrs=new Pcr();
        $pcrs->way_of_travel=$request->way_of_travel;
        $pcrs->lab_id=$request->lab_id;
        $pcrs->provider_id=$request->provider_id;
        $pcrs->city_id=$request->city_id;
        $pcrs->time_take=$request->time_take;
        $pcrs->travel_at=$request->travel_at;
        $pcrs->know_by=$request->know_by;
        $pcrs->marketer_name=$request->marketer_name;
        $pcrs->marketer_phone=$phoneM;

        $pcrs->phone=$phone;
        
        //$name = implode(',',$request['name']);
        foreach ($request->names as $name){
           
        
        $name=$request['name'];
        $surname = $request['surname'];
        $passport_no =$request['passport_no'];
 
                if($request->hasFile('passport_images')) {
                  $image=$request->file('passport_images');
                        $destinationPath = public_path('/images/pcrs/');
                        $filename = $image->getClientOriginalName();
                        $image->move($destinationPath,$filename);
                                     $pcrs->passport_image = $filename;

                    }

                    $pcrs->name=$name;
                    $pcrs->surname=$surname;
                    $pcrs->passport_no=$passport_no;
                    $pcrs->save();
                    $lab=Lab::where('id',$pcrs->lab_id)->first();
                    $lab_name=$lab->name;
                    $lab_link=$lab->position;
                    $lab_phone=$lab->phone;
  $msg='تم طلب حجز موعد لفحص كورونا بنجاح بمختبر'.$lab_name.' الموقع على الخريطة '.$lab_link.' رقم جوال '.$lab_phone.'سوف يصلك تقرير الفحص بامكانك مشاركته مع الجهات المهتمة لأغراض السفر  ';
                    if($request->phone){
                        $p=$phone;
                        sendSASMS($phone,$msg);
                    }
       
    
        $providers=Provider::all();
        $cities=City::all();
        return redirect()->back()->with(['message'=>' تم حجز لفحص كرونا لصاحب رقم '.$p.'سيتم ارسال رساله لتحديد الموعد .بامكانك حجز فحص للاشخاص اخرين او رجوع لصفحه الرئيسية'])->with('type','success');
       
    
        
    */}
    
    

    public function getLabList(Request $request)
    {
       
        $labs = DB::table('labs')->select("name","id")->where("city_id",$request->city_id)->orderby('priority')->get();
        return response()->json(['labs'=>$labs]);
    }
    public function store(Request $request)
    {
        
        $size=count($request->names);
     /*dd($request);
       request()->validate([
            'phones'=>['array','required'],
            'phones.*'=>['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i','required'],
    ], [

        'phones.regex'=>'الرقم غير صحيح',
'phones.required'=>'يجب   ادخال الرقم ',
    ]);*/
    for($i=0;$i<$size;$i++){
if(!preg_match('/^(009665|9665|\+9665|05)([0-9]{8})$/i',$request->phones[$i])){return redirect()->back()->with(['error'=>'رقم جوال المسافر غير صحيح'.$request->phones[$i]])->withInput();}
if($request->marketer_phone&&!preg_match('/^(009665|9665|\+9665|05)([0-9]{8})$/i',$request->marketer_phone)){return redirect()->back()->with(['error'=>'رقم جوال المسوق غير صحيح'])->withInput();}
        
    if($request->phones[$i]){
        $into=Str::substr($request->phones[$i],0,2);
        
        if($into=='05'){
        $phoneP=Str::substr($request->phones[$i],2,8);
          
        $phone="9665".$phoneP;
       
    }else{
        $phone=$request->phones[$i];
    }
    }
    $phoneM="";
    if($request->marketer_phone){
        $into=Str::substr($request->marketer_phone,0,2);
        
        if($into=='05'){
        $phoneP=Str::substr($request->marketer_phone,2,8);
          
        $phoneM="9665".$phoneP;
       
    }else{
        $phoneM=$request->marketer_phone;
    }
    }
        $pcrs=new Pcr();
        $pcrs->way_of_travel=$request->way_of_travel;
        $pcrs->lab_id=$request->lab_id;
        $pcrs->provider_id=$request->provider_id;
        $pcrs->city_id=$request->city_id;
        $pcrs->time_take=$request->time_take;
        $pcrs->travel_at=$request->travel_at;
        $pcrs->know_by=$request->know_by;
        $pcrs->marketer_name=$request->marketer_name;
        $pcrs->marketer_phone=$phoneM;

        $pcrs->phone=$phone;
        $pcrs->name=$request->names[$i];
        $pcrs->surname=$request->surnames[$i];
        $pcrs->passport_no=$request->passport_nos[$i];
/*
        $name = implode(',',$request['name']);
        $name=$request['name'];
        $surname = $request['surname'];
        $passport_no =$request['passport_no'];*/

                if($request->hasFile('passport_images')) {
                                foreach($request->file('passport_images') as $image){
                                 $passport_images[]   =$image;
                                }
                                
            

                        $destinationPath = public_path('/images/pcrs/');
                        $filename = $passport_images[$i]->getClientOriginalName();
                       $passport_images[$i]->move($destinationPath,$filename);
                                     $pcrs->passport_image = $filename;

                    }

                    //$pcrs->name=$name;
                    //$pcrs->surname=$surname;
                    //$pcrs->passport_no=$passport_no;
                     $pcrs->save();
                    $lab=Lab::where('id',$pcrs->lab_id)->first();
                    $lab_name=$lab->name;
                    $lab_link=$lab->position;
                    $lab_phone=$lab->phone;
  $msg='تم طلب حجز موعد لفحص كورونا للمسافرين  بنجاح بمختبر'.$lab_name.' وبعد الفحص سوف يصلك تقرير وصورة الفحص بامكانك مشاركته مع جهات ذات الاهتمام لاغراض السفر الموقع على  الخريطة '.$lab_link.'   رقم جوال المختبر    '.$lab_phone;
                    if($request->phones[$i]){
                        $p=$phone;
                         $this->sendSASMS($phone,$msg);
                    }

    }
        return redirect()->route('home')->with(['message'=>' تم حجز لفحص كرونا سيتم ارسال رساله لتحديد موعد الفحص '])->with('type','success');
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
            'coding' => 'UTF-8',
        ]
    ]);
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
            'unicode' => 'UTF-8',
        ]
    ]);
}

}

