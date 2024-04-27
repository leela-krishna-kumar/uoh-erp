<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffBookPublish extends Model
{
    use HasFactory;
    protected $table = 'staff_book_publishions';

    protected $fillable = [
        'staff_id', 'published_book_title', 'published_chapter_title', 'publication_year', 'isbn_number', 'same_affiliating_institute', 'publisher_name'
    ];
}
