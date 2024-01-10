<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class UserBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_no'
    ];

    protected $casts = [
        'payload' => 'json'
    ];


    public const STATUS_ACTIVE = 0;
    public const STATUS_INACTIVE = 1;
 

    public const STATUSES = [
        "0" => ['label' =>'Active','color' => 'success'],
        "1" => ['label' =>'In Active','color' => 'danger'],
    ];

    public const  BANKS_SBI = 0;
    public const BANKS_HDFC = 1;

    public const BANKS = [
        "0" => ['label' =>'SBI','color' => 'primary'],
        "1" => ['label' =>'HDFC','color' => 'success'],
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class,'type_id');
    }




    
}
