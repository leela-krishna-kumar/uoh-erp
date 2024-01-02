<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportVehicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'transport_vehicles';
    protected $fillable = [
        'number', 'type', 'model', 'capacity', 'year_made', 'driver_name', 'driver_license', 'driver_contact', 'note', 'status',
    ];

    public const TYPE_BUS = 0;
    public const TYPE_CAR = 1;
    public const TYPE_VAN = 2;
    public const TYPE_MOTORCYCLE = 3;
    public const TYPES = [
        "0" => ['label' =>'Bus','color' => 'danger'],
        "1" => ['label' =>'Car','color' => 'success'],
        "2" => ['label' =>'Van','color' => 'info'],
        "3" => ['label' =>'Motor Cycle','color' => 'danger'],
    ];

    public function transportRoutes()
    {
        return $this->belongsToMany(TransportRoute::class, 'transport_route_transport_vehicle', 'transport_vehicle_id', 'transport_route_id');
    }

    public function transportMembers()
    {
        return $this->hasMany(TransportMember::class, 'transport_vehicle_id', 'id');
    }
    
}
