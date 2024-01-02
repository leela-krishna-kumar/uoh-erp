<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Placement extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'date', 'description','category_id','deadline_date','required_document',
    ];
    protected $casts = [
        'criteria_description' => 'array',
        ];
    public function category()
    {
        return $this->belongsTo(PlacementCategory::class, 'category_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function candidates()
    {
        return $this->hasMany(PlacedStudent::class,'placement_id');
    }

   
}
