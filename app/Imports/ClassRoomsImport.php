<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\ClassRoom;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Toastr;

class ClassRoomsImport implements ToCollection, WithHeadingRow
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
                Rule::unique('class_rooms', 'title')->ignore($item['id'] ? $item['id'] : null, 'id')
            ];
            $rules["$key.capacity"] = 'nullable|numeric';
            $customMessages["$key.title.required"] = 'The title is required at row.'.($key+2);
            $customMessages["$key.title.unique"] = 'The title must be unique at row.'.($key+2);
            $customMessages["$key.capacity.numeric"] = 'The title must be numeric at row.'.($key+2);
        }
       
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        // Validator::make($rows->toArray(), [
        //     '*.title' => [
        //             'required',
        //             Rule::unique('your_table_name', 'title')->ignore(function ($attribute, $value, $parameters, $validator) {
        //                 // Check if the 'id' is not empty for the current item
        //                 return !empty($validator->getData('*.' . $attribute . '.id'));
        //             }, 'id')
        //         ],
        //     '*.capacity' => 'nullable|numeric',
        // ])->validate();
  

        foreach ($rows as $row) {
            if($row['id']){
                $classRoom= ClassRoom::find($row['id']);
                if($classRoom){
                    $classRoom->title = $row['title'];
                    $classRoom->slug = Str::slug($row['title'], '-');
                    $classRoom->floor = $row['floor'];
                    $classRoom->capacity = $row['capacity'];
                    $classRoom->type = $row['type'];
                    $classRoom->save();
                }
            }else{
                $classRoom = ClassRoom::where('title','like', $row['title'])->first();
                if(!$classRoom){
                    ClassRoom::create(
                        [
                         'title'     => $row['title'],
                         'slug'     => Str::slug($row['title'], '-'),
                         'floor'     => $row['floor'],
                         'capacity'     => $row['capacity'],
                         'type'     => $row['type'],
                     ]);
                }
            }
        }
    }
}
