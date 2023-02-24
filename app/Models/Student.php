<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function class()
    {
        return $this->belongsTo(Grade::class);
    }
    public function section()
    {
        return $this->hasMany(Section::class);
    }
  public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
