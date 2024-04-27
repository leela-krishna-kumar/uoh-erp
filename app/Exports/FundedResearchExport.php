<?php

namespace App\Exports;

use App\Models\FundedResearch;
use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Auth;


class FundedResearchExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        // $records = FundedResearch::where('staff_id', Auth::user()->staff_id)->limit(1)->get();
        // $data = collect();
        // foreach ($records as $record) {
        //     $data->push([
        //         'pi_or_co_pi' => $record->pi_or_co_pi,
        //         'funding_agency' => $record->funding_agency,
        //         'sponsored_project' => $record->sponsored_project,
        //         'funds_provided' => $record->funds_provided,
        //         'grant_month_and_year' => $record->grant_month_and_year,
        //         'status' => $record->status,
        //         'project_duration' => $record->project_duration,
        //         'type' => $record->type,
        //     ]);
        // }
        $data = collect();
            $data->push([
                'pi_or_co_pi' => "Dr.Narender",
                'funding_agency' => "Technical Education Quality",
                'sponsored_project' => "Molecules Complexes of drugs",
                'funds_provided' => "30,000",
                'grant_month_and_year' => "2024-03 (Should be same format)",
                'status' => "Completed",
                'project_duration' => 3,
                'type' => "Government",
            ]);
        return $data;
    }


    public function headings(): array
    {
        return ['pi_or_co_pi','funding_agency', 'sponsored_project', 'funds_provided', 'grant_month_and_year', 'project_duration','type', 'status'];

    }

}
