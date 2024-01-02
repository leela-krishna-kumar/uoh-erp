<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestPaperUser extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 0;
    public const STATUS_STARTED = 1;
    public const STATUS_COMPLETED = 2;
    public const STATUS_CANCELLED = 3;

    public const STATUSES = [
        "0" => ['label' =>'Pending','color' => 'primary'],
        "1" => ['label' =>'Started','color' => 'secondary'],
        "2" => ['label' =>'Completed','color' => 'success'],
        "3" => ['label' =>'Cancelled','color' => 'danger'],
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
