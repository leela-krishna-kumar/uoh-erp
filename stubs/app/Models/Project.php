<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'project_category_id', 'tags', 'type', 'type_id',
    ];

    public const STATUS_ASSIGNED = 0;
    public const STATUS_DRAFT = 1;
    public const STATUS_IN_REVIEW = 2;
    public const STATUS_REJECTED = 3;
    public const STATUS_REVIEWED = 4;

    public const STATUSES = [
        "0" => ['label' =>'Assigned','color' => 'primary'],
        "1" => ['label' =>'Draft','color' => 'secondary'],
        "2" => ['label' =>'In Review','color' => 'info'],
        "3" => ['label' =>'Rejected','color' => 'danger'],
        "4" => ['label' =>'Reviewed','color' => 'success'],
    ];

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'type_id');
    }
}
