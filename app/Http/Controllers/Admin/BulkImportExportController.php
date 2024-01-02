<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApplicationsExport;
use App\Imports\ApplicationsImport;
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use App\Exports\QuestionBankExport;
use App\Imports\QuestionBankImport;
use App\Exports\eCourseExport;
use App\Imports\eCourseImport;
use App\Exports\eLessonExport;
use App\Imports\eLessonImport;
use App\Exports\eSectionExport;
use App\Imports\eSectionImport;
use App\Exports\SubjectsExport;
use App\Exports\StudentEnrollSubjectExport;
use App\Imports\StudentEnrollSubjectImport;
use App\Imports\SubjectsImport;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Exports\ProjectExport;
use App\Imports\ProjectImport;
use App\Exports\BooksExport;
use App\Imports\BooksImport;
use App\Exports\FacultiesExport;
use App\Imports\FacultiesImport;
use App\Exports\ProgramsExport;
use App\Imports\ProgramsImport;
use App\Exports\ChaptersExport;
use App\Imports\ChaptersImport;
use App\Exports\TopicsExport;
use App\Imports\TopicsImport;
use App\Exports\TestPaperExport;
use App\Imports\TestPaperImport;
use App\Exports\DesignationsExport;
use App\Imports\DesignationsImport;
use App\Exports\ClassRoomsExport;
use App\Imports\ClassRoomsImport;
use Toastr;

class BulkImportExportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_bulk_upload_download', 1);
        $this->route = 'admin.bulk-import-export';
        $this->view = 'admin.bulk-import-export';
        $this->path = 'bulk-import-export';
        $this->access = 'bulk-import-export';


        $this->middleware('permission:'.$this->access.'-view');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function importExportView()
    {
        //
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
    public function export($table)
    {
        //
        if($table == 'users'){

            return Excel::download(new UsersExport, date('d-m-y').'_staffs.csv');
        }
        elseif($table == 'students'){

            return Excel::download(new StudentsExport, date('d-m-y').'_students.csv');
        }
        elseif($table == 'subjects'){

            return Excel::download(new SubjectsExport, date('d-m-y').'_subjects.csv');
        }
        elseif($table == 'books'){

            return Excel::download(new BooksExport, date('d-m-y').'_books.csv');
        }
        elseif($table == 'applications'){
            return Excel::download(new ApplicationsExport, date('d-m-y').'_applications.csv');
        } 
        elseif($table == 'faculties'){

            return Excel::download(new FacultiesExport, date('d-m-y').'_faculties.csv');
        }
        elseif($table == 'programs'){
            return Excel::download(new ProgramsExport, date('d-m-y').'_programs.csv');
        }
        elseif($table == 'chapters'){
            return Excel::download(new ChaptersExport, date('d-m-y').'_chapters.csv');
        }
        elseif($table == 'topics'){
            return Excel::download(new TopicsExport, date('d-m-y').'_topics.csv');
        }
        elseif($table == 'designations'){
            return Excel::download(new DesignationsExport, date('d-m-y').'_designations.csv');
        }
        elseif($table == 'class_rooms'){
            return Excel::download(new ClassRoomsExport, date('d-m-y').'_class_rooms.csv');
        }
        elseif($table == 'student_enroll_subject'){
            return Excel::download(new StudentEnrollSubjectExport, date('d-m-y').'_subject_add_drop.csv');
        }
        elseif($table == 'projects'){
            return Excel::download(new ProjectExport, date('d-m-y').'_projects.csv');
        }
        elseif($table == 'e_courses'){
            return Excel::download(new eCourseExport, date('d-m-y').'_ecourse.csv');
        }
        elseif($table == 'e_lessons'){
            return Excel::download(new eLessonExport, date('d-m-y').'_elesson.csv');
        }
        elseif($table == 'e_sections'){
            return Excel::download(new eSectionExport, date('d-m-y').'_esection.csv');
        }
        elseif($table == 'question_banks'){
            return Excel::download(new QuestionBankExport, date('d-m-y').'_question_bank.csv');
        }
        elseif($table == 'test_papers'){
            return Excel::download(new TestPaperExport, date('d-m-y').'_test_paper.csv');
        }

        return redirect()->back();
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request, $table)
    {
        // Field Validation
        $request->validate([
            'import' => 'required|file',
            // 'import' => 'required|file|mimes:csv',
        ]);

        //
        if($table == 'users'){

            Excel::import(new UsersImport, $request->file('import'));
        }
        elseif($table == 'students'){

            Excel::import(new StudentsImport, $request->file('import'));
        }
        elseif($table == 'subjects'){

            Excel::import(new SubjectsImport, $request->file('import'));
        }
        elseif($table == 'books'){

            Excel::import(new BooksImport, $request->file('import'));
        }
        elseif($table == 'applications'){

            Excel::import(new ApplicationsImport, $request->file('import'));
        }
        elseif($table == 'faculties'){

            Excel::import(new FacultiesImport, $request->file('import'));
        }
        elseif($table == 'programs'){

            Excel::import(new ProgramsImport, $request->file('import'));
        }
        elseif($table == 'chapters'){

            Excel::import(new ChaptersImport, $request->file('import'));
        } elseif($table == 'topics'){

            Excel::import(new TopicsImport, $request->file('import'));
        }elseif($table == 'designations'){

            Excel::import(new DesignationsImport, $request->file('import'));
        }elseif($table == 'class_rooms'){

            Excel::import(new ClassRoomsImport, $request->file('import'));
        }elseif($table == 'student_enroll_subject'){
            Excel::import(new StudentEnrollSubjectImport,$request->file('import'));
        }elseif($table == 'projects'){
            Excel::import(new ProjectImport,$request->file('import'));
        }elseif($table == 'e_courses'){
            Excel::import(new eCourseImport,$request->file('import'));
        }elseif($table == 'e_lessons'){
            Excel::import(new eLessonImport,$request->file('import'));
        }elseif($table == 'e_sections'){
            Excel::import(new eSectionImport,$request->file('import'));
        }elseif($table == 'question_banks'){
            Excel::import(new QuestionBankImport,$request->file('import'));
        }elseif($table == 'test_papers'){
            Excel::import(new TestPaperImport,$request->file('import'));
        }
        

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
