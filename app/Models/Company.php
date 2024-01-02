<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;

    public const STATUSES = [
        "0" => ['label' =>'Inactive','color' => 'danger'],
        "1" => ['label' =>'Active','color' => 'success'],
    ];

    
}
