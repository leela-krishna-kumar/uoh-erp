<?php

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counselling extends Model
{
    use HasFactory;

    public const STATUS_SCHEDULED = 0;
    public const STATUS_REQUESTED = 1;
    public const STATUS_COMPLETED = 2;
    public const STATUS_CANCELLED = 3;

    public const STATUSES = [
        "0" => ['label' =>'Scheduled','color' => 'primary'],
        "1" => ['label' =>'Requested','color' => 'secondary'],
        "2" => ['label' =>'Completed','color' => 'success'],
        "3" => ['label' =>'Cancelled','color' => 'danger'],
    ];

    protected $fillable = [
        'counselling_category_id','counselled_by',
    ];

    public function category()
    {
        return $this->belongsTo(CounsellingCategory::class, 'counselling_category_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'manager_ids');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'counselled_by');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'type_id');
    }

    public function students()
    {
        return $this->belongsTo(Student::class);
    }
}