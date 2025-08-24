<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ForwardedAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = [
        'announcement_id',
        'title',
        'message',
        'location',
        'start_date',
        'end_date',
        'barangay',
        'forwarded_by',
    ];

    /**
     * Relationship: ForwardedAnnouncement belongs to original Announcement.
     */
    public function announcement()
    {
        return $this->belongsTo(Announcement::class, 'announcement_id');
    }

    /**
     * Relationship: Forwarded by an Admin User.
     */
    public function forwardedBy()
    {
        return $this->belongsTo(User::class, 'forwarded_by');
    }
}
