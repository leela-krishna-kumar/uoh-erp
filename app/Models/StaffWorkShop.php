<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffWorkShop extends Model
{
    use HasFactory;
    protected $table = 'staff_conducted_workshops';

    protected $fillable = [
        'staff_id', 'workshop_name', 'workshop_type', 'no_of_participants', 'from_date', 'to_date', 'link', 'brochure_link','brochure_attach','certificate_link','certificate_attach','schedule_link','from_year','schedule_attach','to_year'
    ];
}
