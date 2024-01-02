<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Fleets extends Model
{
    use HasFactory;

    public const STATUS_TRACKING_ON = 0;
    public const STATUS_TRACKING_OFF = 1;

    protected $guarded = ['id'];

    public const STATUSES = [
        "0" => ['label' =>' Tracking on','color' => 'primary'],
        "1" => ['label' =>'Tracking off','color' => 'danger'],  
    ];
    protected $appends = ['status_name'];
    
    public function getStatusNameAttribute(){
        $status = Fleets::STATUSES[$this->status]['label'];
        return $status;
    }

    public function  user(){
        return  $this->belongsTo(User::class,'driver_id','id');
    }  

}
