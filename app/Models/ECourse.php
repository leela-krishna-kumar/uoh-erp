<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class ECourse extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
    public function sections()
    {
        return $this->hasMany(ESection::class,'e_course_id');
    }
    public function eSection()
    {
        return $this->belongsTo(ESection::class);
    }
    public function eCourseUser()
    {
        return $this->hasMany(ECourseUser::class, 'course_id');
    }
}
