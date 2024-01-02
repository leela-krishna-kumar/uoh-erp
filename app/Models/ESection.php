<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class ESection extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function course()
    {
        return $this->belongsTo(ECourse::class, 'e_course_id');
    }
}
