<?php

namespace App\Imports;

use App\Models\Seedgrant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Auth;

class SeedgrantsImport implements ToCollection, WithHeadingRow
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
            $rules["$key.application_no"] =  'required';
            $rules["$key.title"] =  'required';
            $rules["$key.amount_in_rupees"] =  'required';
            $customMessages["$key.application_no.required"] = 'The application_no required at row.' . ($key + 2);
            $customMessages["$key.title.required"] = 'The title is required at row.'.($key+2);
            $customMessages["$key.amount_in_rupees.required"] = 'The amount_in_rupees is required at row.'.($key+2);
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            $new_journal = Seedgrant::create(
                [
                    'staff_id' => Auth::user()->staff_id,
                    'department' =>Auth::user()->department_id,
                    'application_no' => $row['application_no'] ,
                    'title' => $row['title'],
                    'pi' => json_encode([$row['pi']]),
                    'co_pi' => json_encode([$row['co_pi']]),
                    'duration_in_months' => $row['duration_in_months'],
                    'scope' => $row['scope'],
                    'research_area' => $row['research_area'],
                    'amount_in_rupees' => $row['amount_in_rupees'],

                ]
            );
        }
    }
}
