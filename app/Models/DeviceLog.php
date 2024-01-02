<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceLog extends Model
{
    use HasFactory;

    
    public const STATUS_MOVING = 0;
    public const STATUS_PARKED = 1;
    public const STATUS_STOPPED = 2;


    public const STATUSES = [
        "0" => ['label' =>'Moving','color' => 'primary'],
        "1" => ['label' =>'Parked','color' => 'success'],  
        "2" => ['label' =>'Stopped','color' => 'danger'],  
    ];

    protected $appends = ['status_name'];
    
    public function getStatusNameAttribute(){
        $status = DeviceLog::STATUSES[$this->status]['label'];
        return $status;
    }

    public function  fleet(){
        return  $this->belongsTo(Fleets::class,'fleet_id','id');
    }  


}

