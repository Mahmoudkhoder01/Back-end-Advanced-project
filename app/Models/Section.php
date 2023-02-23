<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{

    public function class()
    {
        return $this->belongsTo(Grade::class);
    }
    public function student()
    {
        return $this->hasMany(Student::class);
    }
}
