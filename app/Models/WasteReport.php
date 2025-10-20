<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteReport extends Model
{
    use HasFactory;

    protected $table = 'rerouted_reports'; // replace with your actual table name
    protected $fillable = ['title', 'status', 'location', 'forwarded_to', 'description'];
}
