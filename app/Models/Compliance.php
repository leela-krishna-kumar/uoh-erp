<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compliance extends Model
{

    public function category()
    {
        return $this->belongsTo(ComplianceCategory::class, 'category_id');
    }
    public function attachments()
    {
        return $this->hasMany(ComplianceAttachment::class, 'compliance_id');
    }
}
