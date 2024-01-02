<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipStudent extends Model
{
    use HasFactory;
   
    public const  STATUS_SHORTLISTED = 0;
    public const STATUS_SELECTED = 1;

    public const STATUSES = [
        "0" => ['label' =>'Shortlisted','color' => 'primary'],
        "1" => ['label' =>'Selected','color' => 'success'],
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id','student_id');
    }  
    public function scholarship(){
        return  $this->belongsTo(Scholarship::class,'scholarship_id','id');
    }  
    
}
