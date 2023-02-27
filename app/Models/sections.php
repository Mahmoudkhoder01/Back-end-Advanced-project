<?php

namespace App\Models;
use App\Models\students;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sections extends Model
{
    protected $fillable = [
       
    ];


    use HasFactory;

    public function students(){
        return $this->hasMany(students::class,"id","section_id");
    }

   
}
