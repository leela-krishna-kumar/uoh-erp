<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundedResearch extends Model
{
    use HasFactory;
    protected $fillable = [
        'staff_id', 'pi_or_co_pi', 'funding_agency', 'sponsored_project', 'funds_provided','grant_month_and_year','project_duration','type','status'
    ];


}
