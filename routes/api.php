<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::delete('/admin/book/{id}/deleted', [BookController::class, 'bookdelete'])->name('book.destroy');

Route::delete('/admin/librarian-list/{id}/deleted', [AdminController::class, 'librarian_delete'])->name('librarian.destroy');

Route::delete('/admin/borrower-list/{id}/deleted', [AdminController::class, 'borrower_delete'])->name('borrower.destroy');

