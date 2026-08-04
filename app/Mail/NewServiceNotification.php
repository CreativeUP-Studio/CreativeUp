<?php

namespace App\Mail;

use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewServiceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Service $service
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✨ Nuevo servicio: ' . $this->service->title . ' — CreativeUP',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-service',
        );
    }
}
