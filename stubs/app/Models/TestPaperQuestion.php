<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestPaperQuestion extends Model
{
    use HasFactory;

    public function questions()
    {
        return $this->belongsTo(QuestionBank::class, 'question_bank_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
