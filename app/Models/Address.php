<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'address_line_2','address_line_1','pincode','payload','country_id','state_id','city_id','model_type','model_id','type','is_permanent'
    ];

    protected $casts = [
        'payload' => 'array'
    ];

    
    public const TYPES_ACTIVE = 0;
    public const TYPES_INACTIVE = 1;

    public const TYPES = [
        "0" => ['label' =>'Active','color' => 'success'],
        "1" => ['label' =>'In Active','color' => 'danger'],
    ];
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function state()
    {
        return $this->belongsTo(Province::class, 'state_id', 'id');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'city_id', 'id');
    }

}
