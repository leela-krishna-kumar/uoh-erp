<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Placement extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'date', 'description',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
