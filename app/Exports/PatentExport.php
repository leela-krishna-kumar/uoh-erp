<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PatentExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {

        $data = collect();
            $data->push([
                'patent_application_no' => "202341029247A",
                'status_of_patent' => "Published",
                'patent_inventor' => "Prabhakar Bethapudi",
                'title_of_patent' => "Examining The Effects Of Product Descriptions, Reviews, And Ratings On Consumer Purchase Decision",
                'patent_applicant' => "Dr.Vijaya Lakshmi V",
                'patent_published_date' => "2023-05-16",
                'link' => 'https://peerj.com/articles/cs-1035.pdf'
            ]);
        return $data;
    }


    public function headings(): array
    {
        return ['patent_application_no','status_of_patent', 'patent_inventor', 'title_of_patent', 'patent_applicant', 'patent_published_date','link'];

    }

}
