<?php

namespace App\Imports;

use App\Models\Patent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Auth;

class PatentImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $data = $rows->toArray();
        $rules = [];
        foreach ($data as $key => $item) {
            $customMessages[""] = '';
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            $new_journal = Patent::create(
                [
                    'staff_id' => Auth::user()->staff_id ,
                    'patent_application_no' => $row['patent_application_no'],
                    'status_of_patent' => $row['status_of_patent'],
                    'patent_inventor' => $row['patent_inventor'],
                    'title_of_patent' => $row['title_of_patent'],
                    'patent_applicant' => $row['patent_applicant'],
                    'patent_published_date' => $row['patent_published_date'],
                    'link' => $row['link'],

                ]
            );
        }
    }
}
