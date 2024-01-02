<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestPaper extends Model
{
    use HasFactory;
    
    public function faculty()
    {
        return $this->belongsTo(Faculty::class,'faculty_id','id');
    }
    public function program()
    {
        return $this->belongsTo(Program::class,'program_id','id');
    }
    public function session()
    {
        return $this->belongsTo(Session::class,'session_id','id');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class,'semester_id','id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class,'section_id','id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id','id');
    }
    public function testPaperQuestions()
    {
        return $this->hasMany(TestPaperQuestion::class,'testpaper_id','id');
    }
}
