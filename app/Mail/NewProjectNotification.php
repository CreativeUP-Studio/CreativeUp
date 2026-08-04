<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewProjectNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Project $project
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚀 Nuevo caso de éxito: ' . $this->project->title . ' — CreativeUP',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-project',
        );
    }
}
