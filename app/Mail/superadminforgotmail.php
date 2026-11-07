<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class superadminforgotmail extends Mailable
{
    use Queueable, SerializesModels;

 public $details;
    public function __construct($details)
    {
        $this->details = $details;
    }


public function build()
    {
       
         return $this->subject('Reset Passowrd?')
                    ->view('emails.backend.SuperAdmin.ForgotPassword');
    }
}
