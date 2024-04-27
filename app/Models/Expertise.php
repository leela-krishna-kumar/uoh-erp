<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    use HasFactory;
    protected $table="expertise";
    protected $fillable = [
        'user_id', 'staff_id', 'area_of_expertise', 'topics',
    ];
}

