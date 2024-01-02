<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Topic;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Toastr;

class TopicsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.chapter_id' => 'required|numeric',
            '*.name' => 'required',
            '*.start_date' => 'required|date',
            '*.end_date' => 'required|date',
            '*.status' => 'required|integer',
        ])->validate();
  

        foreach ($rows as $row) {
            if($row['id']){
                $topic= Topic::find($row['id']);
                if($topic){
                    $topic->name = $row['name'];
                    $topic->chapter_id = $row['chapter_id'];
                    $topic->note = $row['note'];
                    $topic->start_date = $row['start_date'];
                    $topic->end_date = $row['end_date'];
                    $topic->status = $row['status'];
                    $topic->save();
                }
            }else{
                Topic::create(
                    [
                     'name'     => $row['name'],
                     'chapter_id'     => $row['chapter_id'],
                     'note'     => $row['note'],
                     'start_date'     => $row['start_date'],
                     'end_date'     => $row['end_date'],
                     'status'     => $row['status'] ? $row['status'] : '1',
                 ]);
            }
            
        }
    }
}
