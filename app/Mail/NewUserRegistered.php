<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // The new user

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('New User Registered')
                    ->view('emails.new_user_registered');
    }
}
