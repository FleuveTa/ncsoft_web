<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogRecruitment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status_pass',
        'status_future',
        'recruitment_id'
    ];
}
