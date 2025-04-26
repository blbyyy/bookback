<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Librarian extends Model
{
    use HasFactory;

    public $table = "librarians";
    public $primaryKey = "id";
    public $guarded = [
        "id"
    ];

    protected $fillable = [
        "name",
        "birthdate",
        "address",
        "age",
        "sex",
        "phone",
        "email",
        "avatar",
        "user_id",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
