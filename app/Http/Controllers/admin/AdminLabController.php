<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Lab;
use App\City;
use Str;
use Illuminate\Support\Facades\Hash;

class AdminLabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labs=Lab::orderby('id','desc')->get();
        return view('dashboard.labs.index')->with('labs',$labs);
       
    
        
    }
       public function formShared($id){
                $lab=Lab::where(['id'=>$id])->first();
   return view('dashboard.labs.share')->with('lab',$lab);

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

        $lab=Lab::where(['id'=>$id])->first();


        $msg=' رابط موقع '.$lab->name.'  على الخريطة: '.$lab->position;

                   
                    if($request->phone){
                        $p=$phone;
                        $this->sendSASMS($phone,$msg);
                    }else{
                        $p=$y_phone;
                        $this->sendYESMS($y_phone,$msg);

                    }


return redirect()->route('admin.lab.index')->with('success','تم مشاركة نتيجه الفحص بنجاح مع صاحب رقم  '.$p)  ; 

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities=City::all();
        $p=Lab::count();
        return view('dashboard.labs.create')->with(['cities'=> $cities,'p'=>$p]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'phone'=>['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i'],
            

       
       

    ], [

        'phone.regex'=>'الرقم غير صحيح',
'phone.required'=>'يجب ادخال  رقم جوال',
//'name.unique'=>'اسم المختبر موجود بنظام   ',


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
if(Lab::where('phone',$phone)->first()){
return redirect()->route('admin.lab.create')->with('error','رقم الجوال موجود بنظام   ')->withInput();
}

$lab = new Lab();

$lab->name=$request['name'];
$lab->city_id=$request['city_id'];
$lab->position=$request['position'];
$lab->w_clock=$request['w_clock'];
$lab->priority=$request['priority'];

       $lab->password = Hash::make($request['password']);
              $body=' تم اضافة المختبر مع يمن باص  كلمه السر : '.$request->password.' رابط تسجيل دخول لادارتك : https://dashboard.yemenbus.com/login/lab ';
  
           $lab->phone=$phone;
           $lab->save();
            $to=$lab->phone;
             $this->sendSASMS($to, $body)  ;

            return redirect()->route('admin.lab.index')->with('success','تم اضافة المختبر بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cities=City::all();
        $lab =Lab::where('id',$id)->first();
        $p=Lab::count();

        return view('dashboard.labs.edit')->with(['cities'=> $cities,'lab'=>$lab,'p'=>$p]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'phone'=>['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i'],

       
       

    ], [

        'phone.regex'=>'الرقم غير صحيح',
'phone.required'=>'يجب ادخال  رقم جوال',
'phone.regex'=>'الرقم غير صحيح',
//'name.unique'=>'اسم المختبر موجود بنظام   ',


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

$lab =Lab::where('id',$id)->first();

$lab->name=$request['name'];
$lab->city_id=$request['city_id'];
  $lab->priority=$request['priority'];

          $lab->position=$request['position'];
$lab->w_clock=$request['w_clock'];

           
           $lab->save();
            return redirect()->route('admin.lab.index')->with('success','تم تعديل المختبر بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lab =Lab::where('id',$id)->delete();
        return redirect()->route('admin.lab.index')->with('success','تم حذف المختبر بنجاح');

    }

    public function sms($id)
    {
        $lab =Lab::where('id',$id)->first();

        return view('dashboard.labs.sms')->with(['lab'=>$lab]);
    }
    public function smsSend(Request $request,$id)
    {
        request()->validate([
            'phone'=>['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i'],

       
       

    ], [

        'phone.regex'=>'الرقم غير صحيح',
'phone.required'=>'يجب ادخال  رقم جوال',
//'name.unique'=>'اسم المختبر موجود بنظام   ',


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

$lab =Lab::where('id',$id)->first();

              $body=$request->message;
          
            $to=$phone;
             $this->sendSASMS($to,$body)  ;

            return redirect()->route('admin.lab.index')->with('success','تم ارسال رساله الى  المختبر بنجاح');
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
