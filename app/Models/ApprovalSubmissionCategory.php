<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalSubmissionCategory extends Model
{
    use HasFactory;
    
    public const TYPE_STAFF = 0;
    public const TYPE_STUDENT = 1;
    public const TYPES = [
        "0" => ['label' =>'Staff','color' => 'primary'],
        "1" => ['label' =>'Student','color' => 'success']
    ];
}
