<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    public $table = "borrowers";
    public $primaryKey = "id";
    public $guarded = [
        "id"
    ];

    protected $fillable = [
        "name",
        "birthdate",
        "age",
        "sex",
        "phone",
        "email",
        "avatar",
        "user_id",
    ];
}
