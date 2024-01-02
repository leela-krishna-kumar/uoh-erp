<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Grievance extends Model
{
    use HasFactory;

    public const STATUS_INREVIEW = 0;
    public const STATUS_RESOLVED = 1;

    public const STATUSES = [
        "0" => ['label' =>' In Review','color' => 'primary'],
        "1" => ['label' =>'Resolved','color' => 'success'],
    ];
    public function  user(){
        return  $this->belongsTo(User::class,'user_id','id');
    }  
 
    public function  department(){
        return  $this->belongsTo(Department::class,'department_id','id');
    }  
    public function  category(){
        return  $this->belongsTo(GrievanceCategory::class,'category_id','id');
    }  
    public function getPrefix() {
        return "#ID".str_replace('_1','','_'.(100000 +$this->id));
    }
    public function  student(){
        return  $this->belongsTo(Student::class,'user_id','id');
    }  
}
