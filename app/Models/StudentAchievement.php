<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'category_id', 'type','date','note'
    ];  

    protected $casts = [
        'student_id' => 'array',
    ];

    public const TYPE_PHYSICAL_EDUCATION = 0;
    public const TYPE_ACADEMIC_EDUCATION = 1;
    public const TYPE_EXTRA_CURRICULUM = 2;
    public const TYPES = [
        "0" => ['label' =>'Physical Education','color' => 'primary'],
        "1" => ['label' =>'Academic Education','color' => 'success'],
        "2" => ['label' =>' Extra Curriculum','color' => 'danger']
    ];

    public function category()
    {
        return $this->belongsTo(AchievementCategory::class, 'category_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}

