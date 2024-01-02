<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Program;
use App\Models\Faculty;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Toastr;

class ProgramsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.faculty_id' => 'required|numeric',
            '*.title' => 'required|max:191',
            '*.shortcode' => 'required|max:191',
        ])->validate();
  
        foreach ($rows as $row) {
            // $faculty = Faculty::find($row['faculty_id']);
            // if(!$faculty){
            //     Toastr::error(__('faculty not found'), __('msg_error'));
            //     return redirect()->back();
            // }
            if($row['id']){
                $program= Program::find($row['id']);
                if($program){
                    $program->title = $row['title'];
                    $program->faculty_id = $row['faculty_id'];
                    $program->slug = Str::slug($row['title'], '-');
                    $program->shortcode = $row['shortcode'];
                    $program->save();
                }
            }else{
                Program::create(
                    [
                    'faculty_id'     => $row['faculty_id'],
                    'title'     => $row['title'],
                    'slug'     =>  Str::slug($row['title'], '-'),
                    'shortcode'     => $row['shortcode'],
                ]);
            }
            
        }
    }
}
