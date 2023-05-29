<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogNew extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status_pass',
        'status_future',
        'new_id'
    ];
}
