<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\DueDateReminder;
use App\Models\BookTransaction;
use Carbon\Carbon;
use View, DB, File, Auth;

class NotifyDueBooks extends Command
{
    protected $signature = 'books:notify-due';
    protected $description = 'Send email notifications for books due today';

    public function handle()
    {
        $today = Carbon::today();
        $this->info("Running due book check for: " . $today->toDateString());

        $dueBooks = BookTransaction::whereDate('due_date', $today)->get();

        $dueBooks = BookTransaction::join('users','users.id','book_transaction.borrower_id')
            ->select('book_transaction.*','users.*')
            ->whereDate('due_date', $today)
            ->get();

        if ($dueBooks->isEmpty()) {
            $this->info("No due books found today.");
        }

        foreach ($dueBooks as $book) {
            $email = $book->email;

            if ($email) {
                Mail::to($email)->send(new DueDateReminder($book));
                $this->info("Email sent to: $email for Book ID: {$book->id}");
            }
        }
    }

}
