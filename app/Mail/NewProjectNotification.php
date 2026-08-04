<?php

namespace App\Mail;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewProjectNotification extends Mailable
{
    use Queueable, SerializesModels;

    public User $sender;

    public function __construct(
        public Project $project
    ) {
        $this->sender = User::first();
    }

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
