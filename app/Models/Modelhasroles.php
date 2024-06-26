<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modelhasroles extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $table = "model_has_roles";

    protected $fillable = [
        'driver', 'host', 'port', 'username', 'password', 'encryption', 'sender_email', 'sender_name', 'reply_email', 'status',
    ];
}
