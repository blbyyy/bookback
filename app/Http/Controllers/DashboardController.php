<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use View, DB, File, Auth;


class DashboardController extends Controller
{
    public function index()
    {
        $onshelf = DB::table('books')->where('status', 'On-Shelf')->count();
        $currently = DB::table('books')->where('status', 'Currently Borrowed')->count();
        $onhold = DB::table('books')->where('status', 'On Hold for Borrowing')->count();

        // $near = DB::table('book_transaction')->whereDate('due_date', '=', Carbon::tomorrow()->toDateString())->count();
        $near = DB::table('book_transaction')
        ->whereDate('due_date', '=', Carbon::tomorrow()->toDateString())
        ->where('status', '!=', 'Book Returned')
        ->count();

        // $overdue = DB::table('book_transaction')->where('due_date', '<', Carbon::today()->subDay())->count();
        $overdue = DB::table('book_transaction')
        ->where('due_date', '<', Carbon::today()->subDay())
        ->where('status', '!=', 'Book Returned')
        ->count();

        // $dueToday = DB::table('book_transaction')->whereDate('due_date', Carbon::today())->count();
        $dueToday = DB::table('book_transaction')
        ->whereDate('due_date', Carbon::today())
        ->where('status', '!=', 'Book Returned')
        ->count();

        $transactionsPerDay = DB::table('book_transaction')
        ->select(DB::raw('DATE(book_borrowing_date) as date'), DB::raw('count(*) as count'))
        ->groupBy(DB::raw('DATE(book_borrowing_date)'))
        ->orderBy('book_borrowing_date')
        ->get();

        $transactionsPerWeek = DB::table('book_transaction')
        ->select(DB::raw("YEAR(book_borrowing_date) as year"), DB::raw("WEEK(book_borrowing_date, 1) as week"), DB::raw("count(*) as count"))
        ->groupBy(DB::raw("YEAR(book_borrowing_date)"), DB::raw("WEEK(book_borrowing_date, 1)"))
        ->orderByRaw("YEAR(book_borrowing_date), WEEK(book_borrowing_date, 1)")
        ->get();

        $transactionsPerMonth = DB::table('book_transaction')
        ->select(DB::raw("YEAR(book_borrowing_date) as year"), DB::raw("MONTH(book_borrowing_date) as month"), DB::raw("count(*) as count"))
        ->groupBy(DB::raw("YEAR(book_borrowing_date)"), DB::raw("MONTH(book_borrowing_date)"))
        ->orderByRaw("YEAR(book_borrowing_date), MONTH(book_borrowing_date)")
        ->get();
        
        $transactionsByDueDate = DB::table('book_transaction')
        ->select('due_date', DB::raw('count(*) as count'))
        ->groupBy('due_date')
        ->orderBy('due_date', 'asc')
        ->get();

        $librarian = DB::table('librarians')
            ->join('users','users.id','librarians.user_id')
            ->select('librarians.*','users.*')
            ->where('user_id',Auth::id())
            ->first();

        $adminNotifCount = DB::table('notifications')
            ->where('type', 'Librarian Notification')
            ->where('status', 'not read')
            ->count();

        $adminNotification = DB::table('notifications')
            ->where('type', 'Librarian Notification')
            ->orderBy('date', 'desc')
            ->take(4)
            ->get();

        $dueBooks = DB::table('book_transaction')
            ->join('users','users.id','book_transaction.borrower_id')
            ->select('book_transaction.*','users.*')
            ->whereDate('due_date', Carbon::today())
            ->get();

        return View::make('admin.dashboard', compact(
            'librarian','onshelf','currently','transactionsPerMonth',
            'onhold','near','overdue','transactionsPerWeek',
            'dueToday','transactionsPerDay','transactionsByDueDate',
            'adminNotifCount','adminNotification'
        ));
            
    }
}
 