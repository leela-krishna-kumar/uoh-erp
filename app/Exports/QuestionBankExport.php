<?php

namespace App\Exports;

use App\Models\QuestionBank;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionBankExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $question_banks = QuestionBank::get();
        $data = collect();
        foreach ($question_banks as $question_bank) {
            $data->push([
                'id' => $question_bank->id,
                'subject_id' => $question_bank->subject_id,
                'question' => $question_bank->question,
                'options' => $question_bank->options,
                'correct_option' => $question_bank->correct_options,
                'type' => $question_bank->type,
                'level' => $question_bank->level,
                'created_by' => $question_bank->created_by,
                'status' => $question_bank->status,
            ]);
        }
        return $data;
    }


    public function headings(): array
    {
        return ['id','subject_id','question','options','correct_option', 'type', 'level', 'created_by', 'status'];
    }

}
