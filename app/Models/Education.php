<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $fillable = [
        'hall_ticket_no','year_of_passing','marks', 'percenteage', 'institution', 'grade','board','entrance_type','rank'];

    protected $casts = [
        'payload' => 'array',
        
    ];

}
