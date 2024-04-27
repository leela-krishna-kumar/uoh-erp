<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;


class SeedgrantsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {

        $data = collect();
            $data->push([
                'application_no' => "1105",
                'title' => "amount_in_rupees",
                'pi' => "name2,name2",
                'co_pi' => "name1,name2",
                'duration_in_months' => "2",
                'scope' => 'data analatics',
                'research_area' =>'Area',
                'amount_in_rupees' =>'2000',
            ]);
        return $data;
    }


    public function headings(): array
    {
        return ['application_no','title', 'pi', 'co_pi', 'duration_in_months','scope','research_area','amount_in_rupees'];

    }

}
