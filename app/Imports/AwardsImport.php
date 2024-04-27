<?php

namespace App\Imports;

use App\Models\awards;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Auth;

class AwardsImport implements ToCollection, WithHeadingRow
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
            $rules["$key.award_name"] =  'required';
            $rules["$key.awarding_agency"] =  'required';
            $rules["$key.date"] =  'required';
            $customMessages["$key.award_name.required"] = 'The award_name required at row.' . ($key + 2);
            $customMessages["$key.awarding_agency.required"] = 'The awarding_agency is required at row.'.($key+2);
            $customMessages["$key.date.required"] = 'The date is required at row.'.($key+2);
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            $new_journal = awards::create(
                [
                    'staff_id' => Auth::user()->staff_id ,
                    'award_name' => $row['award_name'],
                    'awarding_agency' => $row['awarding_agency'],
                    'date' => $row['date'],

                ]
            );
        }
    }
}
