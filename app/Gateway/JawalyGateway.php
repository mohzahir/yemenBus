<?php

namespace Jawaly\SmsGateway\Gateway;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;

class JawalyGateway extends GatewayAbstract
{

    const SUCCESS_CODES = [100];
    const CREDIT_SUCCESS_CODES = [117];

    protected $message;
    protected $numbers;
    protected $sender;
    protected $username;
    protected $password;
    protected $encoding;

    public function setUser($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        return $this;
    }

    public function setSender($sender)
    {
        $numbersPattern = [
            "0" => "/٠/",
            "1" => "/١/",
            "2" => "/٢/",
            "3" => "/٣/",
            "4" => "/٤/",
            "5" => "/٥/",
            "6" => "/٦/",
            "7" => "/٧/",
            "8" => "/٨/",
            "9" => "/٩/"
        ];
        $sender = preg_replace(array_values($numbersPattern), array_keys($numbersPattern), $sender);
        $this->sender = trim($sender);
        return $this;
    }

    public function setNumbers($numbers)
    {
        if (is_array($numbers)) {
            $numbers = implode(',', $numbers);
        }
        $numbersPattern = [
            "0" => "/٠/",
            "1" => "/١/",
            "2" => "/٢/",
            "3" => "/٣/",
            "4" => "/٤/",
            "5" => "/٥/",
            "6" => "/٦/",
            "7" => "/٧/",
            "8" => "/٨/",
            "9" => "/٩/"
        ];
        $numbers = preg_replace(array_values($numbersPattern), array_keys($numbersPattern), $numbers);
        $numbers = preg_replace("/[^0-9]/", ",", $numbers);
        $numbersArray = explode(",", $numbers);
        $numbersArray = array_diff($numbersArray, ['']);
        $numbers = implode(',', $numbersArray);
        $this->numbers = $numbers;
        return $this;
    }

    public function setMessage($message, $unicode = true)
    {
        if ($unicode == true) {
            $this->message = $this->convertToUnicode(trim($message));
            $this->encoding = 'U';
        } else {
            $this->message = trim($message);
            $this->encoding = 'E';
        }
        return $this;
    }

    public function send()
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://4jawaly.net/'
        ]);
        try {
            $response = $client->post('api/sendsms.php', ['form_params' => [
                    'username' => $this->username,
                    'password' => $this->password,
                    'sender' => $this->sender,
                    'message' => $this->message,
                    'numbers' => $this->numbers,
                    'return' => 'json',
                    'unicode' => $this->encoding
                ]
            ]);
            $jsonResponse = json_decode($response->getBody());
            $status = $jsonResponse->Code;
            if (in_array($status, self::SUCCESS_CODES)) {
                return ['status' => true, 'response' => json_encode(json_decode($response->getBody())), 'message' => $jsonResponse->MessageIs];
            }
            return ['status' => false, 'response' => json_encode(json_decode($response->getBody())), 'message' => $jsonResponse->MessageIs];
        } catch (RequestException $ex) {
            return ['status' => false, 'response' => $ex->getResponse()->getBody() !== null ? $ex->getResponse()->getBody() : $ex->getMessage()];
        } catch (ClientException $ex) {
            return ['status' => false, 'response' => $ex->getResponse()->getBody() !== null ? $ex->getResponse()->getBody() : $ex->getMessage()];
        }
    }

    public function getBalance()
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://4jawaly.net/'
        ]);
        try {
            $response = $client->post('api/getbalance.php', ['form_params' => [
                    'username' => $this->username,
                    'password' => $this->password,
                    'return' => 'json'
                ]
            ]);
            $jsonResponse = json_decode($response->getBody());
            $status = $jsonResponse->Code;
            if (in_array($status, self::CREDIT_SUCCESS_CODES)) {
                return ['status' => true, 'response' => $jsonResponse->currentuserpoints, 'message' => $jsonResponse->MessageIs];
            }
            return ['status' => false, 'response' => json_encode(json_decode($response->getBody())), 'message' => $jsonResponse->MessageIs];
        } catch (RequestException $ex) {
            return ['status' => false, 'response' => $ex->getResponse()->getBody() !== null ? $ex->getResponse()->getBody() : $ex->getMessage()];
        } catch (ClientException $ex) {
            return ['status' => false, 'response' => $ex->getResponse()->getBody() !== null ? $ex->getResponse()->getBody() : $ex->getMessage()];
        }
    }

}
