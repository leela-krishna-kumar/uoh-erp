<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Experience extends Model
{
    protected $table = 'experiences';
    protected $guarded = ['id'];
    use HasFactory;
    public const TYPE_TEACHING = 0;
    public const TYPE_WORKING = 1;
    public const TYPE_RESEARCH = 2;
    public const TYPES = [
        "0" => ['label' =>'Teaching','color' => 'danger'],
        "1" => ['label' =>'Working','color' => 'success'],
        "2" => ['label' =>'Research','color' => 'success'],
    ];
    protected function typeParsed(): Attribute
    {
        return Attribute::make(
            get: fn ($value) =>  (object)self :: TYPES[$this->type],
        );
    }
}
