<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class BaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public function localizedContent(string $view, string $title): Content
    {
        return new Content(
            view: $view,
            with: [
                'lang' => app()->getLocale(),
                'title' => $title,
            ],
        );
    }

    public function send($mailer): void
    {
        $this->withSymfonyMessage(function ($message) {
            $message->mailable = $this::class;
        });

        parent::send($mailer);
    }
}
