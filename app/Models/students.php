<?php

namespace App\Models;
use App\Models\sections;
use App\Models\attendance;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class students extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'birth_date',
       'phone_number',
       'enrollment_date',
       'headshot',
    ];


    use HasFactory;

    public function sections(){
        return $this->belongsTo(sections::class,"section_id","id");
    }

    public function attendance(){
        return $this->belongsTo(attendance::class);
    }
}
