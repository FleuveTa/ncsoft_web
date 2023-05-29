<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contentMailRecruitment extends Model
{
    use HasFactory;
    public function __construct(
            public string $heading,
            public string $name,
            public string $phonenumber,
            public string $gender, 
            public string $description,
            public string $file,
        )
    {
        $this->$heading = $heading;
        $this->name = $name;
        $this->phonenumber = $phonenumber;
        $this->gender = $gender;
        $this->description = $description;
    }
}
