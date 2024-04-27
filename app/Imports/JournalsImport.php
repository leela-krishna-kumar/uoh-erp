<?php

namespace App\Imports;

use App\Models\Journal;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;

class JournalsImport implements ToCollection, WithHeadingRow
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
            $rules["$key.title_of_paper"] =  'required';
            $rules["$key.name_of_the_journal"] =  'required';
            $rules["$key.journal_website_link"] =  'required';
            $customMessages["$key.title_of_paper.required"] = 'The title_of_paper required at row.' . ($key + 2);
            $customMessages["$key.name_of_the_journal.required"] = 'The name_of_the_journal is required at row.'.($key+2);
            $customMessages["$key.journal_website_link.required"] = 'The journal_website_link is required at row.'.($key+2);
        }
        $validator = Validator::make($data, $rules);
        $validator->setCustomMessages($customMessages);
        $validator->validate();

        foreach ($rows as $row) {
            $array = [$row['name_of_the_author']];
            $new_journal = Journal::create(
                [
                    'staff_id' => Auth::user()->staff_id ,
                    'title_of_paper' => $row['title_of_paper'],
                    'name_of_the_author' => json_encode($array),
                    'name_of_the_journal' => $row['name_of_the_journal'],
                    'year_of_publication' => $row['year_of_publication'],
                    'issn_number' => $row['issn_number'],
                    'journal_website_link' => $row['journal_website_link'],
                    'paper_abstract_article_link' => $row['paper_abstract_article_link'],

                ]
            );
        }
    }
}
