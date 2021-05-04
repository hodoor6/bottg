<?php

class Referrals
{

    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function getReferral()
    {
        $message = $this->message;
        $message = explode(' ', $message, 2);
        $msg = $message[0];
        $referral_id = $message[1];
        $content = array(
            'referral_id' => $referral_id,
            'message' => $msg
        );
        if (isset($referral_id)) {
            return $content;
        } else {
            return false;
        }
    }

}