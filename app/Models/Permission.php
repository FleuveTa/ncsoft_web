<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Model
{
    use HasFactory;

    public function users () : BelongsTo {
        return $this->belongsTo(User::class);
    }
    protected $fillable = [
        'user_id',
        'permission'
    ];
}
