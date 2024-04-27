<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;


class AwardsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {

        $data = collect();
            $data->push([
                'award_name' => "Distinguished Alumni Award",
                'awarding_agency' => "Distinguished Alumni award",
                'date' => "2023-12-23",
            ]);
        return $data;
    }


    public function headings(): array
    {
        return ['award_name','awarding_agency', 'date'];

    }

}
