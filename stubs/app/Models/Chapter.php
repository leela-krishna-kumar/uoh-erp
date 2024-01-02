<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    public const STATUS_INCOMPLETE = 0;
    public const STATUS_COMPLETE = 1;

    public const STATUSES = [
        "0" => ['label' =>'Incomplete','color' => 'danger'],
        "1" => ['label' =>'Complete','color' => 'success'],
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
