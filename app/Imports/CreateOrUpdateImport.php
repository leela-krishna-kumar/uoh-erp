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


class CreateOrUpdateImport implements WithHeadingRow, OnEachRow
{
    protected $ref_column_name, $update_columns, $create_columns, $table_name, $action;
    private $importSuccess = true;
    protected $error_meaasge = "";

    public function __construct(Request $request)
    {
        // $this->number_of_columns = $request->numberOfColumns;
        $this->ref_column_name = $request->Refcolumn;
        $this->create_columns = $request->ColumnNamesMul;
        $this->table_name = $request->tableName;
        $this->action = $request->action;
        $this->update_columns = $request->update_columns;
    }


    public function onRow(Row $row)
    {
        try {
            // dd($this->table_name,$this->ref_column_name,$row[$this->ref_column_name] );
            $record_exist =  DB::table($this->table_name)->where($this->ref_column_name, $row[$this->ref_column_name])->first();

            if ($record_exist) {
                // Log::info("inside exits");
                $data_array = [];
                if (!empty($this->update_columns)) {
                    for ($x = 0; $x < count($this->update_columns); $x++) {
                        $colum_name = $this->update_columns[$x];
                        $column_value = $row[$colum_name];
                        if ($column_value == 'NULL' || $column_value == 'null'){
                            $column_value = null;
                        } else {
                            // Validate the column data
                            $this->validateColumn($colum_name, $column_value);
                        }
                        $data_array[$colum_name] = $column_value;
                    }

                    $update = DB::table($this->table_name)->where($this->ref_column_name, $row[$this->ref_column_name])->update($data_array);
                    Log::info('updated record ' . $this->update_columns[0] . " = "  . $row[$this->update_columns[0]]);
                }
            } else {
                // Log::info("not exits");
                if (!empty($this->create_columns)) {
                    $create_array = [];
                    for ($x = 0; $x < count($this->create_columns); $x++) {
                        $colum_name = $this->create_columns[$x];
                        $column_value = $row[$colum_name];
                        if ($column_value == 'NULL' || $column_value == 'null'){
                            $column_value = null;
                        } else {
                            // Validate the column data
                            $this->validateColumn($colum_name, $column_value);
                        }

                        $create_array[$colum_name] = $column_value;
                    }
                    $update = DB::table($this->table_name)->insert($create_array);
                    Log::info('created new record ' . $this->create_columns[0] . " = "  . $row[$this->create_columns[0]]);
                }
            }
        } catch (\Exception $e) {
            $this->importSuccess = false;
            // Log::info('skipped ' . $this->action . ' ' . $this->create_columns[0] . " = "  . $row[$this->create_columns[0]]);
            Log::info('skipped one record');
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
        if ($columnType == 'text') {
            $columnType = 'string';
        } elseif ($columnType == 'bigint') {
            $columnType = 'integer';
        } elseif ($columnType == 'datetime') { //for timestap
            $columnType = 'date';
        } elseif ($columnType == 'float') { //for double
            $columnType = 'numeric';
        } elseif ($columnType == 'time') {
            $columnType = '';
        }
        $rules = [
            $colum_name => 'required|' . $columnType,
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
