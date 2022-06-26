<?php

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
        sendYESMS($to, $body);
    }
    else if ($country_code == '966') {
        sendSASMS($to, $body);
    }
}