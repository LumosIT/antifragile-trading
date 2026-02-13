<?php

namespace App\Utilits\CloudPayments;

class CloudPayments
{

    const DOMAIN = 'https://api.cloudpayments.ru/';

    public $public;
    protected $private;

    public function __construct(string $public, string $private)
    {
        $this->public = $public;
        $this->private = $private;
    }

    public function request(string $method, array $params = []) : array
    {

        $headers = ['Content-Type: application/json'];

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, self::DOMAIN . $method);
        curl_setopt($curl, CURLOPT_USERPWD, sprintf('%s:%s', $this->public, $this->private));
        curl_setopt($curl, CURLOPT_TIMEOUT, 12);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($curl);

        curl_close($curl);

        $json = json_decode($result, true);

        if(!array_key_exists('Success', $json) || !$json['Success']){
            throw new CloudPaymentsException($json['Message'], $json['ErrorCode'] ?: 0);
        }

        return $json;

    }

    public function sign(string $data) : string
    {
        return hash_hmac('sha256', $data, $this->private);
    }

}
