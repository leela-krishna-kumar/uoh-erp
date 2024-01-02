<?php

namespace App\Imports;

use App\Models\QuestionBank;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;

class QuestionBankImport implements ToCollection, WithHeadingRow
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
            $rules["$key.subject_id"] =  'required';
            $rules["$key.question"] =  'required';
            $customMessages["$key.subject_id.required"] = 'The subject_id is required at row.'.($key+2);
            $customMessages["$key.question.required"] = 'The question is required at row.'.($key+2);
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            if($row['id']){
                $question_bank = QuestionBank::find($row['id']);
                if ($question_bank) {
                    $question_bank->update(
                      [
                        'subject_id' => $row['subject_id'],
                        'question' => $row['question'],
                        'options' => $row['options'],
                        'correct_option' => $row['correct_option'],
                        'type' => $row['type'],
                        'level' => $row['level'],
                        'created_by' => $row['created_by'],
                        'status' => $row['status'],
                      ]);
                }
            }else{
                $question_bank = QuestionBank::create(
                    [
                        'subject_id' => $row['subject_id'],
                        'question' => $row['question'],
                        'options' => $row['options'],
                        'correct_option' => $row['correct_option'],
                        'type' => $row['type'],
                        'level' => $row['level'],
                        'created_by' => $row['created_by'],
                        'status' => $row['status'],
                    ]);
            }
        }
    }
}
