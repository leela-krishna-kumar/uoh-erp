<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class ELesson extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public const TYPE_VIDEO = 0;
    public const TYPE_LIVE = 1;
    public const TYPE_EBOOK = 2;
    public const TYPE_TEST = 3;

    public const TYPES = [
        "0" => ['label' =>'Video','color' => 'primary'],
        "1" => ['label' =>'Live','color' => 'success'],
        "2" => ['label' =>'Ebook','color' => 'danger'],
        "3" => ['label' =>'Test','color' => 'danger'],
    ];
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function section()
    {
        return $this->belongsTo(ESection::class,'e_section_id');
    }
    
 
}
