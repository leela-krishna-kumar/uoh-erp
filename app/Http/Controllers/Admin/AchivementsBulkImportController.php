<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FundedResearchExport;
use App\Exports\StaffBookPublishionExport;
use App\Exports\JournalsExport;
use App\Exports\SeedgrantsExport;
use App\Exports\PatentExport;
use App\Exports\AwardsExport;
use App\Exports\StaffConductedWorkshopsExport;
use App\Http\Controllers\Controller;
use App\Imports\FundedResearchImport;
use App\Imports\StaffBookPublishionImport;
use App\Imports\JournalsImport;
use App\Imports\SeedgrantsImport;
use App\Imports\PatentImport;
use App\Imports\AwardsImport;
use App\Imports\StaffConductedWorkshopsImport;
use App\Models\Address;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Toastr;


class AchivementsBulkImportController extends Controller
{

    public function __construct()
    {
        // Module Data
        $this->title = 'Faculty Achivements Bulk Import';
        $this->route = '';
        $this->view = 'admin.faculty_achievements.bulk-import';
        $this->path = 'faculty-achievements-bulk-import';
        $this->access = 'faculty-achievements-bulk-import';


        $this->middleware('permission:'.$this->access.'-view');
    }

    public function index()
    {

        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        return view($this->view.'.index', $data);


    }

  /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request, $table)
    {
        // return $request->all();
        // Field Validation
        $request->validate([
            'import' => 'required|file',
            // 'import' => 'required|file|mimes:csv',
        ]);
        //
        if($table == 'staff_book_publishions'){
            Excel::import(new StaffBookPublishionImport, $request->file('import'));
        }
        elseif($table == 'journals'){
            Excel::import(new JournalsImport, $request->file('import'));
        }
        elseif($table == 'seedgrants'){

            Excel::import(new SeedgrantsImport, $request->file('import'));
        }
        elseif($table == 'funded_research'){
            Excel::import(new FundedResearchImport, $request->file('import'));
        }
        elseif($table == 'patent'){

            Excel::import(new PatentImport, $request->file('import'));
        }
        elseif($table == 'awards'){

            Excel::import(new AwardsImport, $request->file('import'));
        }
        elseif($table == 'staff_conducted_workshops'){

            Excel::import(new StaffConductedWorkshopsImport, $request->file('import'));
        }

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

      /**
    * @return \Illuminate\Support\Collection
    */
    public function export($table)
    {
        //
        if($table == 'staff_book_publishions'){

            return Excel::download(new StaffBookPublishionExport, date('d-m-y').'_staff_book_publishions.csv');
        }
        elseif($table == 'journals'){

            return Excel::download(new JournalsExport, date('d-m-y').'_journals.csv');
        }
        elseif($table == 'seedgrants'){

            return Excel::download(new SeedgrantsExport, date('d-m-y').'_seedgrants.csv');
        }
        elseif($table == 'funded_research'){
            return Excel::download(new FundedResearchExport, date('d-m-y').'_funded_research.csv');
        }
        elseif($table == 'patent'){
            return Excel::download(new PatentExport, date('d-m-y').'_patent.csv');
        }
        elseif($table == 'awards'){

            return Excel::download(new AwardsExport, date('d-m-y').'_awards.csv');
        }
        elseif($table == 'staff_conducted_workshops'){
            return Excel::download(new StaffConductedWorkshopsExport, date('d-m-y').'_staff_conducted_workshops.csv');
        }

        return redirect()->back();
    }

}
