<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;


    public const STATUS_BACK_VOLUMES = 0;
    public const STATUS_AVAILABLE = 1;
    public const STATUSES = [
    "0" => ['label' =>'Requested','color' => 'warning'],
    "1" => ['label' =>'Completed','color' => 'success'],
    "2" => ['label' =>'Cancel','color' => 'danger']
    ];
}
