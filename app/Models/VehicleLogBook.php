<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class VehicleLogBook extends Model
{
    use HasFactory;


 public function vehicleLog()
 {
  return $this->belongsTo(TransportVehicle::class,'vehicle_id','id');
 }
   public function driver()
   {
   return $this->belongsTo(User::class,'driver_id','id');
   }
}
