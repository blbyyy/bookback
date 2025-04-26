<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookPhotos extends Model
{
    use HasFactory;

    public $table = "booksphoto";
    public $primaryKey = "id";
    public $guarded = [
        "id"
    ];

    protected $fillable = [
        "book_id",
        "img_path",
    ];

    public function book_img()
    {
        return $this->belongsTo(Author::class, 'book_id');
    }

}
