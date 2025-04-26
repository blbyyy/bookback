<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    public $table = "notifications";

    protected $fillable = [
        "type",
        "title",
        "message",
        "date",
        "user_id",
        "reciever_id",
        "status",
    ];
}
