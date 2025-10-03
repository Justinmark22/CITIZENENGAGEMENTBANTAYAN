<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MfaOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    public function __construct($otp) {
        $this->otp = $otp;
    }

    public function build() {
        return $this->subject('Your Bantayan 911 Verification Code')
                    ->view('emails.mfa_otp')
                    ->with(['otp' => $this->otp]);
    }
}
