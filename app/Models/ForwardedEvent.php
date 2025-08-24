<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForwardedEvent extends Model
{
    use HasFactory;

  protected $fillable = [
    'event_id',
    'title',
    'category',
    'location',
    'event_date',
    'event_time',
    'barangay',
    'forwarded_by',
];



    // Optional relationship
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function forwardedBy()
    {
        return $this->belongsTo(User::class, 'forwarded_by');
    }
}
