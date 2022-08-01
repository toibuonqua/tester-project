<?php

namespace App\Common;

use Exception;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class MailSender
{
    /**
     * Send an email to one or many recipients
     * 
     * @param $mailClass mail class to be sent to recipient
     * @param mixed $details contains information of user to be put in email content. Can be an array containing attributes or a nested array 
     * @throws Throwable
     */
    public static function send($mailClass, $details, $sendMultiple = false)
    {
        if ($sendMultiple) {
            // TODO: send mail in batch 
        } else {

            Mail::to($details['email'])->send(new $mailClass($details));
        }
    }
}
