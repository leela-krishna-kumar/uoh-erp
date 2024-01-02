<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BooksExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Book::get(['category_id', 'title', 'isbn', 'author', 'publisher', 'edition', 'publish_year', 'language', 'price', 'description', 'note', 'status','call_no','from_acc_no','to_acc_no','volume','currency','department','subject','course','book_type','book_size','no_of_pages','issue_books','ref_books','supplier','invoice_no','invoice_date','enclose_type','enclose_items','ddc_1','ddc_2','ddc_3','prefix','suffix','rack_no','sub_rack_no','publisher_place']);
    }


    public function headings(): array
    {
        return ['category_id', 'title', 'isbn', 'author', 'publisher', 'edition', 'publish_year', 'language', 'price', 'description', 'note', 'status','call number','from_account_number','to_account_number','volume','currency','department','subject','course','book_type','book_size','number_of_pages','issue_books','ref_books','supplier','invoice_no','invoice_date','enclose_type','enclose_items','ddc_1','ddc_2','ddc_3','prefix','suffix','rack_no','sub_rack_no','publisher_place'];
    }
}
