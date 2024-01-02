<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class ECourse extends Model
{
    use HasFactory;

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
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
