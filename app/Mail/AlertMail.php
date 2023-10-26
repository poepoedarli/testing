<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AlertMail extends Mailable
{
    use Queueable, SerializesModels;

    
    /**
     * Create a new message instance.
     */
    private $recipient_name;
    private $from_email_address;
    public $subject;
    private $content;

    public function __construct($recipient_name, $from_email_address, $subject, $content) 
    {
        $this->recipient_name = $recipient_name;
        $this->from_email_address = $from_email_address;
        $this->subject = $subject;
        $this->content = $content;
    }

    public function build()
    {
        $name = $this->recipient_name;
        $from_email = $this->from_email_address;
        $content = $this->content;
        return $this->view('emails.alert', compact('name', 'from_email', 'content'));
    }
    
    public function attachments(): array
    {
        return [];
    }
}
