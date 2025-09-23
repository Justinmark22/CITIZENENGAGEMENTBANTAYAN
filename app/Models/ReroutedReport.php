<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReroutedReport extends Model
{
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

    // 🔗 Relation to ForwardedReport
    public function forwardedReport()
    {
        return $this->belongsTo(ForwardedReport::class, 'report_id');
    }

    // 🔗 Relation to User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
