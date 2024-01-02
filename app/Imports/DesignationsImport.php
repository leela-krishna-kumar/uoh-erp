<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Designation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Toastr;

class DesignationsImport implements ToCollection, WithHeadingRow
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
            $rules["$key.title"] = [
                'required',
                Rule::unique('designations', 'title')->ignore($item['id'] ? $item['id'] : null, 'id')
            ];
            $customMessages["$key.title.required"] = 'The title is required at row.'.($key+2);
            $customMessages["$key.title.unique"] = 'The title must be unique at row.'.($key+2);
        }
       
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();
        // Validator::make($rows->toArray(), [
        //     '*.title' => 'required',
        // ])->validate();
  

        foreach ($rows as $row) {
            if($row['id']){
                $designation= Designation::find($row['id']);
                if($designation){
                    $designation->title = $row['title'];
                    $designation->slug = Str::slug($row['title'], '-');
                    $designation->job_description = $row['job_description'];
                    $designation->filled_positions = $row['filled_positions'];
                    $designation->total_positions = $row['total_positions'];
                    $designation->save();
                }
            }else{
                $designation = Designation::where('title','like', $row['title'])->first();
                if(!$designation){
                    $designation= New Designation;
                    $designation->title = $row['title'];
                    $designation->slug = Str::slug($row['title'], '-');
                    $designation->job_description = $row['job_description'];
                    $designation->filled_positions = $row['filled_positions'];
                    $designation->total_positions = $row['total_positions'];
                    $designation->save();
                }
            }
        }
    }
}
