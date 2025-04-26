<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\BookTransaction;
use App\Models\Notifications;
use App\Models\Book;
use Illuminate\Http\Request;
use View, DB, File, Auth;

class BookTransactionController extends Controller
{
    public function get_book_id($id)
    {
        $book = Book::find($id);
        return response()->json($book);
    }

    public function book_transaction(Request $request, $id)
    { 
        $borrowers = DB::table('borrowers')
        ->select('id', 'name')
        ->where('user_id',Auth::id())
        ->first();

        $transaction = new BookTransaction;
        $transaction->borrower_name = $borrowers->name;
        $transaction->book_title = $request->bookTitle;
        $transaction->book_category = $request->bookCategory;
        $transaction->purpose = $request->purpose;
        $transaction->book_borrowing_date = now();
        $transaction->due_date = 'TBA';
        $transaction->status = 'Pending'; 
        $transaction->book_id = $request->bookId; 
        $transaction->borrower_id = Auth::id(); 
        $transaction->save();

        $book = Book::find($request->bookId);
        $book->status = 'On Hold for Borrowing';
        $book->save();

        $notif = new Notifications;
        $notif->type = 'Librarian Notification';
        $notif->title = 'Borrowing Request';
        $notif->message = 'Someone is requesting to borrow a book';
        $notif->date = now();
        $notif->user_id = Auth::id();
        $notif->save();

        return response()->json(["transaction" => $transaction, 'book' => $book, 'notif' => $notif]);
    }
}
