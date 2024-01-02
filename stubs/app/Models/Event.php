<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'start_date','end_date', 'color', 'status',
    ];


    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_id');
    }
    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }
}
