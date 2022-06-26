<?php

namespace Jawaly\SmsGateway\Gateway;

abstract class GatewayAbstract
{

    protected $message;
    protected $numbers;
    protected $sender;
    protected $username;
    protected $password;

    abstract public function setUser($username, $password);

    abstract public function setNumbers($numbers);

    abstract public function setMessage($message);

    abstract public function setSender($sender);

    abstract public function send();

    public function convertToUnicode($message)
    {
        $message = stripcslashes($message);
        $encode = mb_detect_encoding($message);
        $string = mb_convert_encoding($message, 'UTF-16', $encode);
        $returnString = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $finalText = strtoupper(bin2hex($string[$i]));
            $returnString .= $finalText;
        }
        return $returnString;
    }

}
