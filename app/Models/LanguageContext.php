<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageContext extends Model
{
    use HasFactory;
    protected $fillable = [
        'keyword',
        'content_vn',
        'content_en',
        'user_id',
        'updated_at'
    ];
}
