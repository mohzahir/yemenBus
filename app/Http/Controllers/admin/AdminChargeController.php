<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Recharge;
use App\Marketer;
use App\User;

class AdminChargeController extends Controller
{
    public function chargeForm($id=null)
    {
      //$this->authorize(User::class);
        if($id)
            {  $marketer=Marketer::where('id',$id)->first();

        return view('dashboard.marketers.charge')->with('marketer',$marketer);}
        else{ return view('dashboard.marketers.charge');}
      
    } 
    public function charge(Request $request)
    {
      $m=Marketer::where('code',$request->marketer_id)->first();
        $recharge=Recharge::create([
       'code'=>$request->code,
       'amount'=>$request->amount,
       'notes'=>$request->notes,
        'currecny'=>$request->currecny,
       'marketer_id'=>$m->id,
]); 
            if ($request->hasFile('transfer_img')&&$request->file('transfer_img')->isValid()) {
                $files = $request->file('transfer_img');
                   // Define upload path
                   $destinationPath = public_path('/images/recharge/');// upload path
                // Upload Orginal Image           
                   $image = $files->getClientOriginalExtension();
                   $files->move($destinationPath, $image);
        
                   $insert['transfer_img'] = $image;
                // Save In Database
                   
                    $recharge->transfer_img=$image;
                }
                        $recharge->save();
if($recharge->currecny=='sar'){
                        $marketer=Marketer::where('id', $recharge->marketer_id)->first();
                        $marketer->max_rs= $marketer->max_rs+ $recharge->amount;
                        $marketer->save();
                    } else{
                        $marketer=Marketer::where('id', $recharge->marketer_id)->first();
                        $marketer->max_ry= $marketer->max_ry+ $recharge->amount;
                        $marketer->save();
                    }
    
        session()->flash('success','تم شحن رصيد المسوق بنجاح ');
        return back();
      }
}
