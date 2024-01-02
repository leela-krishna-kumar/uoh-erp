<?php

namespace App\Models;
use App\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeRegister extends Model
{
    use HasFactory;

    public const STATUS_OPEN = 0;
    public const STATUS_CLOSE = 1;

    public const STATUSES = [
        "0" => ['label' =>'Open','color' => 'success'],
        "1" => ['label' =>'Close','color' => 'danger'],
    ];

    public function name()
    {
        return $this->belongsTo(CollegeBank::class, 'bank_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function bankName()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
