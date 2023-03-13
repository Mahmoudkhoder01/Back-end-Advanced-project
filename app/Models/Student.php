<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{    use HasFactory;
    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "birth_date",
        "phone_number",
        "enrollment_date",
        "headshot"
    ];
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
