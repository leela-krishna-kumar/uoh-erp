<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlacedStudent extends Model
{
    use HasFactory;

    protected $casts = [
        'student_id' => 'array', 'criteria_description' => 'array'
    ];

    public const STATUS_APPLIED = 0;
    public const STATUS_SHORTLISTED= 1;
    public const STATUS_PLACED = 2;
    public const STATUS_REJECTED = 3;

    public const STATUSES = [
        "0" => ['label' =>'Applied','color' => 'primary'],
        "1" => ['label' =>'Shortlisted','color' => 'secondary'],
        "2" => ['label' =>'Placed','color' => 'success'],
        "3" => ['label' =>'Rejected','color' => 'danger'],
    ];


    public function getFullNameAttribute() {
        return ucwords($this->first_name.' '.$this->last_name);
    }

    public function getPrefix() {
        return "#ID".str_replace('_1','','_'.(100000 +$this->id));
    }
    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    } 
}
