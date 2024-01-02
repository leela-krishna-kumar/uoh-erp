<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    protected $table = 'faqs';

    public const  STATUS_PUBLIISHED = 0;
    public const STATUS_UNPUBLIISHED = 1;
   

    public const STATUSES = [
        "0" => ['label' =>'Published','color' => 'success'],
        "1" => ['label' =>'Unpublished','color' => 'danger'],
   
    ];
    public function category()
    {
        return $this->belongsTo(FAQCategory::class, 'category_id');
    }

}
