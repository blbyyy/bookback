<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Borrower;
use App\Models\User;
use Carbon\Carbon;
use View, DB, File, Auth;

class BorrowerController extends Controller
{
    public function register_page()
    {
        return View::make('borrowers.register');
    }

    public function register(Request $request)
    { 
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role = 'Borrower';   
            $user->save();
            $last = DB::getPdo()->lastInsertId();

            $borrower = new Borrower;
            $borrower->name = $request->name;
            $borrower->address = $request->address;
            $borrower->birthdate = $request->birthdate;
            $borrower->age = $request->age;
            $borrower->sex = $request->sex;
            $borrower->phone = $request->phone;
            $borrower->email = $request->email;
            $borrower->user_id = $last;
            $borrower->save();

            return redirect()->to('/login')->with('register_success', 'Borrower Profile Successfully Register.');

    }

    public function profile($id)
    {
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

        return View::make('borrowers.profile',compact('borrowers','borrowerNotifCount','borrowerNotification'));
    }

    public function change_avatar(Request $request)
    {
        $borrowers = DB::table('borrowers')
        ->select('borrowers.id')
        ->where('user_id',Auth::id())
        ->first();

        $borrower = Borrower::find($borrowers->id);
        $files = $request->file('avatar');
        $avatarFileName = time().'-'.$files->getClientOriginalName();
        Storage::put('public/avatars/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));
        
        $borrower->avatar = $avatarFileName;
        $borrower->save();

        return redirect()->to('/borrower/profile/{id}')->with('success', 'Avatar changed successfully.');
    }

    public function update_profile(Request $request, $id)
    {
        $user = DB::table('borrowers')
        ->select('borrowers.id')
        ->where('user_id', $id)
        ->first();

        $borrower = Borrower::find($user->id);
        $borrower->name = $request->borrowerName;
        $borrower->birthdate = $request->borrowerBirthdate;
        $borrower->address = $request->borrowerAddress;
        $borrower->age = $request->borrowerAge;
        $borrower->sex = $request->borrowerSex;
        $borrower->phone = $request->borrowerPhone;
        $borrower->save();

        $user = User::find(Auth::id());
        $user->name = $request->borrowerName;
        $user->save();

        // Alert::success('Success', 'Profile was successfully updated');

        return redirect()->to('/borrower/profile/{id}')->with('success', 'Profile Was Successfully Updated');
    }

    public function validate_password(Request $request)
    {
        $enteredPassword = $request->input('password');
        $user = Auth::user();

        // Check if the entered password matches the stored hashed password
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
            
            return redirect()->to('/borrower/profile/{id')->with('success', 'Password changed successfully.');
        }
    }

    public function my_history()
    {
        $history = DB::table('book_transaction')->where('borrower_id',Auth::id())->paginate(10);

        $borrowers = DB::table('borrowers')
            ->join('users','users.id','borrowers.user_id')
            ->select('borrowers.*','users.*')
            ->where('user_id',Auth::id())
            ->first();

        $notification = DB::table('notifications')
            ->join('users', 'users.id', 'notifications.user_id')
            ->where('type', 'Borrower Notification')
            ->orderBy('notifications.created_at', 'desc')
            ->get();

        $borrowerNotifCount = DB::table('notifications')
            ->where('type', 'Borrower Notification')
            ->where('status', 'not read')
            ->count();

        $borrowerNotification = DB::table('notifications')
            ->where('type', 'Borrower Notification')
            ->orderBy('date', 'desc')
            ->take(4)
            ->get();

        return View::make('borrowers.my_history',compact('history','borrowers','borrowerNotifCount','borrowerNotification','notification'));
    }

    public function showhistoryinfo($id)
    {
        $history = DB::table('book_transaction')
        ->join('books', 'books.id', '=', 'book_transaction.book_id')
        ->where('book_transaction.id', $id)
        ->select('book_transaction.*', 'books.author as author','books.img_path') 
        ->first();

        if (!$history) {
            return response()->json(['error' => 'History not found'], 404);
        }

        return response()->json(['history' => $history,]);
    }

    public function borrowerNotifications()
    {
        $borrowers = DB::table('borrowers')
            ->join('users','users.id','borrowers.user_id')
            ->select('borrowers.*','users.*')
            ->where('user_id',Auth::id())
            ->first();

        $notification = DB::table('notifications')
            ->join('users', 'users.id', 'notifications.user_id')
            ->where('type', 'Borrower Notification')
            ->where('reciever_id', Auth::id())
            ->orderBy('notifications.created_at', 'desc')
            ->get();

        $twoDaysAgo = Carbon::now()->subDays(2);
            
        $borrowerNotifCount = DB::table('notifications')
            ->where('type', 'Borrower Notification')
            ->where('status', 'not read')
            ->count();

        $borrowerNotification = DB::table('notifications')
            ->where('type', 'Borrower Notification')
            ->orderBy('date', 'desc')
            ->take(4)
            ->get();


        return View::make('borrowers.notifications',compact('borrowers','notification','borrowerNotifCount','borrowerNotification'));
    }
}
