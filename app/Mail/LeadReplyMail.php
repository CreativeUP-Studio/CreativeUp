<?php

namespace App\Mail;

use App\Models\Lead;
use App\Models\LeadReply;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Lead $lead,
        public LeadReply $reply
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Respuesta de CreativeUP - Re: Tu consulta',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.lead-reply',
        );
    }
}
