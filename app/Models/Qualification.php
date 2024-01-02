<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;
    protected $fillable = [
        'hall_ticket_no','year_of_passing','marks', 'percenteage', 'institution', 'grade'];

    protected $casts = [
        'payload' => 'array',
        
    ];
}
