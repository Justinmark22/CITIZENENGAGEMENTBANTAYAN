<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForwardedReport extends Model
{
    use HasFactory;

    protected $table = 'forwarded_reports'; // make sure your table name matches

    protected $fillable = [
        'report_id',
        'category',
        'title',
        'description',
        'photo',
        'status',
        'forwarded_to',
        'location',
        'user_id',
    ];
     // ✅ Add this relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
