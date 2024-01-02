<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Faculty;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FacultiesImport implements ToCollection, WithHeadingRow
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
                Rule::unique('faculties', 'title')->ignore($item['id'] ? $item['id'] : null, 'id')
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
            // Faculty::updateOrCreate(
            //     [
            //     'title'     => $row['title'],
            //     'slug'     =>  Str::slug($row['title'], '-'),
            //     'shortcode'     => $row['shortcode'],
            // ]);
            if($row['id']){
                $faculty= Faculty::find($row['id']);
                if($faculty){
                    $faculty->title = $row['title'];
                    $faculty->slug = Str::slug($row['title'], '-');
                    $faculty->shortcode = $row['shortcode'];
                    $faculty->save();
                }
            }else{
                $faculty = Faculty::where('title','like', $row['title'])->first();
                if(!$faculty){
                    Faculty::create(
                        [
                        'title'     => $row['title'],
                        'slug'     =>  Str::slug($row['title'], '-'),
                        'shortcode'     => $row['shortcode'],
                    ]);
                }
            }
        }
    }
}
