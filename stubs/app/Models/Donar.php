<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donar extends Model
{
    use HasFactory;

    public const TYPE_INDIVIDUAL = 0;
    public const TYPE_ORGANIZATION = 1;

    public const TYPES = [
        "0" => ['label' =>'Individual','color' => 'primary'],
        "1" => ['label' =>'Organization','color' => 'success'],
     
    ];
}
