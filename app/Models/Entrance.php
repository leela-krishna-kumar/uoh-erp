<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrance extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'payload' => 'array',
        
    ];
}
