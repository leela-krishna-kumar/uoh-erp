<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestPaper extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public const  TYPE_SCHEDULED_TEST = 0;
    public const  TYPE_UNSCHEDULED_TEST = 0;

    public const TYPES = [
        "0" => ['label' =>'Scheduled Test','color' => 'success'],
        "1" => ['label' =>'Un Scheduled','color' => 'danger'],
    ];
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
