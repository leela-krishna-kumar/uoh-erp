<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;


class StaffConductedWorkshopsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {

        $data = collect();
            $data->push([
                'workshop_name' => "FDP on Entrepreneurship",
                'workshop_type' => "Workshop",
                'no_of_participants' => "20",
                'from_date' => "2021-07-08",
                'to_date' => "2021-10-08",
                'link' => 'https://gnits.ac.in/proof/H_M/H_M-65.pdf',
                'brochure_link' =>'https://gnits.ac.in/proof/H_M/H.pdf',
                // 'brochure_attach' =>'2000',
                'certificate_link'=>"https://gnits.ac.in/proof/H_M/H_M-65.pdf",
                // 'certificate_attach' =>"",
                'schedule_link' => "https://gnits.ac.in/proof/H_M/H_M-65.pdf",
                // 'schedule_attach' => "",
                'from_year' => "2021",
                'to_year' => "2022"
            ]);
        return $data;
    }


    public function headings(): array
    {
        return ['workshop_name','workshop_type', 'no_of_participants', 'from_date', 'to_date','link','brochure_link','certificate_link','schedule_link','from_year','to_year'];

    }

}
