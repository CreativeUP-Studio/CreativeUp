<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewPostNotification extends Mailable
{
    use Queueable, SerializesModels;

    public User $sender;

    public function __construct(
        public Post $post
    ) {
        $this->sender = User::first();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Nuevo artículo: ' . $this->post->title . ' — CreativeUP',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-post',
        );
    }
}
