<?php

namespace App\Http\Controllers\admin;

use App\TripOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function index()
    {
        $orders = TripOrder::with('passengers','trips')->orderBy('id','desc')->paginate(10);

        return view('dashboard.passengers.ticketindex',[
            'orders' => $orders
        ]);
    }

    public function sendsms($phone , $country)
    {
        return view('dashboard.passengers.sendsms',[
            'phone' => $phone,
            'country' => $country,
            ]);
    }

    public function storesms(Request $request)
    {
        $request->validate([
            'message'=> 'required|string|max:400|min:3',
        ]);

       $body = $request->message ;
       $request->s_phone ? $this->sendSASMS($request->s_phone, $body) : $this->sendYESMS($request->y_phone, $body) ;

       return redirect()->back()->with('success', 'تم الارسال بنجاح');

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
