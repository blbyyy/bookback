<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTransaction extends Model
{
    use HasFactory;

    public $table = "book_transaction";
    public $primaryKey = "id";
    public $guarded = [
        "id"
    ];

    protected $fillable = [
        "borrower_name",
        "book_title",
        "book_category",
        "book_borrowing_date",
        "due_date",
        "status",
        "book_id",
        "borrower_id",
    ];
}
