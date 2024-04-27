<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;


class JournalsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {

        $data = collect();
            $data->push([
                'title_of_paper' => "Energy efficient service placement in fog computing",
                'name_of_the_author' => "V.Usha, Asst.Prof",
                'name_of_the_journal' => "PeerJ Computer Science",
                'year_of_publication' => "2022",
                'issn_number' => "2376-5992",
                'journal_website_link' => "https://peerj.com/computer-science/",
                'paper_abstract_article_link' => 'https://peerj.com/articles/cs-1035.pdf'
            ]);
        return $data;
    }


    public function headings(): array
    {
        return ['title_of_paper','name_of_the_author', 'name_of_the_journal', 'year_of_publication', 'issn_number', 'journal_website_link','paper_abstract_article_link'];

    }

}
