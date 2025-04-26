<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $table = "books";
    public $primaryKey = "id";
    public $guarded = [
        "id"
    ];

    protected $fillable = [
        "title",
        "category",
        "summary",
        "book_img",
    ];

    public function photos()
    {
        return $this->hasMany(BookPhoto::class, 'book_id');
    }
}
