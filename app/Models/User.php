<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
// use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;


    

    // public function user_categories() : HasMany {
    //     return $this->hasMany(Category::class);
    // }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_name',
        'first_name',
        'last_name',
        'email',
        'address',
        'image',
        'password',
        'status',
        'role',
    ];
    public function permissions() : HasOne {
        return $this->hasOne(Permission::class, 'user_id');
    }

    public function isAdmin() {

        if($this->role === 0){
            return true;

        }else{
            return false;

        }
    }

    public function isAuthor() {

        if($this->role === 1) {
            return true;

        }else {
            return false;
            
        }
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
}
