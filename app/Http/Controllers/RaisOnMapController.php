<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Str;
use App\Provider;
class RaisOnMapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id=Auth::guard('provider')->user()->id;
        $rOms=DB::table('rise_on_maps')->where('provider_id',$id)->paginate(4);
        return view('providers.raise_on_maps')->with('rOms',$rOms);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
        public function formShared($id){
                $nom=DB::table('rise_on_maps')->where(['id'=>$id])->first();
   return view('providers.share')->with('nom',$nom);

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
  
        if($request->phone &&$request->y_phone){return redirect()->back()->with('error','يرجى ادخال احد الرقمين ليس كلاهما')->withInput();}

        $nom=DB::table('rise_on_maps')->where(['id'=>$id])->first();
        $provider=Provider::where('id',$nom->provider_id)->first();
        $company=$provider->name_company;
        $msg=' رابط الموقع على الخريطة  '.$nom->link.' شركة '.$company;

                   
                    if($request->phone){
                        $p=$phone;
                         $this->sendSASMS($phone,$msg);
                    }else{
                        $p=$y_phone;
                         $this->sendYESMS($y_phone,$msg);

                    }

return redirect()->route('dashboard.raiseOnMap.index')->with('success','تم مشاركة رابط الموقع على الخريطة مع صاحب رقم  '.$p)  ; 

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        DB::table('rise_on_maps')->insert([
            'provider_id' => Auth::guard('provider')->user()->id, 
            'countery' => $request->countery,
            'city' => $request->city,
            'link' => $request->link,
            ]
        );	
        return  back();		
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = DB::table('rise_on_maps')->where('id', $id)->first();
        return view('providers.rom');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        DB::table('rise_on_maps')->where('id',$id)->update([
            'provider_id' => Auth::guard('probider')->user()->id, 
            'countery' => $request->countery,
            'city' => $request->city,
            'link' => $request->link,
            ]
        );
        	return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('rise_on_maps')->where('id',$id)->delete();
        return back()->with('success','تم الحذف بنجاح');

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
function sendYESMS($to, $body) {
    $client = new \GuzzleHttp\Client();
    $client->get('http://52.36.50.145:8080/MainServlet', [
        'query' => [
            'orgName' => env('YEMEN_SMS_orgName'),
            'userName' => env('YEMEN_SMS_userName'),
            'password' => env('YEMEN_SMS_password'),
            'mobileNo' => $to,
            'text' => $body,
            'unicode' => 'UTF-8',
        ]
    ]);
}


}
