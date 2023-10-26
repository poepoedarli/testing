<?php

namespace App\Services;

use Mail;
use App\Jobs\SendEmail;
use App\Jobs\SendSMS;
use App\Mail\AlertMail;

class Alert 
{
    public function dispatchSMS($phone, $sms, $from=null)
    {
        SendSMS::dispatch($phone, $sms, $from);
    }

    public function dispatchEmail($to_email_address, $recipient_name, $from_email_address, $subject, $content)
    {
        Mail::to($to_email_address)->queue(new AlertMail($recipient_name, $from_email_address, $subject, $content));
        /* Mail::queue(new SendEmail(
            ['email' => $to_email_address, 'name' => $recipient_name],
            $subject,
            ['recipientName' => $recipient_name, 'from' => $from_email_address, 'body' => $content]
        )); */
    }
}
