<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\BookTransaction;

class DueDateReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $book;

    public function __construct(BookTransaction $book)
    {
        $this->book = $book;
    }

    public function build()
    {
        return $this->markdown('emails.due_reminder')
            ->subject('Book Due Today')
            ->with(['book' => $this->book]);
    }
}
