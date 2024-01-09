<?php

namespace App\Imports;

use App\Models\Book;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;

class BooksImport implements ToCollection, WithHeadingRow
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
            // $rules["$key.isbn"] = [
            //     'required',
            //     Rule::unique('books', 'isbn')->ignore($item['id'] ? $item['id'] : null, 'id')
            // ];

            // $rules["$key.isbn"] =  'required|max:30';
            // $rules["$key.author"] =  'required';
            // $rules["$key.quantity"] =  'required|numeric';
            //  $rules["$key.price"] =  'nullable|numeric';
            // $rules["$key.status"] =  'nullable|integer'; //direct  value 1


            // $rules["$key.category_id"] =  'nullable|integer'; // for all 1
            $rules["$key.title"] =  'required|max:191';
            $rules["$key.accession_no"] =  'required';

            // $customMessages["$key.isbn.unique"] = 'The isbn must be unique at row.'.($key+2);
            // $customMessages["$key.isbn.required"] = 'The isbn is required at row.'.($key+2);
            // $customMessages["$key.isbn.max"] = 'The isbn may not be greater than 30.'.($key+2);
            // $customMessages["$key.category_id.required"] = 'The category id is required at row.'.($key+2);
            // $customMessages["$key.author.required"] = 'The author is required at row.'.($key+2);
            // $customMessages["$key.price.numeric"] = 'The price must be numeric at row.'.($key+2);
            // $customMessages["$key.quantity.required"] = 'The quantity is required at row.'.($key+2);
            // $customMessages["$key.quantity.numeric"] = 'The quantity must be numeric at row.'.($key+2);
            // $customMessages["$key.status.required"] = 'The status is required at row.'.($key+2);

            $customMessages["$key.title.required"] = 'The title is required at row.'.($key+2);
            $customMessages["$key.accession_no.required"] = 'The accession no is required at row.'.($key+2);
        }

        $validator = Validator::make($data, $rules);
        // Log::info('data valication pass ');
        // Log::info($validator);
        $validator->validate();

        // Validator::make($rows->toArray(), [
        //     '*.category_id' => 'required|integer',
        //     '*.title' => 'required|max:191',
        //     '*.isbn' => 'required|max:30',
        //     '*.author' => 'required',
        //     '*.price' => 'nullable|numeric',
        //     '*.quantity' => 'required|numeric',
        //     '*.status' => 'required|integer',
        // ])->validate();


        // foreach ($rows as $row) {
        //     Book::updateOrCreate(
        //         [
        //         'isbn'    => $row['isbn'],
        //         ],[
        //         'category_id'     => $row['category_id'],
        //         'title'    => $row['title'],
        //         'isbn'    => $row['isbn'],
        //         'author'    => $row['author'],
        //         'publisher'    => $row['publisher'],
        //         'edition'    => $row['edition'],
        //         'publish_year'    => $row['publish_year'],
        //         'language'    => $row['language'],
        //         'price'    => $row['price'],
        //         'quantity'    => $row['quantity'],
        //         'section'    => $row['section'],
        //         'column'    => $row['column'],
        //         'row'    => $row['row'],
        //         'description'    => $row['description'],
        //         'note'    => $row['note'],
        //         'status'    => $row['status'],
        //         'acc_no'    => $row['accession_no'],
        //     ]);
        // }
        $i = 1;
        foreach ($rows as $row) {
            if (empty($row['isbn'])){
                $row['isbn'] =  $row['accession_no'];
            }
            $row['isbn'] = $row['isbn'].'-'.$i++.rand(0,1);
            // Log::info( $row['isbn']);
            Book::create(
                // [
                // 'isbn'    => $row['isbn'],
                // ],
                [
                'edition' =>$row['edition'],
                'category_id'     => 1, // by default considering as a general category
                'title'    => $row['title'],
                'isbn'    => $row['isbn'],
                'volume'  => $row['volume'],
                'price'    => intval($row['price']),
                'no_of_pages' =>$row['no_of_pages'],
                'call_no'  => $row['call_no'],
                'invoice_no'  => $row['invoice_no'],
                'acc_no'     => $row['accession_no'],
                'publisher'  => $row['publisher'],
                'supplier'  => $row['supplier'],
                'publish_year'  => $row['publish_year'],
                'status'    => 1, // by default considering as Available
            ]);
        }
    }
}
