<?php

namespace app;

use app\Gateway\JawalyGateway;
use app\SmsLog;

class Jawaly
{

    private $username;
    private $password;
    private $from;
    private $to;
    private $jawaly;

    public function __construct()
    {

        $this->jawaly = new JawalyGateway();
        $this->from = config('jawaly.sender');
        $this->username = config('jawaly.username');
        $this->password = config('jawaly.password');
    }

    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    public function send($message, $numbers = null, $sender = null)
    {
        if ($sender) {
            $this->from = $sender;
        }
        if ($numbers) {
            $this->to = $numbers;
        }
        $send = $this->jawaly->setUser($this->username, $this->password)
                ->setSender($this->from)
                ->setNumbers($this->to)
                ->setMessage($message, config('jawaly.unicode'))
                ->send();
        if (config('jawaly.save_log') == true) {
            $gateMessage = isset($send['message']) ? $send['message'] : '';
            SmsLog::addLog([
                'body' => $message,
                'numbers' => $this->to,
                'sender' => $this->from,
                'status' => $send['status'] ? 'success' : 'failed',
                'response' => $send['response'],
                'gate_message' => $gateMessage
                    ], config('jawaly.log_container'));
        }
        return $send;
    }

    public function getCredits()
    {
        $balance = $this->jawaly->setUser($this->username, $this->password)->getBalance();
        if ($balance['status']) {
            return [true, $balance['response']];
        }
        return [false, $balance['message']];
    }

}
