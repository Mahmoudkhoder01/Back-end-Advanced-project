<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    
        public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
    public function class()
    {
        return $this->belongsTo(Grade::class);
    }
    public function section(){
        return $this->belongsto(Section::class);
    }
    public function student()
    {
        return $this->hasMany(Student::class);
    }
    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
