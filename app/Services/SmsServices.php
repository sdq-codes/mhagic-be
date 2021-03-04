<?php


namespace App\Services;


use App\Services\Interfaces\SmsServiceInterface;
use GuzzleHttp\Client;

class SmsServices extends BaseService implements SmsServiceInterface
{
    private $client;
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://api.ebulksms.com:8080/',
            'headers' => ['Content-Type' => 'application/json']
        ]);
    }

    public function sendSms($messages, $telephoneNumber): \Psr\Http\Message\ResponseInterface
    {
        return $this->client->post('sendsms.json',
            ['body' => json_encode(
                [
                    'SMS' => [
                        'auth' => [
                            'username' => 'hefedayour@gmail.com',
                            'apikey' => '03854a7fb8c36cb6132f222e3b4df4503a2038b6'
                        ],
                        'message' => [
                            'sender' => 'SwiftLogist',
                            'messagetext' => $messages,
                        ],
                        'recipients' => [
                            "gsm" => [
                                [
                                    "msidn"=> $telephoneNumber,
                                ]
                            ]
                        ],
                    ]
                ]
            )]
        );
    }
}
