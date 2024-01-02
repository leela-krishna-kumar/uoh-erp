<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = [
        'id'
    ];

    public const PAYMENT_STATUS_UNPAID = 0;
    public const PAYMENT_STATUS_PAID = 1;

    public const STATUSES = [
        "0" => ['label' =>'Unpaid','color' => 'danger'],
        "1" => ['label' =>'Paid','color' => 'success'],
    ];

    public function category()
    {
        return $this->belongsTo(IncomeCategory::class, 'category_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class,'type_id','id');
    }
}
