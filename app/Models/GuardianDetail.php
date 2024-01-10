<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuardianDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'];

        public function relation()
        {
            return $this->belongsTo(Relation::class,'relation_id');
        } 
}
