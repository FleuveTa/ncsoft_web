<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const Role = [
        '0' => 'Administrator',
        '1' => 'Author'
    ];
}
