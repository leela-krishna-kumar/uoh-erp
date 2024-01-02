<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class StudentLeave extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'review_by', 'apply_date', 'from_date', 'to_date', 'subject', 'reason', 'attach', 'note', 'status','id',
    ];
    public const  TYPE_LEAVE = 0;
    public const TYPE_EARLY = 1;
    public const TYPE_LATE = 2;
    public const TYPE_OTHER = 3;
    public const TYPES = [
        "0" => ['label' =>'Leave','color' => 'success'],
        "1" => ['label' =>'Early','color' => 'danger'],
        "2" => ['label' =>'Late','color' => 'danger'],
        "3" => ['label' =>'Other','color' => 'primary'],
    ];
    public function student()
    {
        return $this->belongsTo(Student::class,'student_id','id');
    }

    public function reviewBy()
    {
        return $this->belongsTo(User::class, 'review_by', 'id');
    }
}
