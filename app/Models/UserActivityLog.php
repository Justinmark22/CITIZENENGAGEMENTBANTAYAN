<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    use HasFactory;

    protected $table = 'user_activity_logs'; // optional if following Laravel conventions

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'role',
        'location',
        'status',
        'last_login',
        'logout_at',
    ];
}
