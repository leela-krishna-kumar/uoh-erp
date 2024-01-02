<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestPaperProgress extends Model
{
    use HasFactory;
    protected $casts = [
        'answers' => 'array',
    ];
}
