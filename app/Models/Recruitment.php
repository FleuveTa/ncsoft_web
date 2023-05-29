<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruitment extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'heading_vn',
        'heading_en',
        'description_vn',
        'description_en',
        'number_of_people',
        'salary',
        'user_id',
        'slug',
        'timeout',
        'time_display',
    ];
}
