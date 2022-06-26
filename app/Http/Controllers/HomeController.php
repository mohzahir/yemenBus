<?php

namespace App\Http\Controllers;
use App\Admin;
use App\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\EmailMarketerRequest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middlewa;e('auth');
    }

        public function marketerEmail(Request $request){
        if($request->phone_code == "966"){
if((!preg_match('/^(05)([0-9]{8})$/i',$request->phone))){return redirect()->back()->with(['error'=>'رقم جوال  غير صحيح'])->withInput();}
}else{
if((!preg_match('/^(7)([0-9]{8})$/i',$request->phone))){return redirect()->back()->with(['error'=>'رقم جوال  غير صحيح'])->withInput();}
}
        
            $to_name='Yamen Bus';
$to_email =Admin::where('id',1)->first()->email;
$data = array('name'=>$request->name, 'phone'=>$request->phone, 'phone'=>$request->phone,'phone_code'=>$request->phone_code,'address'=>$request->address,'city'=>$request->city,'price'=>$request->price);
Mail::send('mail', $data, function($message) use ($to_name, $to_email) {
$message->to($to_email, $to_name)
->subject('طلب جديد ');
$message->from('hass16093@gmail.com','Yamen Bus');
});
    
return redirect()->back()->with(['success'=>'  تلقينا رسالة البريد الإلكتروني الخاصة بك , شكرا لك . ']);

        }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$BASE_YEAR = 2020;
        //$week = (now()->year - $BASE_YEAR + 1) * now()->weekOfYear;

        $competitions = Competition::query();
        if (request('day')=='0') {
            $competitions = $competitions->where('day',0);
           
        }
        if (request('day')) {
            $competitions = $competitions->where('day', request('day'));
        }

        if (request('direction')) {
            $competitions = $competitions->where('direction', request('direction'));
        }

        if (request('type')) {
            if (request('type') == 'free') {
                $competitions = $competitions->where('discount_percentage', 100);
            }
            else {
                $competitions = $competitions->where('discount_percentage', '<', 100);
            }
        }

        $competitions = $competitions->where('finish_at', '>', now()->tz('UTC')->subDay())->where(function($query) {
            $query->whereNotNull('winner_id')
                ->orWhere('status', 'active');
        })->orderBy('day')->latest()->get();
        return view('home', [
            'competitions' => $competitions
        ]);
    }
}
