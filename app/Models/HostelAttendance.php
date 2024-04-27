<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostelAttendance extends Model
{
    use HasFactory;

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    protected $fillable = [
        'student_id', 'date', 'direction', 'note', 'in_time', 'out_time','status',
    ];


}
