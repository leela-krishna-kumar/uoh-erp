<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;
    protected $fillable = [
        'staff_id', 'title_of_paper', 'name_of_the_author', 'name_of_the_journal', 'year_of_publication', 'issn_number', 'journal_website_link', 'paper_abstract_article_link'
    ];
}
