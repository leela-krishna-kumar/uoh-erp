<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
class ApprovalSubmission extends Model
{
    use HasFactory;

    
    public const STATUS_IN_REVIEW = 0;
    public const STATUS_APPROVED = 1;
    public const STATUS_REJECTED = 2;

    public const STATUSES = [
        "0" => ['label' =>'InReview','color' => 'primary'],
        "1" => ['label' =>'Approved','color' => 'success'],
        "2" => ['label' =>'Rejected','color' => 'danger'],
    ];
    public function  student(){
        return  $this->belongsTo(Student::class,'user_id','id');
    }  
    public function  user(){
        return  $this->belongsTo(User::class,'user_id','id');
    }  
    public function  approver(){
        return  $this->belongsTo(User::class,'approver_id','id');
    }  
    public function getPrefix() {
        return "#SAID".str_replace('_1','','_'.(100000 +$this->id));
    }
    public function category()
    {
        return $this->belongsTo(ApprovalSubmissionCategory::class, 'category_id');
    }
}
