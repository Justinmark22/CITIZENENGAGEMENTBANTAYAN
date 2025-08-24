<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupportRequestMail extends Mailable
{
    use SerializesModels;

    public $issue;
    public $email;

    public function __construct($data)
    {
        $this->issue = $data['issue'];
        $this->email = $data['email'];
    }

    public function build()
    {
        return $this->subject('New Support Request')
                    ->view('emails.support_request');
    }
}