<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 0;
    public const STATUS_COMPLETED = 1;
    public const STATUS_REOPENED = 2;

    public const STATUSES = [
        "0" => ['label' =>'Pending','color' => 'danger'],
        "1" => ['label' =>'Completed','color' => 'success'],
        "2" => ['label' =>'Reopened','color' => 'primary'],
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }
}
