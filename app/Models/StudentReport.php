<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class StudentReport extends Model
{

    use HasFactory;
    protected $fillable = [
        'category_id' ,'reason', 'date', 'note',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id','id');
    } 
   

    public function category()
    {
        return $this->belongsTo(StudentReportCategory::class, 'category_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFullNameAttribute() {
        return ucwords($this->first_name.' '.$this->last_name);
     }

     public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }


}
