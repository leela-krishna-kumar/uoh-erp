<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAccordion extends Model
{
    use HasFactory;

    public const STATUS_BACK_VOLUMES = 0;
    public const STATUS_AVAILABLE = 1;
    public const STATUS_RESERVED = 2;
    public const STATUSES = [
        "0" => ['label' =>'Back Volumes','color' => 'primary'],
        "1" => ['label' =>'Available','color' => 'success'],
        "2" => ['label' =>'Reserved','color' => 'success']
    ];

    public function book()
    {
     return $this->belongsTo(Book::class, 'book_id');
    }
       
    public function department()
    {
    return $this->belongsTo(Department::class, 'department_id');
    }

}
