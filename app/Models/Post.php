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

    public const STATUSES_IN_REVIEW = 0;
    public const STATUSES_APPROVED = 1;
    public const STATUSES_REJECTED = 2;

    public const STATUSES = [
        "0" => ['label' =>'In Review','color' => 'warning'],
        "1" => ['label' =>'Approved','color' => 'secondary'],
        "3" => ['label' =>'Rejected','color' => 'success'],
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id')->where('type',Post::Class)->groupBy('user_id');
    }

    public function postComment()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }
    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }

}
