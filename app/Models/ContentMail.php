<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contentMail extends Model
{

    public function __construct(public string $heading, public string $title, public string $description)
    {
        $this->$heading = $heading;
        $this->title = $title;
        $this->description = $description;
    }
}
