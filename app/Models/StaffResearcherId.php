<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffResearcherId extends Model
{
    use HasFactory;
    protected $table = 'staff_researcher_ids';

    protected $fillable = [
        'user_id', 'staff_id', 'vidwan_id', 'orcid_id', 'researcher_id', 'scopus_id', 'google_scholar_id', 'wos_id'
    ];
}
