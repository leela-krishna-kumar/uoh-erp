<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;


    protected $fillable = [
        'title', 'slug', 'description', 'status',
    ];

    public function provinces()
    {
        return $this->hasMany(Province::class, 'country_id', 'id');
    }

    public function studentPresentCountry()
    {
        return $this->hasMany(Student::class, 'present_country');
    }

    public function studentPermanentCountry()
    {
        return $this->hasMany(Student::class, 'permanent_country');
    }

    

}
