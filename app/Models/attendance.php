<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class attendance extends Model
{
    use HasFactory;

    protected $fillable = [

        'status',
    ];


    public function studentSection()
    {
        return $this->belongsTo(Student::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
