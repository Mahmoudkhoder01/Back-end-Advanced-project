<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'status',
    ];
    

    public function section(){
        return $this->belongsTo(Section::class);
    }

     public function student(){
        return $this->belongsTo(Student::class);
    }

    public function students(){
        return $this->belongsToMany(Student::class);
    }


    
}