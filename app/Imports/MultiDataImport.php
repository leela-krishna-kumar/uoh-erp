<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;


class MultiDataImport implements WithHeadingRow, OnEachRow
{
    protected $ref_column_name,$Column_names_mul,$table_name, $action;
    private $importSuccess = true;
    protected $error_meaasge = "";

    public function __construct(Request $request)
    {
        // $this->number_of_columns = $request->numberOfColumns;
        $this->ref_column_name = $request->Refcolumn;
        $this->Column_names_mul = $request->ColumnNamesMul;
        $this->table_name = $request->tableName;
        $this->action = $request->action;
    }


    public function onRow(Row $row)
    {
        try {
            $data_array = [];
            for ($x = 0; $x < count($this->Column_names_mul); $x++) {
                $colum_name = $this->Column_names_mul[$x];
                $column_value = $row[$colum_name];
                if ($column_value == 'NULL' || $column_value == 'null'){
                    $column_value = null;
                } else {
                    // Validate the column data
                    $this->validateColumn($colum_name, $column_value);
                }
                // Validate the column data
                // $this->validateColumn($colum_name, $column_value);
                $data_array[$colum_name] = $column_value;
            }
            // dd($data_array);
            if ($this->action == 'update') {
                // $data_array['updated_at'] = now();
                $update = DB::table($this->table_name)->where($this->ref_column_name, $row[$this->ref_column_name])->update($data_array);

            } elseif ($this->action == 'insert') {
                // $data_array['created_at'] = now();/
                // $data_array['updated_at'] = now();
                $insert = DB::table($this->table_name)->insert($data_array);
            }
            Log::info($this->action.'done '.$this->Column_names_mul[0] . " = "  .$row[$this->Column_names_mul[0]]);
        } catch (\Exception $e) {
            $this->importSuccess = false;
            Log::info('skipped '.$this->action.' '.$this->Column_names_mul[0] . " = "  .$row[$this->Column_names_mul[0]]);
            Log::error('Error during import: ' . $e->getMessage());
            $this->error_meaasge = $e->getMessage();
        }
    }
    protected function validateColumn($colum_name, $column_value)
    {
        $columnType = Schema::getColumnType($this->table_name, $colum_name);
        /*
        By default, varchar is considered as a string.
        By default, tinyint is considered as a boolean.
        By default, longtext is considered as a string.
        */
        if($columnType == 'text') {
            $columnType = 'string';
        } elseif ($columnType == 'bigint') {
            $columnType = 'integer';
        } elseif ($columnType == 'datetime') { //for timestap
            $columnType = 'date';
        } elseif ($columnType == 'float') { //for double
            $columnType = 'numeric';
        } elseif ($columnType == 'time'){
            $columnType ='';
        }
        $rules = [
            $colum_name => 'required|'.$columnType,
        ];
        // Log::info(gettype($column_value));
        // Log::info($colum_name.$column_value);
        // Log::info($rules);
        // dd($rules);
        $validator = Validator::make([$colum_name => $column_value], $rules);
        if ($validator->fails()) {
            $this->importSuccess = false;
            $errorMessage = "Validation error for column $colum_name: " . implode(', ', $validator->errors()->all());
            // Log::error($errorMessage);
            throw new \Exception($errorMessage);
            $this->error_meaasge = $errorMessage;
        }
        // Log::info(json_encode($validator));
    }

    public function getImportStatus()
    {
        return $this->importSuccess;
    }
    public function getErrorMessage()
    {
        return $this->error_meaasge;
    }
}
