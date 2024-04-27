<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;


class StaffBookPublishionExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {

        $data = collect();
            $data->push([
                'published_book_title' => "Dynamic Ideas",
                'published_chapter_title' => "Design Thinking and its Application",
                'publication_year' => "2002",
                'isbn_number' => "978-93-5473-386-4",
                'same_affiliating_institute' => "1",
                'publisher_name' => "Sri Siddivinayaka Global Publication",
            ]);
        return $data;
    }


    public function headings(): array
    {
        return ['published_book_title','published_chapter_title', 'publication_year', 'isbn_number', 'same_affiliating_institute', 'publisher_name'];

    }

}
