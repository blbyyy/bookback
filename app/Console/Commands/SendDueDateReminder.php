<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendingDueDateReminder;
use Carbon\Carbon;
use View, DB, File, Auth;

class SendDueDateReminder extends Command
{
    protected $signature = 'reminder:due-books';
    protected $description = 'Send reminder emails for books due tomorrow';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow();

        $dueBooks = DB::table('book_transaction')
            ->join('users', 'users.id', 'book_transaction.borrower_id')
            ->select('book_transaction.book_title', 'book_transaction.book_id','book_transaction.due_date', 'users.email', 'users.name')
            ->whereDate('book_transaction.due_date', $tomorrow)
            ->get();

        if ($dueBooks->isEmpty()) {
            $this->info("No due books found today.");
        }

        foreach ($dueBooks as $book) {
            $dueDate = \Carbon\Carbon::parse($book->due_date)->format('F j, Y');
            $email = $book->email;

            if ($email) {
                Mail::to($email)->send(new SendingDueDateReminder($book));
                $this->info("Email sent to: $email for Book ID: {$book->book_id}");
            }
            
        }
            
        $this->info("Reminder emails sent for " . count($dueBooks) . " books.");
    }
}
