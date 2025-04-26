<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookPhotos;
use View, DB, File, Auth;

class BookController extends Controller
{
    public function book_catalog_index(Request $request)
    {
        $query = Book::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%");
        }

        $books = $query->orderBy('id')->paginate(10);

        $librarian = DB::table('librarians')
            ->join('users','users.id','librarians.user_id')
            ->select('librarians.*','users.*')
            ->where('user_id',Auth::id())
            ->first();

        $notification = DB::table('notifications')
            ->join('users', 'users.id', 'notifications.user_id')
            ->where('type', 'Librarian Notification')
            ->orderBy('notifications.created_at', 'desc')
            ->get();

        $adminNotifCount = DB::table('notifications')
            ->where('type', 'Librarian Notification')
            ->where('status', 'not read')
            ->count();

        $adminNotification = DB::table('notifications')
            ->where('type', 'Librarian Notification')
            ->orderBy('date', 'desc')
            ->take(4)
            ->get();

        return View::make('books-catalog.index', compact('books','librarian','adminNotifCount','adminNotification','notification'));
    }

    public function addbook(Request $request)
    {  
            $book = new Book();
            $book->title = $request->book_title; 
            $book->author = $request->book_author; 
            $book->category = $request->book_category;
            $book->summary = $request->book_summary;

            $files = $request->file('bookphoto');
            $bookPhotoFileName = time().'-'.$files->getClientOriginalName();
            Storage::put('public/bookPhotos/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
            
            $book->img_path = $bookPhotoFileName;
            $book->save();

        return redirect()->to('/admin/book-catalog')->with('success', 'Book Was Successfully Created!');
    }

    public function showbookinfo($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        return response()->json(['book' => $book,]);
    }

    public function editbookinfo($id)
    {
        $book = Book::find($id);
        return response()->json($book);
    }

    public function updatebookinfo(Request $request, $id)
    {
        $book = Book::find($id);
        $book->title = $request->bookTitle; 
        $book->category = $request->bookCategory;
        $book->author = $request->bookAuthor;
        $book->summary = $request->bookSummary;
        $book->save();

        return response()->json($book);
    }

    public function bookdelete(string $id)
    {
        BookPhotos::where('book_id', $id)->delete();

        $book = Book::findOrFail($id);
        $book->delete();

        $data = array('success' =>'deleted','code'=>'200');
        return response()->json($data);
    }

    public function book_list_index(Request $request)
    {
        $query = Book::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
            ->orWhere('category', 'like', "%{$search}%");
        }

        $books = $query->orderBy('id')->paginate(10);

        $borrowers = DB::table('borrowers')
            ->join('users','users.id','borrowers.user_id')
            ->select('borrowers.*','users.*')
            ->where('user_id',Auth::id())
            ->first();

        $borrowerNotifCount = DB::table('notifications')
            ->where('type', 'Borrower Notification')
            ->where('status', 'not read')
            ->count();

        $borrowerNotification = DB::table('notifications')
            ->where('type', 'Borrower Notification')
            ->orderBy('date', 'desc')
            ->take(4)
            ->get();

        return View::make('books-list.index', compact('books', 'borrowers','borrowerNotifCount','borrowerNotification'));
    }

}
