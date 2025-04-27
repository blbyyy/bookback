<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookTransactionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/signout', [HomeController::class, 'perform'])->name('signout');

Route::post('/notification/is-read', [AdminController::class, 'markAsRead'])->name('notification');

Route::get('/borrower/register-page', [BorrowerController::class, 'register_page'])->name('register.page');

//START ADMIN/LIBRARIAN ROUTES
Route::middleware(['auth', 'is.librarian'])->group(function () {

    Route::get('/admin/profile/{id}', [AdminController::class, 'librarian_profile'])->name('admin.profile');

    Route::post('/admin/profile/avatar/changed', [AdminController::class, 'change_avatar'])->name('librarian-change-avatar');

    Route::post('/admin/profile/{id}/updated', [AdminController::class, 'update_profile'])->name('librarian-update-profile');

    Route::post('/admin/profile/validate-password', [AdminController::class, 'validate_password'])->name('librarian-validate-change-password');

    Route::post('/admin/profile/change-password', [AdminController::class, 'change_password'])->name('librarian-change-password');

    Route::get('/admin/book-catalog', [BookController::class, 'book_catalog_index'])->name('book.catalog.index.page');

    Route::get('/admin/show/book/{id}', [BookController::class, 'showbookinfo'])->name('get-book-data');

    Route::get('/admin/show/book/{id}/edit', [BookController::class, 'editbookinfo'])->name('edit-book-data');

    Route::post('/admin/book-catalog/show/{id}/edit/update', [BookController::class, 'updatebookinfo'])->name('update-book-data');

    Route::post('/admin/book/added', [BookController::class, 'addbook'])->name('book-added');

    Route::get('/admin/librarian-list', [AdminController::class, 'librarians_list'])->name('librarian-list.page');

    Route::post('/admin/librarian-list/added', [AdminController::class, 'addLibrarianAcc'])->name('librarian-added');

    Route::get('/admin/librarian-list/{id}', [AdminController::class, 'showLibrarianInfo'])->name('librarian-get-data');

    Route::get('/admin/librarian-list/{id}/edit', [AdminController::class, 'editlibrarianinfo'])->name('edit-librarian-data');

    Route::post('/admin/librarian-list/{id}/update', [AdminController::class, 'update_librarian_info'])->name('updated-librarian-data');

    Route::get('/admin/borrower-list', [AdminController::class, 'borrower_list'])->name('borrower-list.page');

    Route::post('/admin/borrower-list/added', [AdminController::class, 'addBorrowerAcc'])->name('borrower-added');

    Route::get('/admin/borrower-list/{id}', [AdminController::class, 'showBorrowerInfo'])->name('borrower-get-data');

    Route::get('/admin/borrower-list/{id}/edit', [AdminController::class, 'editBorrowerInfo'])->name('edit-borrower-data');

    Route::post('/admin/borrower-list/{id}/update', [AdminController::class, 'update_borrower_info'])->name('updated-borrower-data');

    Route::get('/admin/borrowing-log', [AdminController::class, 'borrowing_log'])->name('borrowing-log');

    Route::get('/admin/borrowing-log/borrower/{id}', [AdminController::class, 'show_borrower_info'])->name('borrowing-log-borrower');

    Route::get('/admin/borrowing-log/book/{id}', [AdminController::class, 'show_book_info'])->name('borrowing-log-book');

    Route::get('/admin/book-rentals', [AdminController::class, 'book_rentals'])->name('borrowing-rentals-page');

    Route::get('/admin/book-rentals/process/{id}', [AdminController::class, 'get_transaction_id'])->name('get-transaction-id');

    Route::post('/admin/book-rentals/process/{id}/sent', [AdminController::class, 'book_transaction'])->name('transaction-process-done');

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin/reminder', [AdminController::class, 'reminder'])->name('reminder');

    Route::post('/admin/updating/transaction-status/{id}', [AdminController::class, 'transaction_done'])->name('updating-transaction-status');

    Route::get('/admin/transaction/{id}/onedayahead', [AdminController::class, 'transactionId'])->name('transactionId');

    Route::post('/admin/transaction/onedayahead/send-email', [AdminController::class, 'manualSendEmail'])->name('manual-email-send');

    Route::get('/admin/all-notifications', [AdminController::class, 'adminNotifications'])->name('admin.notifications');

});
//END OF ADMIN/LIBRARIAN ROUTES

//START BORROWER ROUTES
Route::middleware(['auth', 'is.borrower'])->group(function () {

    Route::get('/book-list', [BookController::class, 'book_list_index'])->name('book.list.index.page');

    Route::post('/borrower/registered', [BorrowerController::class, 'register'])->name('borrower-registered');

    Route::get('/borrower/profile/{id}', [BorrowerController::class, 'profile'])->name('borrower.profile');

    Route::post('/borrower/profile/avatar/changed', [BorrowerController::class, 'change_avatar'])->name('borrower-change-avatar');

    Route::post('/borrower/profile/{id}/updated', [BorrowerController::class, 'update_profile'])->name('borrower-update-profile');

    Route::post('/borrower/profile/validate-password', [BorrowerController::class, 'validate_password'])->name('validate-change-password');

    Route::post('/borrower/profile/change-password', [BorrowerController::class, 'change_password'])->name('borrower-change-password');

    Route::get('/borrower/get/book/{id}', [BookTransactionController::class, 'get_book_id'])->name('borrower-get-book-id');

    Route::post('/borrower/book/transaction/{id}', [BookTransactionController::class, 'book_transaction'])->name('borrower-book-transaction');

    Route::get('/my-history', [BorrowerController::class, 'my_history'])->name('borrower.book.history');

    Route::get('/my-history/show/book-transaction/{id}', [BorrowerController::class, 'showhistoryinfo'])->name('get-transaction-history-data');

    Route::get('/all-notifications', [BorrowerController::class, 'borrowerNotifications'])->name('borrower.notifications');

});
//END OF BORROWER ROUTES

