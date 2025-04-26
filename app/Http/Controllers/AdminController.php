<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApproveRequest;
use App\Mail\RejectRequest;
use App\Mail\OneDayAhead;
use App\Mail\DueToday;
use App\Mail\Overdue;
use App\Models\BookTransaction;
use App\Models\Notifications;
use Illuminate\Http\Request;
use App\Models\Librarian;
use App\Models\Borrower;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use View, DB, File, Auth;


class AdminController extends Controller
{
    public function librarian_profile($id)
    {
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


        return View::make('admin.librarian-profile',compact('librarian','adminNotifCount','adminNotification'));
    }

    public function change_avatar(Request $request)
    {
        $librarian = DB::table('librarians')
        ->select('librarians.id')
        ->where('user_id',Auth::id())
        ->first();

        $librarian = Librarian::find($librarian->id);
        $files = $request->file('avatar');
        $avatarFileName = time().'-'.$files->getClientOriginalName();
        Storage::put('public/avatars/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
        
        $librarian->avatar = $avatarFileName;
        $librarian->save();

        // Alert::success('Success', 'Avatar changed successfully!');

        return redirect()->to('/admin/profile/{id}')->with('success', 'Avatar changed successfully.');
    }

    public function update_profile(Request $request, $id)
    {
        $user = DB::table('librarians')
        ->select('librarians.id')
        ->where('user_id', $id)
        ->first();

        $librarian = Librarian::find($user->id);
        $librarian->name = $request->librarianName;
        $librarian->birthdate = $request->librarianBirthdate;
        $librarian->address = $request->librarianAddress;
        $librarian->age = $request->librarianAge;
        $librarian->sex = $request->librarianSex;
        $librarian->phone = $request->librarianPhone;
        $librarian->save();

        $user = User::find(Auth::id());
        $user->name = $request->librarianName;
        $user->save();

        // Alert::success('Success', 'Profile was successfully updated');

        return redirect()->to('/admin/profile/{id}')->with('success', 'Profile Was Successfully Updated');
    }

    public function validate_password(Request $request)
    {
        $enteredPassword = $request->input('password');
        $user = Auth::user();

        $isMatch = Hash::check($enteredPassword, $user->password);

        return response()->json(['match' => $isMatch]);
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'newpassword' => 'required|min:8',
            'renewpassword' => 'required|same:newpassword',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            Alert::error('Error', 'Current password is incorrect.');
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }else {
            $user->update([
                'password' => Hash::make($request->newpassword),
            ]);
            // Alert::success('Success', 'Password changed successfully!');
            return redirect()->to('/admin/profile/{id')->with('success', 'Password changed successfully.');
        }
    }

    public function librarians_list(Request $request)
    {
        $query = Librarian::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $librarian_user = $query->orderBy('id')->paginate(10);

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


        return View::make('admin.librarians-list', compact('librarian','librarian_user','adminNotifCount','adminNotification'));
    }

    public function addLibrarianAcc(Request $request)
    {  
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'Librarian';   
        $user->save();
        $lastId = DB::getPdo()->lastInsertId();

        $librarian = new Librarian();
        $librarian->name = $request->name; 
        $librarian->address = $request->address;
        $librarian->email = $request->email;
        $librarian->birthdate = $request->birthdate;
        $librarian->age = $request->age; 
        $librarian->sex = $request->sex;
        $librarian->phone = $request->phone;
        $librarian->user_id = $lastId;
        $librarian->save();

        return redirect()->to('/admin/librarian-list')->with('success', 'Librarian Account Was Successfully Created!');
    }

    public function showLibrarianInfo($id)
    {
        $librarian = DB::table('librarians')
            ->join('users','users.id','librarians.user_id')
            ->select('librarians.*','users.*')
            ->where('librarians.id',$id)
            ->first();

        return response()->json($librarian);
    }

    public function editlibrarianinfo($id)
    {
        $librarian = Librarian::find($id);
        return response()->json($librarian);
    }

    public function update_librarian_info(Request $request, $id)
    {
        $user = DB::table('librarians')
        ->select('librarians.user_id')
        ->where('librarians.id', $id)
        ->first();

        $librarian = Librarian::find($id);
        $librarian->name = $request->librarianName;
        $librarian->birthdate = $request->librarianBirthdate;
        $librarian->address = $request->librarianAddress;
        $librarian->age = $request->librarianAge;
        $librarian->sex = $request->librarianSex;
        $librarian->phone = $request->librarianPhone;
        $librarian->save();

        $user = User::find($user->user_id);
        $user->name = $request->librarianName;
        $user->save();

        return response()->json(["librarian" => $librarian, 'user' => $user,]);
    
    }

    public function librarian_delete(string $id)
    {
        $user = DB::table('librarians')
        ->select('librarians.user_id')
        ->where('librarians.id', $id)
        ->first();

        $librarian = Librarian::findOrFail($id);
        $librarian->delete();

        $user = User::findOrFail($user->user_id);
        $user->delete();
        
        $data = array('success' =>'deleted','code'=>'200');
        return response()->json($data);
    }

    public function borrower_list(Request $request)
    {
        $query = Borrower::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $borrower = $query->orderBy('id')->paginate(10);

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

        return View::make('admin.borrower-list', compact('borrower','librarian','adminNotifCount','adminNotification'));
    }

    public function addBorrowerAcc(Request $request)
    {  
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'Borrower';   
        $user->save();
        $lastId = DB::getPdo()->lastInsertId();

        $borrower = new Borrower();
        $borrower->name = $request->name; 
        $borrower->address = $request->address;
        $borrower->email = $request->email;
        $borrower->birthdate = $request->birthdate;
        $borrower->age = $request->age; 
        $borrower->sex = $request->sex;
        $borrower->phone = $request->phone;
        $borrower->user_id = $lastId;
        $borrower->save();

        return redirect()->to('/admin/borrower-list')->with('success', 'Borrower Account Was Successfully Created!');
    }

    public function showBorrowerInfo($id)
    {
        $borrower = DB::table('borrowers')
            ->join('users','users.id','borrowers.user_id')
            ->select('borrowers.*','users.*')
            ->where('borrowers.id',$id)
            ->first();

        return response()->json($borrower);
    }

    public function editBorrowerInfo($id)
    {
        $borrower = Borrower::find($id);
        return response()->json($borrower);
    }

    public function update_borrower_info(Request $request, $id)
    {
        $user = DB::table('borrowers')
        ->select('borrowers.user_id')
        ->where('borrowers.id', $id)
        ->first();

        $borrower = Borrower::find($id);
        $borrower->name = $request->borrowerName;
        $borrower->birthdate = $request->borrowerBirthdate;
        $borrower->address = $request->borrowerAddress;
        $borrower->age = $request->borrowerAge;
        $borrower->sex = $request->borrowerSex;
        $borrower->phone = $request->borrowerPhone;
        $borrower->save();

        $user = User::find($user->user_id);
        $user->name = $request->borrowerName;
        $user->save();

        return response()->json(["borrower" => $borrower, 'user' => $user,]);
    
    }

    public function borrower_delete(string $id)
    {
        $user = DB::table('borrowers')
        ->select('borrowers.user_id')
        ->where('borrowers.id', $id)
        ->first();

        $borrower = Borrower::findOrFail($id);
        $borrower->delete();

        $user = User::findOrFail($user->user_id);
        $user->delete();
        
        $data = array('success' =>'deleted','code'=>'200');
        return response()->json($data);
    }

    public function borrowing_log(Request $request)
    {
        $query = BookTransaction::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('borrower_name', 'like', "%{$search}%")
            ->orWhere('book_borrowing_date', 'like', "%{$search}%")
            ->orWhere('due_date', 'like', "%{$search}%");
        }

        $transaction = $query->orderBy('id')->paginate(10);

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

        return View::make('admin.borrowing-log', compact('transaction','librarian','adminNotifCount','adminNotification'));
    }

    public function show_borrower_info($id)
    {
        $borrower = DB::table('borrowers')
            ->join('users','users.id','borrowers.user_id')
            ->select('borrowers.*','users.*')
            ->where('borrowers.user_id',$id)
            ->first();

        if (!$borrower) {
            return response()->json(['error' => 'Borrower not found'], 404);
        }

        return response()->json($borrower);
    }

    public function show_book_info($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        return response()->json(['book' => $book,]);
    }

    public function book_rentals()
    {
        $transaction = BookTransaction::where('status', 'Pending')->orderBy('id')->paginate(10);

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


        return View::make('admin.book-rentals', compact('transaction','librarian','adminNotifCount','adminNotification'));
    }

    public function get_transaction_id($id)
    {
        $transaction = BookTransaction::find($id);
        return response()->json($transaction);
    }

    public function book_transaction(Request $request, $id)
    { 
        $data = DB::table('book_transaction')
        ->join('users', 'book_transaction.borrower_id', '=', 'users.id')
        ->select('book_transaction.*', 'users.name as user_name', 'users.email as user_email')
        ->where('book_transaction.id', $id)
        ->first();
        $userEmail = $data->user_email;

        $transaction = BookTransaction::find($id);
        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }
        if ($request->status === 'Currently Borrowed') {
            $transaction->due_date = $request->due_date;
            $transaction->status = $request->status;
            Mail::to($userEmail)->send(new ApproveRequest($data));
        } else {
            $transaction->due_date = 'Unknown'; 
            $transaction->status = 'Rejected';
            Mail::to($userEmail)->send(new RejectRequest($data));
        }
        $transaction->save();

        $book = Book::find($request->bookid);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }
        if ($request->status === 'Currently Borrowed') {
            $book->status = 'Currently Borrowed'; 
        } else {
            $book->status = 'On-Shelf';
        }
        $book->save();

        $userID = DB::table('book_transaction')->where('id', $id)->value('borrower_id');

        $notif = new Notifications;
        $notif->type = 'Borrower Notification';
        if ($request->status === 'Currently Borrowed') {
            $notif->title = 'Book Rental Request Approved';
            $notif->message = 'Your request has been aprroved';
        } else {
            $notif->title = 'Book Rental Request Rejected';
            $notif->message = 'Your request has been rejected';
        }
        $notif->date = now();
        $notif->user_id = Auth::id();
        $notif->reciever_id = $userID;
        $notif->save();

        return response()->json(["transaction" => $transaction, 'book' => $book, 'notif' => $notif]);
    }

    public function reminder(Request $request)
    {
        $query = BookTransaction::query();

        $query->where(function ($query) {
            $query->where('status', '=', 'Currently Borrowed');
        });
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            
            $today = Carbon::today();
            
            switch ($search) {
                case '1_day_ahead':
                    $query->whereDate('due_date', '=', $today->copy()->addDay()->toDateString()); 
                    break;
                case '2_days_ahead':
                    $query->whereDate('due_date', '=', $today->copy()->addDays(2)->toDateString()); 
                    break;
                case '3_days_ahead':
                    $query->whereDate('due_date', '=', $today->copy()->addDays(3)->toDateString()); 
                    break;
                case 'overdue':
                    $query->whereDate('due_date', '<', $today->toDateString()); 
                    break;
                default:
                    break;
            }
        }
        
        $transaction = $query->orderBy('id')->paginate(10);

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

        return View::make('admin.reminders', compact('transaction','librarian','adminNotifCount','adminNotification'));
    }

    public function markAsRead(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = DB::table('users')->where('id', Auth::id())->first();

        if ($user->role === 'Librarian') {
            Notifications::where('type', 'Librarian Notification')->where('status', 'not read')->update(['status' => 'read']);
        } elseif ($user->role === 'Borrower') {
            Notifications::where('reciever_id', Auth::id())->where('status', 'not read')->update(['status' => 'read']);
        } 

        return response()->json(['message' => 'Notifications marked as read successfully']);
    }

    public function adminNotifications()
    {
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

        $twoDaysAgo = Carbon::now()->subDays(2);
            
        $adminNotifCount = DB::table('notifications')
            ->where('type', 'Librarian Notification')
            ->where('status', 'not read')
            ->count();

        $adminNotification = DB::table('notifications')
            ->where('type', 'Librarian Notification')
            ->orderBy('date', 'desc')
            ->take(4)
            ->get();

        return View::make('admin.notifications',compact('librarian','notification','adminNotifCount','adminNotification'));
    }

    public function transaction_done($id)
    { 
        $bookId = DB::table('book_transaction')->select('book_id')->where('id', $id)->first();

        $transaction = BookTransaction::find($id);
        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }
        $transaction->status = 'Book Returned';
        $transaction->save();

        $book = Book::find($bookId->book_id);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }
        $book->status = 'On-Shelf'; 
        $book->save();

        return response()->json(["transaction" => $transaction, 'book' => $book,]);
    }

    public function transactionId($id)
    {
        $transaction = BookTransaction::find($id);
        return response()->json($transaction);
    }

    public function manualSendEmail(Request $request)
    {
        $transactionID = $request->transactionID;
        $bookID = $request->bookID;
        $userID = $request->userID;

        $data = DB::table('book_transaction')
        ->join('users', 'book_transaction.borrower_id', '=', 'users.id')
        ->select('book_transaction.*', 'users.name as user_name', 'users.email as user_email')
        ->where('book_transaction.id', $transactionID)
        ->first();

        $userEmail = $data->user_email;

        if ($request->emailType === 'OneDayAhead') {
            Mail::to($userEmail)->send(new OneDayAhead($data));
        } elseif ($request->emailType === 'DueToday') {
            Mail::to($userEmail)->send(new DueToday($data));
        } elseif ($request->emailType === 'Overdue') {
            Mail::to($userEmail)->send(new Overdue($data));
        }

        return redirect()->to('/admin/reminder')->with('success', 'Email Sent!');
    }

}
