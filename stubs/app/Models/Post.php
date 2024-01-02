<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
    use HasFactory;

    public const TYPE_IMAGE = 0;
    public const TYPE_VIDEO = 1;
    public const TYPE_GIF = 2;
    public const TYPE_LINK = 3;

    public const TYPES = [
        "0" => ['label' =>'Image','color' => 'warning'],
        "1" => ['label' =>'Video','color' => 'secondary'],
        "3" => ['label' =>'GIF','color' => 'success'],
        "4" => ['label' =>'Link','color' => 'info'],
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id');
    }

}
