<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Imports\CreateOrUpdateImport;
use App\Imports\MultiDataImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Toastr;


class DataUpdateController extends Controller
{
    /**
   * Create a new controller instance.
   *
   * @return void
   */
   public function __construct()
   {
      // Module Data
      $this->title = 'Data Upload';
      $this->route = 'dashboard';
      $this->view = 'data-upolad';
   }

    public function create()
    {
        // $data = env('DB_DATABASE');
        // return $data;
        $tables = Schema::getAllTables();
        return view('data-upolad.create',compact('tables'));
    }

    public function getTableColumns(Request $request)
    {
        $table_name = $request->tableName;
        $columns = Schema::getColumnListing($table_name);
        return response()->json($columns);
    }

    public function updateTableData(Request $request)
    {
        set_time_limit(10000);
        // return $request->all();
        $request->validate([
            'import' => 'required|file',
            // 'numberOfColumns' => 'required|numeric',
            // 'Refcolumn' => 'required',
            'ColumnNamesMul' => 'required',
            'tableName' => 'required',
        ]);

        if ($request->hasFile('import')){
            $file = $request->file('import');
            $columns_in_file =  Excel::toCollection([], $file)->first()[0]->toArray();
            $selected_columns = $request->ColumnNamesMul;
            if ($request->action == 'update'){
                array_push($selected_columns, $request->Refcolumn);
            } elseif ($request->action == 'update_or_create'){
                array_push($selected_columns, $request->Refcolumn);
                if (!empty($request->update_columns)){
                $selected_columns = array_merge($selected_columns,$request->update_columns);
                }
            }
            // return $selected_columns;
            $difference_columns = array_diff($selected_columns,$columns_in_file);
            // $difference_columns_1 = array_diff($columns_in_file, $selected_columns);

            if (!empty($difference_columns)){
                Toastr::error('columns mismatch ('.implode(', ',$difference_columns).')' , __('msg_error'));
                return redirect()->back();
            }
            if ($request->action == 'update_or_create'){
                $import = new CreateOrUpdateImport($request);
                $update_data = Excel::import($import, $request->file('import'));
            } else {
                $import = new MultiDataImport($request);
                $update_data = Excel::import($import, $request->file('import'));
            }

            if ($import->getImportStatus()) {
                Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            } else {
                Toastr::error('failed, '.$import->getErrorMessage(), __('msg_error'));
            }
            return redirect()->back();
        }
    }
}
