<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seedgrant extends Model
{
    use HasFactory;
   // protected $table = "seedgrants";
   protected $fillable = [
    'staff_id', 'application_no', 'title', 'pi', 'co_pi', 'duration_in_months', 'scope', 'research_area', 'amount_in_rupees','department',
];
}
