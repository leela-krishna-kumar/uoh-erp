<?php

namespace App\Imports;

use App\Models\StaffBookPublish;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Auth;

class StaffBookPublishionImport implements ToCollection, WithHeadingRow
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
            $rules["$key.publication_year"] =  'required';
            $rules["$key.isbn_number"] =  'required';
            $rules["$key.same_affiliating_institute"] =  'required';
            $customMessages["$key.publication_year.required"] = 'The publication_year required at row.' . ($key + 2);
            $customMessages["$key.isbn_number.required"] = 'The isbn_number is required at row.'.($key+2);
            $customMessages["$key.same_affiliating_institute.required"] = 'The same_affiliating_institute is required at row.'.($key+2);
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            $new_publish = StaffBookPublish::create(
                [
                    'staff_id' => Auth::user()->staff_id ,
                    'published_book_title' => $row['published_book_title'],
                    'published_chapter_title' => $row['published_chapter_title'],
                    'publication_year' => $row['publication_year'],
                    'isbn_number' => $row['isbn_number'],
                    'same_affiliating_institute' => $row['same_affiliating_institute'],
                    'publisher_name' => $row['publisher_name'],
                ]
            );
        }
    }
}
