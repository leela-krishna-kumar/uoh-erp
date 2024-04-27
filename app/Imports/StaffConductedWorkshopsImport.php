<?php

namespace App\Imports;

use App\Models\StaffWorkShop;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Auth;

class StaffConductedWorkshopsImport implements ToCollection, WithHeadingRow
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
            $rules["$key.workshop_name"] =  'required';
            $rules["$key.link"] =  'required';
            $customMessages["$key.workshop_name.required"] = 'The workshop_name required at row.' . ($key + 2);
            $customMessages["$key.link.required"] = 'The link is required at row.'.($key+2);
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            $new_journal = StaffWorkShop::create(
                [
                    'staff_id' => Auth::user()->staff_id ,
                    'workshop_name' => $row['workshop_name'],
                    'workshop_type' => $row['workshop_type'],
                    'no_of_participants' => $row['no_of_participants'],
                    'from_date' => $row['from_date'],
                    'to_date' => $row['to_date'],
                    'link' => $row['link'],
                    'brochure_link' => $row['brochure_link'],
                    'certificate_link' => $row['certificate_link'],
                    'schedule_link' => $row['schedule_link'],
                    'from_year' => $row['from_year'],
                    'to_year' => $row['to_year'],


                ]
            );
        }
    }
}
