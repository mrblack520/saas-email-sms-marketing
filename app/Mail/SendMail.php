<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $campaignData;

    public function __construct($campaignData)
    {
        $this->campaignData = $campaignData;
    }

    public function build()
    {
        $subject = $this->campaignData['subject'] ?? 'Email';

        return $this->subject($subject)
                    ->view('emails.send', ['campaign' => $this->campaignData]);
    }
}
