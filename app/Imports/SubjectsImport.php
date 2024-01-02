<?php

namespace App\Imports;

use App\Models\Subject;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;

class SubjectsImport implements ToCollection, WithHeadingRow
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
                Rule::unique('subjects', 'title')->ignore($item['id'] ? $item['id'] : null, 'id')
            ];
            $rules["$key.code"] = [
                'required',
                Rule::unique('subjects', 'code')->ignore($item['id'] ? $item['id'] : null, 'id')
            ];
            $rules["$key.credit_hour"] =  'required|numeric';
            $rules["$key.subject_type"] =  'required|integer';
            $rules["$key.class_type"] =  'required|integer';
            $rules["$key.status"] =  'required|integer';
            $customMessages["$key.title.required"] = 'The title is required at row.'.($key+2);
            $customMessages["$key.title.unique"] = 'The title must be unique at row.'.($key+2);
            $customMessages["$key.code.unique"] = 'The code must be unique at row.'.($key+2);
            $customMessages["$key.credit_hour.required"] = 'The credit hour is required at row.'.($key+2);
            $customMessages["$key.credit_hour.numeric"] = 'The credit hour must be numeric at row.'.($key+2);
            $customMessages["$key.subject_type.required"] = 'The subject type is required at row.'.($key+2);
            $customMessages["$key.subject_type.numeric"] = 'The subject type must be numeric at row.'.($key+2);
            $customMessages["$key.class_type.required"] = 'The class type is required at row.'.($key+2);
            $customMessages["$key.class_type.numeric"] = 'The class type must be numeric at row.'.($key+2);
            $customMessages["$key.status.required"] = 'The status is required at row.'.($key+2);
        }
       
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        // Validator::make($rows->toArray(), [
        //     '*.title' => 'required|max:191',
        //     '*.code' => 'required|max:191',
        //     '*.credit_hour' => 'required|numeric',
        //     '*.subject_type' => 'required|integer',
        //     '*.class_type' => 'required|integer',
        //     '*.status' => 'required|integer',
        // ])->validate();


        foreach ($rows as $row) {
            if($row['id']){
                $subject= Subject::find($row['id']);
                if($subject){
                    $subject->title = $row['title'];
                    $subject->code = $row['code'];
                    $subject->credit_hour = $row['credit_hour'];
                    $subject->subject_type = $row['subject_type'];
                    $subject->class_type = $row['class_type'];
                    $subject->status = $row['status'];
                    $subject->save();
                }
            }else{
                $subject= Subject::where('title',$row['title'])->orWhere('code',$row['code'])->first();
                if(!$subject){
                    $subject = New Subject;
                    $subject->title = $row['title'];
                    $subject->code = $row['code'];
                    $subject->credit_hour = $row['credit_hour'];
                    $subject->subject_type = $row['subject_type'];
                    $subject->class_type = $row['class_type'];
                    $subject->status = $row['status'];
                    $subject->save();
                }
            }
        }
    }
}
