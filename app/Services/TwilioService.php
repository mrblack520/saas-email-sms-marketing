<?php

namespace App\Services;

use Twilio\Rest\Client;
/**
 * Class TwilioService.
 */
class TwilioService
{

    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.auth_token')
        );

        


    }

    public function sendSMS($to, $message)
    {
        $this->twilio->messages->create(
            $to,
            [
                // 'from' => config('services.twilio.phone'),
                'body' => $message,
                "messagingServiceSid" => "MG32aa0fcd02e8e188000e215d6d90b16a",
            ]
        );
    //    dd($this->twilio->messages->create()); 
    }

}
