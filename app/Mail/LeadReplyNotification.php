<?php

namespace App\Mail;

use App\Models\Lead;
use App\Models\LeadReply;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadReplyNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Lead $lead,
        public LeadReply $reply
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[CreativeUP Admin] Respuesta enviada a ' . $this->lead->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.lead-reply-notification',
        );
    }
}
