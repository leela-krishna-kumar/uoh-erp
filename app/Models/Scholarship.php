<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    public const STATUS_HAVE_QUOTA = 0;
    public const STATUS_NO_QUOTA = 1;
    public const STATUS_OVER_QUOTA = 2;
    public const STATUSES = [
        "0" => ['label' =>'Have Quota','color' => 'primary'],
        "1" => ['label' =>'No Quota','color' => 'success'],
        "2" => ['label' =>'Over Quota','color' => 'danger'],
    ];
    public function  donors(){
        return  $this->belongsTo(Donor::class,'donor_id','id');
    }  
    public function  students(){
        return  $this->hasMany(ScholarshipStudent::class,'scholarship_id','id');
    }  

}
