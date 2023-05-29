<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionConstant extends Model
{
    const Permistion = [
        'create',
        'write',
        'delete'
    ];
}
