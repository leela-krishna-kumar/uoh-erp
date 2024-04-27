<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\PatentController;

class Patent extends Model
{
    protected $table = 'patent';
    // use HasFactory;
     protected $fillable = ['staff_id','name_of_the_author','patent_application_no','status_of_patent','patent_inventor','title_of_patent','patent_applicant','patent_published_date','link'];

}
