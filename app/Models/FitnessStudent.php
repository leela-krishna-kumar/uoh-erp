<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessStudent extends Model
{
    use HasFactory;
    protected $casts = [
        'payload' => 'array',
        'sports_ids' =>'array',
        
    ];

    
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function sports()
    {
        return $this->belongsTo(Sports::class,'sports_ids');
    }
}
