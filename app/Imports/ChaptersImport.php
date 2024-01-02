<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Chapter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Toastr;

class ChaptersImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.subject_id' => 'required|numeric',
            '*.name' => 'required',
            '*.start_date' => 'required|date',
            '*.end_date' => 'required|date',
            '*.status' => 'required|integer',
        ])->validate();
  

        foreach ($rows as $row) {
            if($row['id']){
                $chapter= Chapter::find($row['id']);
                if($chapter){
                    $chapter->name = $row['name'];
                    $chapter->subject_id = $row['subject_id'];
                    $chapter->note = $row['note'];
                    $chapter->start_date = $row['start_date'];
                    $chapter->end_date = $row['end_date'];
                    $chapter->status = $row['status'];
                    $chapter->save();
                }
            }else{
                Chapter::create(
                    [
                     'name'     => $row['name'],
                     'subject_id'     => $row['subject_id'],
                     'note'     => $row['note'],
                     'start_date'     => $row['start_date'],
                     'end_date'     => $row['end_date'],
                     'status'     => $row['status'] ? $row['status'] : '1',
                 ]);
            }
        }
    }
}
