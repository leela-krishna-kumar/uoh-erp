<?php

namespace App\Models;
use App\User;

use Illuminate\Database\Eloquent\Model;

class ProgramSemesterSection extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'program_id', 'semester_id', 'section_id','teacher_id'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function  teacher(){
        return  $this->belongsTo(User::class,'teacher_id','id');
    } 
}
