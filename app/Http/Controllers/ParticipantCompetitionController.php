<?php

namespace App\Http\Controllers;

use App\Competition;
use App\Participant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParticipantCompetitionController extends Controller
{
    public function store()
    {

        $id=request()->id;
        request()->validate([
            'phone' => ['required', 'string', 'regex:/^[0-9]+$/'],
            'phone_country' => ['required', Rule::in(['966', '967'])]
        ], [
            'phone.regex' => 'الرجاء إدخال رقم جوال سعودي أو يمني صحيح',
            'phone.required' => 'رقم الجوال إجباري',
            'phone_country.required' => 'اختيار الدولة إجباري'
        ]);
        $competition =Competition::where('id',$id)->first();


       /* $duplicate_phones = Competition::where('status', 'active')->get()->map->participants->flatten()->where('phone', request('phone'));
        if (count($duplicate_phones)) {
            
        }*/

    $participant = new Participant();
        $participant->phone = request('phone_country') . request('phone');
        $participant->competition_id = $id;
        $dparticipant = Participant::where(['phone'=>$participant->phone,'competition_id'=>$id])->first();
        if($dparticipant){return redirect()->route('home')->with('message', 'رقم الجوال هذا مسجل في القرعة بالفعل')->with('type', 'danger');}else{

        $participant->save();

        // Send sms
        $sms_text = 'تم الاشتراك بنجاح في قرعة يمن باص. لتأكيد الاشتراك برجاء حجز الرحلة المناسبة على ' . $competition->booking_link;
        $this->sendSMS(request('phone_country'), $participant->phone, $sms_text);

        return redirect()->route('home')->with(['message'=>"تم الاشتراك بنجاح برقم جوال  ".$participant->phone])->with('type','success');
    }
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

function sendSMS($country_code, $to, $body) {
    if ($country_code == '967') {
        $this->sendYESMS($to, $body);
    }
    else if ($country_code == '966') {
        $this->sendSASMS($to, $body);
    }
}
}
