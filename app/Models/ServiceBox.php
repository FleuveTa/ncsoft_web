<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBox extends Model
{
    use HasFactory;
    const Box = [
        'box-technology',
        'box-software',
        'box-web'
    ];
}

