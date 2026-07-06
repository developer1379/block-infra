<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Contact Form Submission: ' . $this->data['subject'])
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->replyTo($this->data['email'], $this->data['name'])
                    ->view('emails.contact');
    }
}
