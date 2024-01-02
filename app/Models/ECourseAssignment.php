<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;


class ECourseAssignment extends Model
{
    use HasFactory;

    public function  ecourse(){
        return  $this->belongsTo(ECourse::class,'e_course_id','id');
    }  
}
