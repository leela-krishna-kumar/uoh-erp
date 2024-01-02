<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlacedStudent extends Model
{
    use HasFactory;


    public function getFullNameAttribute() {
        return ucwords($this->first_name.' '.$this->last_name);
    }

    public function getPrefix() {
        return "#ID".str_replace('_1','','_'.(100000 +$this->id));
    }
    public function student()
    {
        return $this->belongsTo(Student::class,'student_id','student_id');
    } 
}
