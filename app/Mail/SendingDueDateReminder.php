<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\BookTransaction;

class SendingDueDateReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $book;

    public function __construct($book)
    {
        $this->book = $book;
    }

    public function build()
    {
        return $this->subject('Reminder: Book Due Soon')
                    ->view('emails.one_day_reminder');
    }
}
