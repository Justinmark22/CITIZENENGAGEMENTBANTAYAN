<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateRequest extends Model
{
    use HasFactory;

    protected $table = 'certificate_requests';

   protected $fillable = [
    'user_id',
    'full_name',
    'birthdate',
    'gender',
    'civil_status',
    'address',
    'location',
    'contact',
    'email',
    'certificate_type',
    'certificate_data',
    'status'
];

protected $casts = [
    'certificate_data' => 'array',
];

    // Relation to User (optional if you have a users table)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
