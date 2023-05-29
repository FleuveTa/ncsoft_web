<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = [
        'title_vn',
        'title_en',
        'description_vn',
        'description_en',
        'image',
        'user_id',
        'button_name_vn',
        'button_name_en',
        'order',
        'status'
    ];
}
