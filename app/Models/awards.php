<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class awards extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id', 'award_name', 'awarding_agency', 'date',
    ];
}
