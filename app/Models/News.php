<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'heading_vn',
        'heading_en',
        'description_vn',
        'description_en',
        'title_vn',
        'title_en',
        'user_id',
        'slug',
        'image',
        'time_display',
    ];
}
