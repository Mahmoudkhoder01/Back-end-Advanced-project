<?php

namespace App\Models;
use App\Models\students;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;

    public function students(){
        return $this->hasMany(students::class);
    }
}
