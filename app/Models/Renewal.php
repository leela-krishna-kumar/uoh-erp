<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renewal extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(RenewalCategory::class,'renewal_category_id');
    }
    public function vehicle()
    {
        return $this->belongsTo(TransportVehicle::class,'vehicle_id');
    }
}
