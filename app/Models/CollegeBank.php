<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollegeBank extends Model
{
    use HasFactory;

    public const TYPE_CURRENT = 0;
    public const TYPE_SAVING = 1;

    public const TYPES = [
        "0" => ['label' =>'Current','color' => 'success'],
        "1" => ['label' =>'Saving','color' => 'primary'],
    ];
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
