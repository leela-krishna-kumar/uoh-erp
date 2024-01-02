<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class UserLog extends Model
{
    use HasFactory;



     public const TYPES = [
     "0" => ['label' =>'Log In','color' => 'primary'],
     "1" => ['label' =>'Log Out','color' => 'danger'],
     ];

     public const Types_Log_In = 0;
     public const Types_Log_Out = 1;


      public function user()
      {
      return $this->belongsTo(User::class,'user_id','id');
      }
}
