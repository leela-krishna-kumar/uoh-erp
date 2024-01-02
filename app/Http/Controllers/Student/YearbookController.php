<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use App\Models\YearBook;
use App\Models\Media;
use PhpOffice\PhpWord\IOFactory;

class YearbookController extends Controller
{
    use FileUploader;

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_year_book', 1);
        $this->route = 'student.yearbook';
        $this->view = 'student.yearbook';
        $this->path = 'year-book';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['rows'] = YearBook::orderBy('id', 'desc')->get();

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        
        return view('student.common.preview-files.iframe')->render();
   }
}
