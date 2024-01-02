<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\User;

class QuestionBank extends Model
{
    use HasFactory;

    public const TYPE_SINGLE_ANSWER = 0;
    public const TYPE_MULTI_ANSWER = 1;
    public const TYPE_WRITTEN = 2;
    public const TYPE_FILE_UPLOAD = 3;

    protected $casts = [
        'correct_options' =>  'array',
        'options' =>  'array',
    ];
    public const QUESTION_TYPES = [
        "0" => ['label' =>'Single Answer','color' => 'primary','type' => 'single'],
        "1" => ['label' =>'Multi Answer','color' => 'secondary','type' => 'multi'],
        "2" => ['label' =>'Fill in Blank','color' => 'success','type' => 'blank'],
        "3" => ['label' =>'TRUE/FALSE','color' => 'info','type' => 'boolean'],
    ];

    public const STATUS_IN_REVIEWED = 0;
    public const STATUS_REVIEWED = 1;

    public const STATUSES = [
        "0" => ['label' =>'In Reviewed','color' => 'primary'],
        "1" => ['label' =>'Reviewed','color' => 'secondary'],
    ];

    protected function statusParsed(): Attribute
    {
        return Attribute::make(
            get: fn ($value) =>  (object)self :: QUESTION_TYPES[$this->type],
        );
    }


    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


}
